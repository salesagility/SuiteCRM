<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\AnnotationData;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\Hooks\InteractorInterface;
use Consolidation\AnnotatedCommand\State\State;
use Consolidation\AnnotatedCommand\State\StateHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Call hooks
 */
class InteractHookDispatcher extends HookDispatcher
{
    public function interact(
        InputInterface $input,
        OutputInterface $output,
        AnnotationData $annotationData
    ) {
        $hooks = [
            HookManager::PRE_INTERACT,
            HookManager::INTERACT,
            HookManager::POST_INTERACT
        ];
        $interactors = $this->getHooks($hooks, $annotationData);
        foreach ($interactors as $interactor) {
            $this->callInteractor($interactor, $input, $output, $annotationData);
        }
    }

    protected function callInteractor($interactor, $input, $output, AnnotationData $annotationData)
    {
        $state = StateHelper::injectIntoCallbackObject($interactor, $input, $output);
        $result = $this->doInteractor($interactor, $input, $output, $annotationData);
        $state->restore();
        return $result;
    }

    private function doInteractor($interactor, $input, $output, AnnotationData $annotationData)
    {
        if ($interactor instanceof InteractorInterface) {
            return $interactor->interact($input, $output, $annotationData);
        }
        if (is_callable($interactor)) {
            return $interactor($input, $output, $annotationData);
        }
    }
}
