<?php

namespace Robo\Task\Docker;

/**
 * Starts Docker container
 *
 * ```php
 * <?php
 * $this->taskDockerStart($cidOrResult)
 *      ->run();
 * ?>
 * ```
 */
class Start extends Base
{
    /**
     * @var string
     */
    protected $command = "docker start";

    /**
     * @var null|string
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
        return $this->command . ' ' . $this->arguments . ' ' . $this->cid;
    }
}
