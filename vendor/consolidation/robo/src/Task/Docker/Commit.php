<?php

namespace Robo\Task\Docker;

/**
 * Commits docker container to an image
 *
 * ```
 * $this->taskDockerCommit($containerId)
 *      ->name('my/database')
 *      ->run();
 *
 * // alternatively you can take the result from DockerRun task:
 *
 * $result = $this->taskDockerRun('db')
 *      ->exec('./prepare_database.sh')
 *      ->run();
 *
 * $task->dockerCommit($result)
 *      ->name('my/database')
 *      ->run();
 * ```
 */
class Commit extends Base
{
    /**
     * @var string
     */
    protected $command = "docker commit";

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $cid;

    /**
     * @param string|\Robo\Task\Docker\Result $cidOrResult
     */
    public function __construct($cidOrResult)
    {
        $this->cid = $cidOrResult instanceof Result ? $cidOrResult->getCid() : $cidOrResult;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return $this->command . ' ' . $this->cid . ' ' . $this->name . ' ' . $this->arguments;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }
}
