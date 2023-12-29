<?php

namespace Robo\Task\Npm;

trait Tasks
{
    /**
     * @param null|string $pathToNpm
     *
     * @return \Robo\Task\Npm\Install|\Robo\Collection\CollectionBuilder
     */
    protected function taskNpmInstall($pathToNpm = null)
    {
        return $this->task(Install::class, $pathToNpm);
    }

    /**
     * @param null|string $pathToNpm
     *
     * @return \Robo\Task\Npm\Update|\Robo\Collection\CollectionBuilder
     */
    protected function taskNpmUpdate($pathToNpm = null)
    {
        return $this->task(Update::class, $pathToNpm);
    }
}
