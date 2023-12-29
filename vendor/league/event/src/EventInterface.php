<?php

namespace League\Event;

interface EventInterface
{
    /**
     * Set the Emitter.
     *
     * @param EmitterInterface $emitter
     *
     * @return $this
     */
    public function setEmitter(EmitterInterface $emitter);

    /**
     * Get the Emitter.
     *
     * @return EmitterInterface
     */
    public function getEmitter();

    /**
     * Stop event propagation.
     *
     * @return $this
     */
    public function stopPropagation();

    /**
     * Check whether propagation was stopped.
     *
     * @return bool
     */
    public function isPropagationStopped();

    /**
     * Get the event name.
     *
     * @return string
     */
    public function getName();
}
