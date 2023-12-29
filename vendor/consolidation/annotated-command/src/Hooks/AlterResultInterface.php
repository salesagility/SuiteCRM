<?php
namespace Consolidation\AnnotatedCommand\Hooks;

/**
 * Alter the result of a command after it has been processed.
 * An alter result interface isa process result interface.
 *
 * @see HookManager::addAlterResult()
 */
interface AlterResultInterface extends ProcessResultInterface
{
}
