<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\AnnotationData;

/**
 * Call hooks
 */
class HookDispatcher
{
    /** var HookManager */
    protected $hookManager;
    protected $names;

    public function __construct(HookManager $hookManager, $names)
    {
        $this->hookManager = $hookManager;
        $this->names = $names;
    }

    public function getHooks($hooks, $annotationData = null)
    {
        return $this->hookManager->getHooks($this->names, $hooks, $annotationData);
    }
}
