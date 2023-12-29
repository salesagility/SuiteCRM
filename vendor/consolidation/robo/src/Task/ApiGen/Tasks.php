<?php

namespace Robo\Task\ApiGen;

trait Tasks
{
    /**
     * @param null|string $pathToApiGen
     *
     * @return \Robo\Task\ApiGen\ApiGen|\Robo\Collection\CollectionBuilder
     */
    protected function taskApiGen($pathToApiGen = null)
    {
        return $this->task(ApiGen::class, $pathToApiGen);
    }
}
