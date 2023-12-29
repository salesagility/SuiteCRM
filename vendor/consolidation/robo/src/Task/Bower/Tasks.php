<?php

namespace Robo\Task\Bower;

trait Tasks
{
    /**
     * @param null|string $pathToBower
     *
     * @return \Robo\Task\Bower\Install|\Robo\Collection\CollectionBuilder
     */
    protected function taskBowerInstall($pathToBower = null)
    {
        return $this->task(Install::class, $pathToBower);
    }

    /**
     * @param null|string $pathToBower
     *
     * @return \Robo\Task\Bower\Update|\Robo\Collection\CollectionBuilder
     */
    protected function taskBowerUpdate($pathToBower = null)
    {
        return $this->task(Update::class, $pathToBower);
    }
}
