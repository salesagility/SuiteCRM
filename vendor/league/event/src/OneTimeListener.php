<?php

namespace League\Event;

class OneTimeListener implements ListenerInterface
{
    /**
     * The listener instance.
     *
     * @var ListenerInterface
     */
    protected $listener;

    /**
     * Create a new one time listener instance.
     *
     * @param ListenerInterface $listener
     */
    public function __construct(ListenerInterface $listener)
    {
        $this->listener = $listener;
    }

    /**
     * Get the wrapped listener.
     *
     * @return ListenerInterface
     */
    public function getWrappedListener()
    {
        return $this->listener;
    }

    /**
     * @inheritdoc
     */
    public function handle(EventInterface $event)
    {
        $name = $event->getName();
        $emitter = $event->getEmitter();
        $emitter->removeListener($name, $this->listener);

        return call_user_func_array([$this->listener, 'handle'], func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function isListener($listener)
    {
        if ($listener instanceof OneTimeListener) {
            $listener = $listener->getWrappedListener();
        }

        return $this->listener->isListener($listener);
    }
}
