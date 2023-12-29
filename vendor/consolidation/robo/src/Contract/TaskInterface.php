<?php

namespace Robo\Contract;

/**
 * All Robo tasks should implement this interface.
 * Task should be configured by chained methods.
 *
 * Interface TaskInterface
 * @package Robo\Contract
 */
interface TaskInterface
{
    /**
     * @return \Robo\Result
     */
    public function run();
}
