<?php
namespace Consolidation\AnnotatedCommand\Hooks;

use Consolidation\AnnotatedCommand\CommandData;

/**
 * A result processor takes a result object, processes it, and
 * returns another result object.  For example, if a result object
 * represents a 'task', then a task-runner hook could run the
 * task and return the result from that execution.
 *
 * @see HookManager::addResultProcessor()
 */
interface ProcessResultInterface
{
    /**
     * After a command has executed, if the result is something
     * that needs to be processed, e.g. a collection of tasks to
     * run, then execute it and return the new result.
     *
     * @param  mixed $result Result to (potentially) be processed
     * @param  CommandData $commandData Reference to commandline arguments and options
     *
     * @return mixed $result
     */
    public function process($result, CommandData $commandData);
}
