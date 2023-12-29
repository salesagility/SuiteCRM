<?php

namespace Robo\Task\Remote;

trait Tasks
{
    /**
     * @return \Robo\Task\Remote\Rsync|\Robo\Collection\CollectionBuilder
     */
    protected function taskRsync()
    {
        return $this->task(Rsync::class);
    }

    /**
     * @param null|string $hostname
     * @param null|string $user
     *
     * @return \Robo\Task\Remote\Ssh|\Robo\Collection\CollectionBuilder
     */
    protected function taskSshExec($hostname = null, $user = null)
    {
        return $this->task(Ssh::class, $hostname, $user);
    }
}
