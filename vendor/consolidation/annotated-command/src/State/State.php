<?php
namespace Consolidation\AnnotatedCommand\State;

interface State
{
    /**
     * Restore state to a previously cached value.
     */
    public function restore();
}
