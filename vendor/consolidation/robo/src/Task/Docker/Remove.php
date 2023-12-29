<?php

namespace Robo\Task\Docker;

/**
 * Remove docker container
 *
 * ```php
 * <?php
 * $this->taskDockerRemove($container)
 *      ->run();
 * ?>
 * ```
 *
 */
class Remove extends Base
{
    /**
     * @param string $container
     */
    public function __construct($container)
    {
        $this->command = "docker rm $container ";
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return $this->command . ' ' . $this->arguments;
    }
}
