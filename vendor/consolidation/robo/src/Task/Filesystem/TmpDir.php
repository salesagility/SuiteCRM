<?php

namespace Robo\Task\Filesystem;

use Robo\Result;
use Robo\Contract\CompletionInterface;

/**
 * Create a temporary directory that is automatically cleaned up
 * once the task collection is is part of completes.
 *
 * Use WorkDir if you do not want the directory to be deleted.
 *
 * ``` php
 * <?php
 * // Delete on rollback or on successful completion.
 * // Note that in this example, everything is deleted at
 * // the end of $collection->run().
 * $collection = $this->collectionBuilder();
 * $tmpPath = $collection->tmpDir()->getPath();
 * $collection->taskFilesystemStack()
 *           ->mkdir("$tmpPath/log")
 *           ->touch("$tmpPath/log/error.txt");
 * $collection->run();
 * // as shortcut (deleted when program exits)
 * $tmpPath = $this->_tmpDir();
 * ?>
 * ```
 */
class TmpDir extends BaseDir implements CompletionInterface
{
    /**
     * @var string
     */
    protected $base;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var bool
     */
    protected $cwd;

    /**
     * @var string
     */
    protected $savedWorkingDirectory;

    /**
     * @param string $prefix
     * @param string $base
     * @param bool $includeRandomPart
     */
    public function __construct($prefix = 'tmp', $base = '', $includeRandomPart = true)
    {
        if (empty($base)) {
            $base = sys_get_temp_dir();
        }
        $path = "{$base}/{$prefix}";
        if ($includeRandomPart) {
            $path = static::randomLocation($path);
        }
        parent::__construct(["$path"]);
    }

    /**
     * Add a random part to a path, ensuring that the directory does
     * not (currently) exist.
     *
     * @param string $path The base/prefix path to add a random component to
     * @param int $length Number of digits in the random part
     *
     * @return string
     */
    protected static function randomLocation($path, $length = 12)
    {
        $random = static::randomString($length);
        while (is_dir("{$path}_{$random}")) {
            $random = static::randomString($length);
        }
        return "{$path}_{$random}";
    }

    /**
     * Generate a suitably random string to use as the suffix for our
     * temporary directory.
     *
     * @param int $length
     *
     * @return string
     */
    protected static function randomString($length = 12)
    {
        return substr(str_shuffle('23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ'), 0, max($length, 3));
    }

    /**
     * Flag that we should cwd to the temporary directory when it is
     * created, and restore the old working directory when it is deleted.
     *
     * @param bool $shouldChangeWorkingDirectory
     *
     * @return $this
     */
    public function cwd($shouldChangeWorkingDirectory = true)
    {
        $this->cwd = $shouldChangeWorkingDirectory;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // Save the current working directory
        $this->savedWorkingDirectory = getcwd();
        foreach ($this->dirs as $dir) {
            $this->fs->mkdir($dir);
            $this->printTaskInfo("Created {dir}...", ['dir' => $dir]);

            // Change the current working directory, if requested
            if ($this->cwd) {
                chdir($dir);
            }
        }

        return Result::success($this, '', ['path' => $this->getPath()]);
    }

    protected function restoreWorkingDirectory()
    {
        // Restore the current working directory, if we redirected it.
        if ($this->cwd) {
            chdir($this->savedWorkingDirectory);
        }
    }

    protected function deleteTmpDir()
    {
        foreach ($this->dirs as $dir) {
            $this->fs->remove($dir);
        }
    }

    /**
     * Delete this directory when our collection completes.
     * If this temporary directory is not part of a collection,
     * then it will be deleted when the program terminates,
     * presuming that it was created by taskTmpDir() or _tmpDir().
     */
    public function complete()
    {
        $this->restoreWorkingDirectory();
        $this->deleteTmpDir();
    }

    /**
     * Get a reference to the path to the temporary directory, so that
     * it may be used to create other tasks.  Note that the directory
     * is not actually created until the task runs.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->dirs[0];
    }
}
