<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\AnnotatedCommand;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\State\State;
use Consolidation\AnnotatedCommand\State\StateHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Call hooks
 */
class CommandEventHookDispatcher extends HookDispatcher
{
    /**
     * @param ConsoleCommandEvent $event
     */
    public function callCommandEventHooks(ConsoleCommandEvent $event)
    {
        $input = $event->getInput();
        $output = $event->getOutput();

        $hooks = [
            HookManager::PRE_COMMAND_EVENT,
            HookManager::COMMAND_EVENT,
            HookManager::POST_COMMAND_EVENT
        ];
        $commandEventHooks = $this->getHooks($hooks);
        foreach ($commandEventHooks as $commandEvent) {
            if ($commandEvent instanceof EventDispatcherInterface) {
                $commandEvent->dispatch($event, ConsoleEvents::COMMAND);
            }
            if (is_callable($commandEvent)) {
                $state = StateHelper::injectIntoCallbackObject($commandEvent, $input, $output);
                $commandEvent($event);
                $state->restore();
            }
        }
    }
}
