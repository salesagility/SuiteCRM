<?php

namespace League\Event;

trait EmitterTrait
{
    use EmitterAwareTrait;

    /**
     * Add a listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     * @param int                        $priority
     *
     * @return $this
     */
    public function addListener($event, $listener, $priority = ListenerAcceptorInterface::P_NORMAL)
    {
        $this->getEmitter()->addListener($event, $listener, $priority);

        return $this;
    }

    /**
     * Add a one time listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     * @param int                        $priority
     *
     * @return $this
     */
    public function addOneTimeListener($event, $listener, $priority = ListenerAcceptorInterface::P_NORMAL)
    {
        $this->getEmitter()->addOneTimeListener($event, $listener, $priority);

        return $this;
    }

    /**
     * Remove a specific listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     *
     * @return $this
     */
    public function removeListener($event, $listener)
    {
        $this->getEmitter()->removeListener($event, $listener);

        return $this;
    }

    /**
     * Remove all listeners for an event.
     *
     * The first parameter should be the event name. All event listeners will
     * be removed.
     *
     * @param string $event
     *
     * @return $this
     */
    public function removeAllListeners($event)
    {
        $this->getEmitter()->removeAllListeners($event);

        return $this;
    }

    /**
     * Add listeners from a provider.
     *
     * @param ListenerProviderInterface $provider
     *
     * @return $this
     */
    public function useListenerProvider(ListenerProviderInterface $provider)
    {
        $this->getEmitter()->useListenerProvider($provider);

        return $this;
    }

    /**
     * Emit an event.
     *
     * @param string|EventInterface $event
     *
     * @return EventInterface
     */
    public function emit($event)
    {
        $emitter = $this->getEmitter();
        $arguments = [$event] + func_get_args();

        return call_user_func_array([$emitter, 'emit'], $arguments);
    }
}
