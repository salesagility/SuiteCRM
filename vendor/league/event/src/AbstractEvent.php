<?php

namespace League\Event;

abstract class AbstractEvent implements EventInterface
{
    /**
     * Has propagation stopped?
     *
     * @var bool
     */
    protected $propagationStopped = false;

    /**
     * The emitter instance.
     *
     * @var EmitterInterface|null
     */
    protected $emitter;

    /**
     * @inheritdoc
     */
    public function setEmitter(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getEmitter()
    {
        return $this->emitter;
    }

    /**
     * @inheritdoc
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return get_class($this);
    }
}
