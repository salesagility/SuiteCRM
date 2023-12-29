<?php
namespace Consolidation\AnnotatedCommand\Hooks;

use Consolidation\AnnotatedCommand\AnnotationData;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interactively supply values for missing required arguments for
 * the current command.  Note that this hook is not called if
 * the --no-interaction flag is set.
 *
 * @see HookManager::addInteractor()
 */
interface InteractorInterface
{
    public function interact(InputInterface $input, OutputInterface $output, AnnotationData $annotationData);
}
