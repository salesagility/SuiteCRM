<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Symfony\Component\Console\Command\Command;
use Consolidation\AnnotatedCommand\AnnotatedCommand;
use Consolidation\AnnotatedCommand\AnnotationData;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\Hooks\OptionHookInterface;

/**
 * Call hooks
 */
class OptionsHookDispatcher extends HookDispatcher implements OptionHookInterface
{
    public function getOptions(
        Command $command,
        AnnotationData $annotationData
    ) {
        $hooks = [
            HookManager::PRE_OPTION_HOOK,
            HookManager::OPTION_HOOK,
            HookManager::POST_OPTION_HOOK
        ];
        $optionHooks = $this->getHooks($hooks, $annotationData);
        foreach ($optionHooks as $optionHook) {
            $this->callOptionHook($optionHook, $command, $annotationData);
        }
        $commandInfoList = $this->hookManager->getHookOptionsForCommand($command);
        if ($command instanceof AnnotatedCommand) {
            $command->optionsHookForHookAnnotations($commandInfoList);
        }
    }

    protected function callOptionHook($optionHook, $command, AnnotationData $annotationData)
    {
        if ($optionHook instanceof OptionHookInterface) {
            return $optionHook->getOptions($command, $annotationData);
        }
        if (is_callable($optionHook)) {
            return $optionHook($command, $annotationData);
        }
    }
}
