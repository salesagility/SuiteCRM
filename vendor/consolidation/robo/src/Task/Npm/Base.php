<?php

namespace Robo\Task\Npm;

use Robo\Task\BaseTask;
use Robo\Exception\TaskException;
use Robo\Common\ExecOneCommand;

abstract class Base extends BaseTask
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command = '';

    /**
     * @var string[]
     */
    protected $opts = [];

    /**
     * @var string
     */
    protected $action = '';

    /**
     * adds `production` option to npm
     *
     * @return $this
     */
    public function noDev()
    {
        $this->option('production');
        return $this;
    }

    /**
     * @param null|string $pathToNpm
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToNpm = null)
    {
        $this->command = $pathToNpm;
        if (!$this->command) {
            $this->command = $this->findExecutable('npm');
        }
        if (!$this->command) {
            throw new TaskException(__CLASS__, "Npm executable not found.");
        }
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return "{$this->command} {$this->action}{$this->arguments}";
    }
}
