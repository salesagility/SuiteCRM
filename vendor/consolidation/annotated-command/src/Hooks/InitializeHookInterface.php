<?php
namespace Consolidation\AnnotatedCommand\Hooks;

use Consolidation\AnnotatedCommand\AnnotationData;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Non-interactively (e.g. via configuration files) apply configuration values to the Input object.
 *
 * @see HookManager::addInitializeHook()
 */
interface InitializeHookInterface
{
    public function initialize(InputInterface $input, AnnotationData $annotationData);
}
