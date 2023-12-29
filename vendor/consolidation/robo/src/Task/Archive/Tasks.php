<?php

namespace Robo\Task\Archive;

trait Tasks
{
    /**
     * @param string $filename
     *
     * @return \Robo\Task\Archive\Pack|\Robo\Collection\CollectionBuilder
     */
    protected function taskPack($filename)
    {
        return $this->task(Pack::class, $filename);
    }

    /**
     * @param string $filename
     *
     * @return \Robo\Task\Archive\Extract|\Robo\Collection\CollectionBuilder
     */
    protected function taskExtract($filename)
    {
        return $this->task(Extract::class, $filename);
    }
}
