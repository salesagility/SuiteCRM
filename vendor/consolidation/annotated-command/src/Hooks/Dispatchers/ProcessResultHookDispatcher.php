<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\AnnotationData;
use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\Hooks\ProcessResultInterface;
use Consolidation\AnnotatedCommand\State\State;
use Consolidation\AnnotatedCommand\State\StateHelper;

/**
 * Call hooks
 */
class ProcessResultHookDispatcher extends HookDispatcher implements ProcessResultInterface
{
    /**
     * Process result and decide what to do with it.
     * Allow client to add transformation / interpretation
     * callbacks.
     */
    public function process($result, CommandData $commandData)
    {
        $hooks = [
            HookManager::PRE_PROCESS_RESULT,
            HookManager::PROCESS_RESULT,
            HookManager::POST_PROCESS_RESULT,
            HookManager::PRE_ALTER_RESULT,
            HookManager::ALTER_RESULT,
            HookManager::POST_ALTER_RESULT,
            HookManager::POST_COMMAND_HOOK,
        ];
        $processors = $this->getHooks($hooks, $commandData->annotationData());
        foreach ($processors as $processor) {
            $result = $this->callProcessor($processor, $result, $commandData);
        }

        return $result;
    }

    protected function callProcessor($processor, $result, CommandData $commandData)
    {
        $state = StateHelper::injectIntoCallbackObject($processor, $commandData->input(), $commandData->output());
        $result = $this->doProcessor($processor, $result, $commandData);
        $state->restore();
        return $result;
    }

    private function doProcessor($processor, $result, CommandData $commandData)
    {
        $processed = null;
        if ($processor instanceof ProcessResultInterface) {
            $processed = $processor->process($result, $commandData);
        }
        if (is_callable($processor)) {
            $processed = $processor($result, $commandData);
        }
        if (isset($processed)) {
            return $processed;
        }
        return $result;
    }
}
