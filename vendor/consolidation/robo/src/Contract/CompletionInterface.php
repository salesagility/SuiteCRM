<?php

namespace Robo\Contract;

/**
 * Any Robo tasks that implements this interface will
 * be called when the task collection it is added to
 * completes.
 *
 * Interface CompletionInterface
 * @package Robo\Contract
 */
interface CompletionInterface extends TaskInterface
{
    /**
     * Revert an operation that can be rolled back
     */
    public function complete();
}
