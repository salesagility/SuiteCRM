<?php
namespace Consolidation\AnnotatedCommand;

interface State
{
    /**
     * Restore state to a previously cached value.
     */
    public function restore();
}
