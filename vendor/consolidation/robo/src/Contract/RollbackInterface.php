<?php

namespace Robo\Contract;

/**
 * Any Robo tasks that implements this interface will
 * be called when the task collection it is added to
 * fails, and runs its rollback operation.
 *
 * Interface RollbackInterface
 * @package Robo\Contract
 */
interface RollbackInterface extends TaskInterface
{
    /**
     * Revert an operation that can be rolled back
     */
    public function rollback();
}
