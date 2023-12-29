<?php

namespace Robo\Task\Filesystem;

use Robo\Task\BaseTask;
use Symfony\Component\Filesystem\Filesystem as sfFilesystem;

abstract class BaseDir extends BaseTask
{
    /**
     * @var string[]
     */
    protected $dirs = [];

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * @param string|string[] $dirs
     */
    public function __construct($dirs)
    {
        is_array($dirs)
            ? $this->dirs = $dirs
            : $this->dirs[] = $dirs;

        $this->fs = new sfFilesystem();
    }
}
