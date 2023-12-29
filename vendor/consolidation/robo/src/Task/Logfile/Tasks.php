<?php

namespace Robo\Task\Logfile;

use Robo\Collection\CollectionBuilder;

trait Tasks
{
    /**
     * @param string|string[] $logfile
     *
     * @return \Robo\Task\Logfile\RotateLog|\Robo\Collection\CollectionBuilder
     */
    protected function taskRotateLog($logfile): CollectionBuilder
    {
        return $this->task(RotateLog::class, $logfile);
    }

    /**
     * @param string|string[] $logfile
     *
     * @return \Robo\Task\Logfile\TruncateLog|\Robo\Collection\CollectionBuilder
     */
    protected function taskTruncateLog($logfile): CollectionBuilder
    {
        return $this->task(TruncateLog::class, $logfile);
    }
}
