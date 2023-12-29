<?php

namespace Robo\Task\Docker;

/**
 * Stops Docker container
 *
 * ```php
 * <?php
 * $this->taskDockerStop($cidOrResult)
 *      ->run();
 * ?>
 * ```
 */
class Stop extends Base
{
    /**
     * @var string
     */
    protected $command = "docker stop";

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
