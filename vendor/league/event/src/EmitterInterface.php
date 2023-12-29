<?php

namespace League\Event;

interface EmitterInterface extends ListenerAcceptorInterface
{
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
    public function removeListener($event, $listener);

    /**
     * Use a provider to add listeners.
     *
     * @param ListenerProviderInterface $provider
     *
     * @return $this
     */
    public function useListenerProvider(ListenerProviderInterface $provider);

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
    public function removeAllListeners($event);

    /**
     * Check whether an event has listeners.
     *
     * The first parameter should be the event name. We'll return true if the
     * event has one or more registered even listeners, and false otherwise.
     *
     * @param string $event
     *
     * @return bool
     */
    public function hasListeners($event);

    /**
     * Get all the listeners for an event.
     *
     * The first parameter should be the event name. We'll return an array of
     * all the registered even listeners, or an empty array if there are none.
     *
     * @param string $event
     *
     * @return array
     */
    public function getListeners($event);

    /**
     * Emit an event.
     *
     * @param string|EventInterface $event
     *
     * @return EventInterface
     */
    public function emit($event);

    /**
     * Emit a batch of events.
     *
     * @param array $events
     *
     * @return array
     */
    public function emitBatch(array $events);

    /**
     * Release all events stored in a generator
     *
     * @param GeneratorInterface $generator
     *
     * @return EventInterface[]
     */
    public function emitGeneratedEvents(GeneratorInterface $generator);
}
