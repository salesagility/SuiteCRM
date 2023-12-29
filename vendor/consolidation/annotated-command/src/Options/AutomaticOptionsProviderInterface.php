<?php
namespace Consolidation\AnnotatedCommand\Options;

use Consolidation\AnnotatedCommand\Parser\CommandInfo;
use Symfony\Component\Console\Input\InputOption;

/**
 * Option providers can add options to commands based on the annotations
 * present in a command.  For example, a command that specifies @fields
 * will automatically be given --format and --fields options.
 *
 * @see AnnotatedCommandFactory::addListener()
 * @see HookManager::addOptionHook()
 */
interface AutomaticOptionsProviderInterface
{
    /**
     * @return InputOption[]
     */
    public function automaticOptions(CommandInfo $commandInfo);
}
