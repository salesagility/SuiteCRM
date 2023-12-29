<?php
namespace Consolidation\AnnotatedCommand\Hooks;

use Consolidation\AnnotatedCommand\CommandData;

/**
 * Validate the arguments for the current command.
 *
 * @see HookManager::addValidator()
 */
interface ValidatorInterface
{
    public function validate(CommandData $commandData);
}
