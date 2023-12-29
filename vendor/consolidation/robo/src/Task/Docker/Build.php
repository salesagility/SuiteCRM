<?php

namespace Robo\Task\Docker;

/**
 * Builds Docker image
 *
 * ```php
 * <?php
 * $this->taskDockerBuild()->run();
 *
 * $this->taskDockerBuild('path/to/dir')
 *      ->tag('database')
 *      ->run();
 *
 * ?>
 *
 * ```
 *
 * Class Build
 * @package Robo\Task\Docker
 */
class Build extends Base
{
    /**
     * @var string
     */
    protected $path;
    
    /**
     * @var bool
     */
    protected $buildKit = false;

    /**
     * @param string $path
     */
    public function __construct($path = '.')
    {
        $this->command = "docker build";
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        $command = $this->command;
        if ($this->buildKit) {
            $command = 'DOCKER_BUILDKIT=1 ' . $command;
        }
        return $command . ' ' . $this->arguments . ' ' . $this->path;
    }

    /**
     * @param string $tag
     *
     * @return $this
     */
    public function tag($tag)
    {
        return $this->option('-t', $tag);
    }
    
    /**
     * @return $this
     */
    public function enableBuildKit()
    {
        $this->buildKit = true;
        return $this;
    }
}
