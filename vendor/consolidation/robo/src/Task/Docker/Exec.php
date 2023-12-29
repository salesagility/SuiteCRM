<?php

namespace Robo\Task\Docker;

use Robo\Common\CommandReceiver;

/**
 * Executes command inside running Docker container
 *
 * ```php
 * <?php
 * $test = $this->taskDockerRun('test_env')
 *      ->detached()
 *      ->run();
 *
 * $this->taskDockerExec($test)
 *      ->interactive()
 *      ->exec('./runtests')
 *      ->run();
 *
 * // alternatively use commands from other tasks
 *
 * $this->taskDockerExec($test)
 *      ->interactive()
 *      ->exec($this->taskCodecept()->suite('acceptance'))
 *      ->run();
 * ?>
 * ```
 *
 */
class Exec extends Base
{
    use CommandReceiver;

    /**
     * @var string
     */
    protected $command = "docker exec";

    /**
     * @var string
     */
    protected $cid;

    /**
     * @var string
     */
    protected $run = '';

    /**
     * @param string|\Robo\Result $cidOrResult
     */
    public function __construct($cidOrResult)
    {
        $this->cid = $cidOrResult instanceof Result ? $cidOrResult->getCid() : $cidOrResult;
    }

    /**
     * @return $this
     */
    public function detached()
    {
        $this->option('-d');
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function interactive($interactive = true)
    {
        if ($interactive) {
            $this->option('-i');
        }
        return parent::interactive($interactive);
    }

    /**
     * @param string|\Robo\Contract\CommandInterface $command
     *
     * @return $this
     */
    public function exec($command)
    {
        $this->run = $this->receiveCommand($command);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return $this->command . ' ' . $this->arguments . ' ' . $this->cid . ' ' . $this->run;
    }
}
