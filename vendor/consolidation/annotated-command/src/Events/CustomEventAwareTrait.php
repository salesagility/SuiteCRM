<?php
namespace Consolidation\AnnotatedCommand\Events;

use Consolidation\AnnotatedCommand\Hooks\HookManager;

trait CustomEventAwareTrait
{
    /** var HookManager */
    protected $hookManager;

    /**
     * {@inheritdoc}
     */
    public function setHookManager(HookManager $hookManager)
    {
        $this->hookManager = $hookManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomEventHandlers($eventName)
    {
        if (!$this->hookManager) {
            return [];
        }
        return $this->hookManager->getHook($eventName, HookManager::ON_EVENT);
    }
}
