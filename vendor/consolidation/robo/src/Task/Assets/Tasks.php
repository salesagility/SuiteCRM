<?php

namespace Robo\Task\Assets;

trait Tasks
{
    /**
     * @param string $input
     *
     * @return \Robo\Task\Assets\Minify|\Robo\Collection\CollectionBuilder
     */
    protected function taskMinify($input)
    {
        return $this->task(Minify::class, $input);
    }

    /**
     * @param string|string[] $input
     *
     * @return \Robo\Task\Assets\ImageMinify|\Robo\Collection\CollectionBuilder
     */
    protected function taskImageMinify($input)
    {
        return $this->task(ImageMinify::class, $input);
    }

   /**
    * @param array $input
    *
    * @return \Robo\Task\Assets\Less|\Robo\Collection\CollectionBuilder
    */
    protected function taskLess($input)
    {
        return $this->task(Less::class, $input);
    }

    /**
     * @param array $input
     *
     * @return \Robo\Task\Assets\Scss|\Robo\Collection\CollectionBuilder
     */
    protected function taskScss($input)
    {
        return $this->task(Scss::class, $input);
    }
}
