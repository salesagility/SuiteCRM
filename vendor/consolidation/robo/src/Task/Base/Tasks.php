<?php

namespace Robo\Task\Base;

trait Tasks
{
    /**
     * @param string|\Robo\Contract\CommandInterface $command
     *
     * @return \Robo\Task\Base\Exec|\Robo\Collection\CollectionBuilder
     */
    protected function taskExec($command)
    {
        return $this->task(Exec::class, $command);
    }

    /**
     * @return \Robo\Task\Base\ExecStack|\Robo\Collection\CollectionBuilder
     */
    protected function taskExecStack()
    {
        return $this->task(ExecStack::class);
    }

    /**
     * @return \Robo\Task\Base\ParallelExec|\Robo\Collection\CollectionBuilder
     */
    protected function taskParallelExec()
    {
        return $this->task(ParallelExec::class);
    }

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return \Robo\Task\Base\SymfonyCommand|\Robo\Collection\CollectionBuilder
     */
    protected function taskSymfonyCommand($command)
    {
        return $this->task(SymfonyCommand::class, $command);
    }

    /**
     * @return \Robo\Task\Base\Watch|\Robo\Collection\CollectionBuilder
     */
    protected function taskWatch()
    {
        return $this->task(Watch::class, $this);
    }
}
