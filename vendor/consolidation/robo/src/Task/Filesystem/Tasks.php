<?php

namespace Robo\Task\Filesystem;

trait Tasks
{
    /**
     * @param string|string[] $dirs
     *
     * @return \Robo\Task\Filesystem\CleanDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskCleanDir($dirs)
    {
        return $this->task(CleanDir::class, $dirs);
    }

    /**
     * @param string|string[] $dirs
     *
     * @return \Robo\Task\Filesystem\DeleteDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskDeleteDir($dirs)
    {
        return $this->task(DeleteDir::class, $dirs);
    }

    /**
     * @param string $prefix
     * @param string $base
     * @param bool $includeRandomPart
     *
     * @return \Robo\Task\Filesystem\WorkDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskTmpDir($prefix = 'tmp', $base = '', $includeRandomPart = true)
    {
        return $this->task(TmpDir::class, $prefix, $base, $includeRandomPart);
    }

    /**
     * @param string $finalDestination
     *
     * @return \Robo\Task\Filesystem\TmpDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskWorkDir($finalDestination)
    {
        return $this->task(WorkDir::class, $finalDestination);
    }

    /**
     * @param string|string[] $dirs
     *
     * @return \Robo\Task\Filesystem\CopyDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskCopyDir($dirs)
    {
        return $this->task(CopyDir::class, $dirs);
    }

    /**
     * @param string|string[] $dirs
     *
     * @return \Robo\Task\Filesystem\MirrorDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskMirrorDir($dirs)
    {
        return $this->task(MirrorDir::class, $dirs);
    }

    /**
     * @param string|string[] $dirs
     *
     * @return \Robo\Task\Filesystem\FlattenDir|\Robo\Collection\CollectionBuilder
     */
    protected function taskFlattenDir($dirs)
    {
        return $this->task(FlattenDir::class, $dirs);
    }

    /**
     * @return \Robo\Task\Filesystem\FilesystemStack|\Robo\Collection\CollectionBuilder
     */
    protected function taskFilesystemStack()
    {
        return $this->task(FilesystemStack::class);
    }
}
