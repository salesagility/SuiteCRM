<?php
namespace Consolidation\AnnotatedCommand\State;

interface SavableState
{
    /**
     * Return the current state of this object.
     *
     * @return State
     */
    public function currentState();
}
