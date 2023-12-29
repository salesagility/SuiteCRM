<?php

namespace League\Event;

class ListenerAcceptor implements ListenerAcceptorInterface
{
    /**
     * The emitter instance.
     *
     * @var EmitterInterface|null
     */
    protected $emitter;

    /**
     * Constructor
     *
     * @param EmitterInterface $emitter
     */
    public function __construct(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * @inheritdoc
     */
    public function addListener($event, $listener, $priority = self::P_NORMAL)
    {
        $this->emitter->addListener($event, $listener, $priority);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addOneTimeListener($event, $listener, $priority = self::P_NORMAL)
    {
        $this->emitter->addOneTimeListener($event, $listener, $priority);

        return $this;
    }
}
