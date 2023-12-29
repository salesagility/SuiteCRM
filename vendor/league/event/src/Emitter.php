<?php

namespace League\Event;

use InvalidArgumentException;

class Emitter implements EmitterInterface
{
    /**
     * The registered listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * The sorted listeners
     *
     * Listeners will get sorted and stored for re-use.
     *
     * @var ListenerInterface[]
     */
    protected $sortedListeners = [];

    /**
     * @inheritdoc
     */
    public function addListener($event, $listener, $priority = self::P_NORMAL)
    {
        $listener = $this->ensureListener($listener);
        $this->listeners[$event][$priority][] = $listener;
        $this->clearSortedListeners($event);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addOneTimeListener($event, $listener, $priority = self::P_NORMAL)
    {
        $listener = $this->ensureListener($listener);
        $listener = new OneTimeListener($listener);

        return $this->addListener($event, $listener, $priority);
    }

    /**
     * @inheritdoc
     */
    public function useListenerProvider(ListenerProviderInterface $provider)
    {
        $acceptor = new ListenerAcceptor($this);
        $provider->provideListeners($acceptor);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeListener($event, $listener)
    {
        $this->clearSortedListeners($event);
        $listeners = $this->hasListeners($event)
            ? $this->listeners[$event]
            : [];

        $filter = function ($registered) use ($listener) {
            return ! $registered->isListener($listener);
        };

        foreach ($listeners as $priority => $collection) {
            $listeners[$priority] = array_filter($collection, $filter);
        }

        $this->listeners[$event] = $listeners;


        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeAllListeners($event)
    {
        $this->clearSortedListeners($event);

        if ($this->hasListeners($event)) {
            unset($this->listeners[$event]);
        }

        return $this;
    }

    /**
     * Ensure the input is a listener.
     *
     * @param ListenerInterface|callable $listener
     *
     * @throws InvalidArgumentException
     *
     * @return ListenerInterface
     */
    protected function ensureListener($listener)
    {
        if ($listener instanceof ListenerInterface) {
            return $listener;
        }

        if (is_callable($listener)) {
            return CallbackListener::fromCallable($listener);
        }

        throw new InvalidArgumentException('Listeners should be ListenerInterface, Closure or callable. Received type: '.gettype($listener));
    }

    /**
     * @inheritdoc
     */
    public function hasListeners($event)
    {
        if (! isset($this->listeners[$event]) || count($this->listeners[$event]) === 0) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getListeners($event)
    {
        if (array_key_exists($event, $this->sortedListeners)) {
            return $this->sortedListeners[$event];
        }

        return $this->sortedListeners[$event] = $this->getSortedListeners($event);
    }

    /**
     * Get the listeners sorted by priority for a given event.
     *
     * @param string $event
     *
     * @return ListenerInterface[]
     */
    protected function getSortedListeners($event)
    {
        if (! $this->hasListeners($event)) {
            return [];
        }

        $listeners = $this->listeners[$event];
        krsort($listeners);

        return call_user_func_array('array_merge', $listeners);
    }

    /**
     * @inheritdoc
     */
    public function emit($event)
    {
        list($name, $event) = $this->prepareEvent($event);
        $arguments = [$event] + func_get_args();
        $this->invokeListeners($name, $event, $arguments);
        $this->invokeListeners('*', $event, $arguments);

        return $event;
    }

    /**
     * @inheritdoc
     */
    public function emitBatch(array $events)
    {
        $results = [];

        foreach ($events as $event) {
            $results[] = $this->emit($event);
        }

        return $results;
    }

    /**
     * @inheritdoc
     */
    public function emitGeneratedEvents(GeneratorInterface $generator)
    {
        $events = $generator->releaseEvents();

        return $this->emitBatch($events);
    }

    /**
     * Invoke the listeners for an event.
     *
     * @param string         $name
     * @param EventInterface $event
     * @param array          $arguments
     *
     * @return void
     */
    protected function invokeListeners($name, EventInterface $event, array $arguments)
    {
        $listeners = $this->getListeners($name);

        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            call_user_func_array([$listener, 'handle'], $arguments);
        }
    }

    /**
     * Prepare an event for emitting.
     *
     * @param string|EventInterface $event
     *
     * @return array
     */
    protected function prepareEvent($event)
    {
        $event = $this->ensureEvent($event);
        $name = $event->getName();
        $event->setEmitter($this);

        return [$name, $event];
    }

    /**
     * Ensure event input is of type EventInterface or convert it.
     *
     * @param string|EventInterface $event
     *
     * @throws InvalidArgumentException
     *
     * @return EventInterface
     */
    protected function ensureEvent($event)
    {
        if (is_string($event)) {
            return Event::named($event);
        }

        if (! $event instanceof EventInterface) {
            throw new InvalidArgumentException('Events should be provides as Event instances or string, received type: '.gettype($event));
        }

        return $event;
    }

    /**
     * Clear the sorted listeners for an event
     *
     * @param $event
     */
    protected function clearSortedListeners($event)
    {
        unset($this->sortedListeners[$event]);
    }
}
