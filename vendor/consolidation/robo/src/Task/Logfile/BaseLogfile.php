<?php

namespace Robo\Task\Logfile;

use Robo\Task\BaseTask;
use Symfony\Component\Filesystem\Filesystem;

abstract class BaseLogfile extends BaseTask
{
    /**
     * @var string|string[] Array with log files.
     */
    protected $logfiles = [];

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var int|bool Octal file mode for log files like 0600.
     */
    protected $chmod = false;

    /**
     * @param string|string[] $logfiles
     */
    public function __construct($logfiles)
    {
        is_array($logfiles)
            ? $this->logfiles = $logfiles
            : $this->logfiles[] = $logfiles;

        $this->filesystem = new Filesystem();
    }

    /**
     * @param int $chmod
     * @return $this
     */
    public function chmod(int $chmod)
    {
        $this->chmod = $chmod;

        return $this;
    }
}
