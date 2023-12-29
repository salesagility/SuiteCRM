<?php

namespace Robo\Common;

use Robo\Contract\CommandInterface;
use Robo\Exception\TaskException;

/**
 * This task can receive commands from task implementing CommandInterface.
 */
trait CommandReceiver
{
    /**
     * @param string|\Robo\Contract\CommandInterface $command
     *
     * @return string
     *
     * @throws \Robo\Exception\TaskException
     */
    protected function receiveCommand($command)
    {
        if (!is_object($command)) {
            return $command;
        }
        if ($command instanceof CommandInterface) {
            return $command->getCommand();
        } else {
            throw new TaskException($this, get_class($command) . " does not implement CommandInterface, so can't be passed into this task");
        }
    }
}
