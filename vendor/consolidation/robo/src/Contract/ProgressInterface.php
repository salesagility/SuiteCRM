<?php

namespace Robo\Contract;

/**
 * Robo tasks that take multiple steps to complete should
 * implement this interface.
 *
 * Interface ProgressInterface
 * @package Robo\Contract
 */
interface ProgressInterface
{
    /**
     *
     * @return int
     */
    public function progressSteps();
}
