<?php

namespace Robo\Task\File;

trait Tasks
{
    /**
     * @param array|\Iterator $files
     *
     * @return \Robo\Task\File\Concat|\Robo\Collection\CollectionBuilder
     */
    protected function taskConcat($files)
    {
        return $this->task(Concat::class, $files);
    }

    /**
     * @param string $file
     *
     * @return \Robo\Task\File\Replace|\Robo\Collection\CollectionBuilder
     */
    protected function taskReplaceInFile($file)
    {
        return $this->task(Replace::class, $file);
    }

    /**
     * @param string $file
     *
     * @return \Robo\Task\File\Write|\Robo\Collection\CollectionBuilder
     */
    protected function taskWriteToFile($file)
    {
        return $this->task(Write::class, $file);
    }

    /**
     * @param string $filename
     * @param string $extension
     * @param string $baseDir
     * @param bool $includeRandomPart
     *
     * @return \Robo\Task\File\TmpFile|\Robo\Collection\CollectionBuilder
     */
    protected function taskTmpFile($filename = 'tmp', $extension = '', $baseDir = '', $includeRandomPart = true)
    {
        return $this->task(TmpFile::class, $filename, $extension, $baseDir, $includeRandomPart);
    }
}
