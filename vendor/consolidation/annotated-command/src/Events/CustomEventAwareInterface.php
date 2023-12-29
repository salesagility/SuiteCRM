<?php
namespace Consolidation\AnnotatedCommand\Events;

use Consolidation\AnnotatedCommand\Hooks\HookManager;

interface CustomEventAwareInterface
{
    /**
     * Set a reference to the hook manager for later use
     * @param HookManager $hookManager
     */
    public function setHookManager(HookManager $hookManager);

    /**
     * Get all of the defined event handlers of the specified name.
     * @param string $eventName
     * @return Callable[]
     */
    public function getCustomEventHandlers($eventName);
}
