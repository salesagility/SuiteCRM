<?php

namespace Robo\Contract;

/**
 * Task that implements this interface can be injected as a parameter for other task.
 * This task can be represented as executable command.
 *
 * @package Robo\Contract
 */
interface CommandInterface
{

    /**
     * Returns command that can be executed.
     * This method is used to pass generated command from one task to another.
     *
     * @return string
     */
    public function getCommand();
}
