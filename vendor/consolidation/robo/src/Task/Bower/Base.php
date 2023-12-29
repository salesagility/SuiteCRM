<?php

namespace Robo\Task\Bower;

use Robo\Task\BaseTask;
use Robo\Exception\TaskException;
use Robo\Common\ExecOneCommand;

abstract class Base extends BaseTask
{
    use ExecOneCommand;

    /**
     * @var array
     */
    protected $opts = [];

    /**
     * @var string
     */
    protected $action = '';

    /**
     * @var string
     */
    protected $command = '';

    /**
     * adds `allow-root` option to bower
     *
     * @return $this
     */
    public function allowRoot()
    {
        $this->option('allow-root');
        return $this;
    }

    /**
     * adds `force-latest` option to bower
     *
     * @return $this
     */
    public function forceLatest()
    {
        $this->option('force-latest');
        return $this;
    }

    /**
     * adds `production` option to bower
     *
     * @return $this
     */
    public function noDev()
    {
        $this->option('production');
        return $this;
    }

    /**
     * adds `offline` option to bower
     *
     * @return $this
     */
    public function offline()
    {
        $this->option('offline');
        return $this;
    }

    /**
     * Base constructor.
     *
     * @param null|string $pathToBower
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToBower = null)
    {
        $this->command = $pathToBower;
        if (!$this->command) {
            $this->command = $this->findExecutable('bower');
        }
        if (!$this->command) {
            throw new TaskException(__CLASS__, "Bower executable not found.");
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
