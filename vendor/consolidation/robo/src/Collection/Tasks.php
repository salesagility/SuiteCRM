<?php

namespace Robo\Collection;

trait Tasks
{
    /**
     * Run a callback function on each item in a collection
     *
     * @param array $collection
     *
     * @return \Robo\Collection\TaskForEach|\Robo\Collection\CollectionBuilder
     */
    protected function taskForEach($collection = [])
    {
        return $this->task(TaskForEach::class, $collection);
    }
}
