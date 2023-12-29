<?php

namespace Robo\Task\Testing;

trait Tasks
{
    /**
     * @param null|string $pathToCodeception
     *
     * @return \Robo\Task\Testing\Codecept|\Robo\Collection\CollectionBuilder
     */
    protected function taskCodecept($pathToCodeception = null)
    {
        return $this->task(Codecept::class, $pathToCodeception);
    }

    /**
     * @param null|string $pathToPhpUnit
     *
     * @return \Robo\Task\Testing\PHPUnit|\Robo\Collection\CollectionBuilder
     */
    protected function taskPhpUnit($pathToPhpUnit = null)
    {
        return $this->task(PHPUnit::class, $pathToPhpUnit);
    }

    /**
     * @param null|string $pathToPhpspec
     *
     * @return \Robo\Task\Testing\Phpspec|\Robo\Collection\CollectionBuilder
     */
    protected function taskPhpspec($pathToPhpspec = null)
    {
        return $this->task(Phpspec::class, $pathToPhpspec);
    }

    /**
     * @param null|string $pathToAtoum
     *
     * @return \Robo\Task\Testing\Atoum|\Robo\Collection\CollectionBuilder
     */
    protected function taskAtoum($pathToAtoum = null)
    {
        return $this->task(Atoum::class, $pathToAtoum);
    }

    /**
     * @param null|string $pathToBehat
     *
     * @return \Robo\Task\Testing\Behat|\Robo\Collection\CollectionBuilder
     */
    protected function taskBehat($pathToBehat = null)
    {
        return $this->task(Behat::class, $pathToBehat);
    }
}
