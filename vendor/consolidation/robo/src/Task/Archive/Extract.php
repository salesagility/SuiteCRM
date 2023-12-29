<?php

namespace Robo\Task\Archive;

use Robo\Result;
use Robo\Task\BaseTask;
use Robo\Task\Filesystem\Tasks as FilesystemTaskLoader;
use Robo\Contract\BuilderAwareInterface;
use Robo\TaskAccessor;

/**
 * Extracts an archive.
 *
 * Note that often, distributions are packaged in tar or zip archives
 * where the topmost folder may contain variable information, such as
 * the release date, or the version of the package.  This information
 * is very useful when unpacking by hand, but arbitrarily-named directories
 * are much less useful to scripts.  Therefore, by default, Extract will
 * remove the top-level directory, and instead store all extracted files
 * into the directory specified by $archivePath.
 *
 * To keep the top-level directory when extracting, use
 * `preserveTopDirectory(true)`.
 *
 * ``` php
 * <?php
 * $this->taskExtract($archivePath)
 *  ->to($destination)
 *  ->preserveTopDirectory(false) // the default
 *  ->run();
 * ?>
 * ```
 */
class Extract extends BaseTask implements BuilderAwareInterface
{
    use TaskAccessor;
    use FilesystemTaskLoader;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var bool
     */
    private $preserveTopDirectory = false;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Location to store extracted files.
     *
     * @param string $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param bool $preserve
     *
     * @return $this
     */
    public function preserveTopDirectory($preserve = true)
    {
        $this->preserveTopDirectory = $preserve;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!file_exists($this->filename)) {
            $this->printTaskError("File {filename} does not exist", ['filename' => $this->filename]);

            return false;
        }
        if (!($mimetype = static::archiveType($this->filename))) {
            $this->printTaskError("Could not determine type of archive for {filename}", ['filename' => $this->filename]);

            return false;
        }

        $umask = 0777 - umask();

        // We will first extract to $extractLocation and then move to $this->to
        $extractLocation = $this->getTempDir();
        @mkdir($extractLocation, $umask, true);

        $destinationParentDir = dirname($this->to);
        if (!file_exists($destinationParentDir)) {
            @mkdir($destinationParentDir, $umask, true);
        }

        $this->startTimer();

        $this->printTaskInfo("Extracting {filename}", ['filename' => $this->filename]);

        $result = $this->extractAppropriateType($mimetype, $extractLocation);
        if ($result->wasSuccessful()) {
            $this->printTaskInfo("{filename} extracted", ['filename' => $this->filename]);
            // Now, we want to move the extracted files to $this->to. There
            // are two possibilities that we must consider:
            //
            // (1) Archived files were encapsulated in a folder with an arbitrary name
            // (2) There was no encapsulating folder, and all the files in the archive
            //     were extracted into $extractLocation
            //
            // In the case of (1), we want to move and rename the encapsulating folder
            // to $this->to.
            //
            // In the case of (2), we will just move and rename $extractLocation.
            $filesInExtractLocation = glob("$extractLocation/*");
            $hasEncapsulatingFolder = ((count($filesInExtractLocation) == 1) && is_dir($filesInExtractLocation[0]));
            if ($hasEncapsulatingFolder && !$this->preserveTopDirectory) {
                $this
                    ->taskFilesystemStack()
                    ->rename($filesInExtractLocation[0], $this->to)
                    ->remove($extractLocation)
                    ->run();
            } else {
                $this
                    ->taskFilesystemStack()
                    ->rename($extractLocation, $this->to)
                    ->run();
            }
        }
        $this->stopTimer();
        $result['time'] = $this->getExecutionTime();

        return $result;
    }

    /**
     * @param string $mimetype
     * @param string $extractLocation
     *
     * @return \Robo\Result
     */
    protected function extractAppropriateType($mimetype, $extractLocation)
    {
        // Perform the extraction of a zip file.
        if (($mimetype == 'application/zip') || ($mimetype == 'application/x-zip')) {
            return $this->extractZip($extractLocation);
        }
        return $this->extractTar($extractLocation);
    }

    /**
     * @param string $extractLocation
     *
     * @return \Robo\Result
     */
    protected function extractZip($extractLocation)
    {
        if (!extension_loaded('zlib')) {
            return Result::errorMissingExtension($this, 'zlib', 'zip extracting');
        }

        $zip = new \ZipArchive();
        if (($status = $zip->open($this->filename)) !== true) {
            return Result::error($this, "Could not open zip archive {$this->filename}");
        }
        if (!$zip->extractTo($extractLocation)) {
            return Result::error($this, "Could not extract zip archive {$this->filename}");
        }
        $zip->close();

        return Result::success($this);
    }

    /**
     * @param string $extractLocation
     *
     * @return \Robo\Result
     */
    protected function extractTar($extractLocation)
    {
        if (!class_exists('Archive_Tar')) {
            return Result::errorMissingPackage($this, 'Archive_Tar', 'pear/archive_tar');
        }
        $tar_object = new \Archive_Tar($this->filename);
        if (!$tar_object->extract($extractLocation)) {
            return Result::error($this, "Could not extract tar archive {$this->filename}");
        }

        return Result::success($this);
    }

    /**
     * @param string $filename
     *
     * @return bool|string
     */
    protected static function archiveType($filename)
    {
        $content_type = false;
        if (class_exists('finfo')) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $content_type = $finfo->file($filename);
            // If finfo cannot determine the content type, then we will try other methods
            if ($content_type == 'application/octet-stream') {
                $content_type = false;
            }
        }
        // Examing the file's magic header bytes.
        if (!$content_type) {
            if ($file = fopen($filename, 'rb')) {
                $first = fread($file, 2);
                fclose($file);
                if ($first !== false) {
                    // Interpret the two bytes as a little endian 16-bit unsigned int.
                    $data = unpack('v', $first);
                    switch ($data[1]) {
                        case 0x8b1f:
                            // First two bytes of gzip files are 0x1f, 0x8b (little-endian).
                            // See https://www.gzip.org/zlib/rfc-gzip.html#header-trailer
                            $content_type = 'application/x-gzip';
                            break;

                        case 0x4b50:
                            // First two bytes of zip files are 0x50, 0x4b ('PK') (little-endian).
                            // See https://en.wikipedia.org/wiki/Zip_(file_format)#File_headers
                            $content_type = 'application/zip';
                            break;

                        case 0x5a42:
                            // First two bytes of bzip2 files are 0x5a, 0x42 ('BZ') (big-endian).
                            // See https://en.wikipedia.org/wiki/Bzip2#File_format
                            $content_type = 'application/x-bzip2';
                            break;
                    }
                }
            }
        }
        // 3. Lastly if above methods didn't work, try to guess the mime type from
        // the file extension. This is useful if the file has no identificable magic
        // header bytes (for example tarballs).
        if (!$content_type) {
            // Remove querystring from the filename, if present.
            $filename = basename(current(explode('?', $filename, 2)));
            $extension_mimetype = array(
                '.tar.gz' => 'application/x-gzip',
                '.tgz' => 'application/x-gzip',
                '.tar' => 'application/x-tar',
            );
            foreach ($extension_mimetype as $extension => $ct) {
                if (substr($filename, -strlen($extension)) === $extension) {
                    $content_type = $ct;
                    break;
                }
            }
        }

        return $content_type;
    }

    /**
     * @return string
     */
    protected function getTempDir()
    {
        return $this->to . '-tmp' . rand() . time();
    }

    /**
     * @deprecated Use $this->getTempDir() instead.
     *
     * @return string
     *
     * @see getTempDir
     */
    protected static function getTmpDir()
    {
        return getcwd() . '/tmp' . rand() . time();
    }
}
