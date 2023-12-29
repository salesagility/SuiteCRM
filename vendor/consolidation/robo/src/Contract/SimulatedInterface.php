<?php

namespace Robo\Contract;

/**
 * Task that implements this interface can be injected as a parameter for other task.
 * This task can be represented as executable command.
 *
 * @package Robo\Contract
 */
interface SimulatedInterface extends TaskInterface
{
    /**
     * Called in place of `run()` for simulated tasks.
     *
     * @param null|array $context
     */
    public function simulate($context);
}
