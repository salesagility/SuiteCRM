<?php

namespace Robo\Task\Gulp;

use Robo\Task\BaseTask;
use Robo\Exception\TaskException;
use Robo\Common\ProcessUtils;
use Robo\Common\ExecOneCommand;

abstract class Base extends BaseTask
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command = '';

    /**
     * @var array
     */
    protected $opts = [];

    /**
     * @var string
     */
    protected $task = '';

    /**
     * adds `silent` option to gulp
     *
     * @return $this
     */
    public function silent()
    {
        $this->option('silent');
        return $this;
    }

    /**
     * adds `--no-color` option to gulp
     *
     * @return $this
     */
    public function noColor()
    {
        $this->option('no-color');
        return $this;
    }

    /**
     * adds `--color` option to gulp
     *
     * @return $this
     */
    public function color()
    {
        $this->option('color');
        return $this;
    }

    /**
     * adds `--tasks-simple` option to gulp
     *
     * @return $this
     */
    public function simple()
    {
        $this->option('tasks-simple');
        return $this;
    }

    /**
     * @param string $task
     * @param null|string $pathToGulp
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($task, $pathToGulp = null)
    {
        $this->task = $task;
        $this->command = $pathToGulp;
        if (!$this->command) {
            $this->command = $this->findExecutable('gulp');
        }
        if (!$this->command) {
            throw new TaskException(__CLASS__, "Gulp executable not found.");
        }
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return "{$this->command} " . ProcessUtils::escapeArgument($this->task) . "{$this->arguments}";
    }
}
