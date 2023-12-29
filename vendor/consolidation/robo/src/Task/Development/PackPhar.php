<?php

namespace Robo\Task\Development;

use Robo\Contract\ProgressIndicatorAwareInterface;
use Robo\Contract\PrintedInterface;
use Robo\Result;
use Robo\Task\BaseTask;

/**
 * Creates Phar.
 *
 * ``` php
 * <?php
 * $pharTask = $this->taskPackPhar('package/codecept.phar')
 *   ->compress()
 *   ->stub('package/stub.php');
 *
 *  $finder = Finder::create()
 *      ->name('*.php')
 *        ->in('src');
 *
 *    foreach ($finder as $file) {
 *        $pharTask->addFile('src/'.$file->getRelativePathname(), $file->getRealPath());
 *    }
 *
 *    $finder = Finder::create()->files()
 *        ->name('*.php')
 *        ->in('vendor');
 *
 *    foreach ($finder as $file) {
 *        $pharTask->addStripped('vendor/'.$file->getRelativePathname(), $file->getRealPath());
 *    }
 *    $pharTask->run();
 *
 *    // verify Phar is packed correctly
 *    $code = $this->_exec('php package/codecept.phar');
 * ?>
 * ```
 */
class PackPhar extends BaseTask implements PrintedInterface, ProgressIndicatorAwareInterface
{
    /**
     * @var \Phar
     */
    protected $phar;

    /**
     * @var null|string
     */
    protected $compileDir = null;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var bool
     */
    protected $compress = false;

    protected $stub;

    protected $bin;

    /**
     * @var string
     */
    protected $stubTemplate = <<<EOF
#!/usr/bin/env php
<?php
Phar::mapPhar();
%s
__HALT_COMPILER();
EOF;

    /**
     * @var string[]
     */
    protected $files = [];

    /**
     * {@inheritdoc}
     */
    public function getPrinted()
    {
        return true;
    }

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $file = new \SplFileInfo($filename);
        $this->filename = $filename;
        if (file_exists($file->getRealPath())) {
            @unlink($file->getRealPath());
        }
        $this->phar = new \Phar($file->getPathname(), 0, $file->getFilename());
    }

    /**
     * @param bool $compress
     *
     * @return $this
     */
    public function compress($compress = true)
    {
        $this->compress = $compress;
        return $this;
    }

    /**
     * @param string $stub
     *
     * @return $this
     */
    public function stub($stub)
    {
        $this->phar->setStub(file_get_contents($stub));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function progressIndicatorSteps()
    {
        // run() will call advanceProgressIndicator() once for each
        // file, one after calling stopBuffering, and again after compression.
        return count($this->files) + 2;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Creating {filename}', ['filename' => $this->filename]);
        $this->phar->setSignatureAlgorithm(\Phar::SHA1);
        $this->phar->startBuffering();

        $this->printTaskInfo('Packing {file-count} files into phar', ['file-count' => count($this->files)]);

        $this->startProgressIndicator();
        foreach ($this->files as $path => $content) {
            $this->phar->addFromString($path, $content);
            $this->advanceProgressIndicator();
        }
        $this->phar->stopBuffering();
        $this->advanceProgressIndicator();

        if ($this->compress and in_array('GZ', \Phar::getSupportedCompression())) {
            if (count($this->files) > 1000) {
                $this->printTaskInfo('Too many files. Compression DISABLED');
            } else {
                $this->printTaskInfo('{filename} compressed', ['filename' => $this->filename]);
                $this->phar = $this->phar->compressFiles(\Phar::GZ);
            }
        }
        $this->advanceProgressIndicator();
        $this->stopProgressIndicator();
        $this->printTaskSuccess('{filename} produced', ['filename' => $this->filename]);
        return Result::success($this, '', ['time' => $this->getExecutionTime()]);
    }

    /**
     * @param string $path
     * @param string $file
     *
     * @return $this
     */
    public function addStripped($path, $file)
    {
        $this->files[$path] = $this->stripWhitespace(file_get_contents($file));
        return $this;
    }

    /**
     * @param string $path
     * @param string $file
     *
     * @return $this
     */
    public function addFile($path, $file)
    {
        $this->files[$path] = file_get_contents($file);
        return $this;
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo[] $files
     */
    public function addFiles($files)
    {
        foreach ($files as $file) {
            $this->addFile($file->getRelativePathname(), $file->getRealPath());
        }
    }

    /**
     * @param string $file
     *
     * @return $this
     */
    public function executable($file)
    {
        $source = file_get_contents($file);
        if (strpos($source, '#!/usr/bin/env php') === 0) {
            $source = substr($source, strpos($source, '<?php') + 5);
        }
        $this->phar->setStub(sprintf($this->stubTemplate, $source));
        return $this;
    }

    /**
     * Strips whitespace from source. Taken from composer
     *
     * @param string $source
     *
     * @return string
     */
    private function stripWhitespace($source)
    {
        if (!function_exists('token_get_all')) {
            return $source;
        }

        $output = '';
        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                if (substr($token[1], 0, 2) === '#[') {
                    // Don't strip annotations
                    $output .= $token[1];
                } else {
                    $output .= str_repeat("\n", substr_count($token[1], "\n"));
                }
            } elseif (T_WHITESPACE === $token[0]) {
                // reduce wide spaces
                $whitespace = preg_replace('{[ \t]+}', ' ', $token[1]);
                // normalize newlines to \n
                $whitespace = preg_replace('{(?:\r\n|\r|\n)}', "\n", $whitespace);
                // trim leading spaces
                $whitespace = preg_replace('{\n +}', "\n", $whitespace);
                $output .= $whitespace;
            } else {
                $output .= $token[1];
            }
        }

        return $output;
    }
}
