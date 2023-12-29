<?php
namespace Consolidation\AnnotatedCommand\Hooks;

use Consolidation\AnnotatedCommand\AnnotationData;
use Symfony\Component\Console\Command\Command;

/**
 * Add options to a command.
 *
 * @see HookManager::addOptionHook()
 * @see AnnotatedCommandFactory::addListener()
 */
interface OptionHookInterface
{
    public function getOptions(Command $command, AnnotationData $annotationData);
}
