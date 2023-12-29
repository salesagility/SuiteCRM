<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\AnnotationData;
use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\AnnotatedCommand\CommandError;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\Hooks\ValidatorInterface;
use Consolidation\AnnotatedCommand\State\State;
use Consolidation\AnnotatedCommand\State\StateHelper;

/**
 * Call hooks
 */
class ValidateHookDispatcher extends HookDispatcher implements ValidatorInterface
{
    public function validate(CommandData $commandData)
    {
        $hooks = [
            HookManager::PRE_ARGUMENT_VALIDATOR,
            HookManager::ARGUMENT_VALIDATOR,
            HookManager::POST_ARGUMENT_VALIDATOR,
            HookManager::PRE_COMMAND_HOOK,
            HookManager::COMMAND_HOOK,
        ];
        $validators = $this->getHooks($hooks, $commandData->annotationData());
        foreach ($validators as $validator) {
            $validated = $this->callValidator($validator, $commandData);
            if ($validated === false) {
                return new CommandError();
            }
            if (is_object($validated)) {
                return $validated;
            }
        }
    }

    protected function callValidator($validator, CommandData $commandData)
    {
        $state = StateHelper::injectIntoCallbackObject($validator, $commandData->input(), $commandData->output());
        $result = $this->doValidator($validator, $commandData);
        $state->restore();
        return $result;
    }

    private function doValidator($validator, CommandData $commandData)
    {
        if ($validator instanceof ValidatorInterface) {
            return $validator->validate($commandData);
        }
        if (is_callable($validator)) {
            return $validator($commandData);
        }
    }
}
