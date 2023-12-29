<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Call hooks.
 */
class ReplaceCommandHookDispatcher extends HookDispatcher implements LoggerAwareInterface
{

    use LoggerAwareTrait;

    /**
     * @return int
     */
    public function hasReplaceCommandHook()
    {
        return (bool) count($this->getReplaceCommandHooks());
    }

    /**
     * @return \callable[]
     */
    public function getReplaceCommandHooks()
    {
        $hooks = [
            HookManager::REPLACE_COMMAND_HOOK,
        ];
        $replaceCommandHooks = $this->getHooks($hooks);

        return $replaceCommandHooks;
    }

    /**
     * @param \Consolidation\AnnotatedCommand\CommandData $commandData
     *
     * @return callable
     */
    public function getReplacementCommand(CommandData $commandData)
    {
        $replaceCommandHooks = $this->getReplaceCommandHooks();

        // We only take the first hook implementation of "replace-command" as the replacement. Commands shouldn't have
        // more than one replacement.
        $replacementCommand = reset($replaceCommandHooks);

        if ($this->logger && count($replaceCommandHooks) > 1) {
            $command_name = $commandData->annotationData()->get('command', 'unknown');
            $message = "Multiple implementations of the \"replace - command\" hook exist for the \"$command_name\" command.\n";
            foreach ($replaceCommandHooks as $replaceCommandHook) {
                $class = get_class($replaceCommandHook[0]);
                $method = $replaceCommandHook[1];
                $hook_name = "$class->$method";
                $message .= "  - $hook_name\n";
            }
            $this->logger->warning($message);
        }

        return $replacementCommand;
    }
}
