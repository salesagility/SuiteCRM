<?php

namespace League\Event;

trait GeneratorTrait
{
    /**
     * The registered events.
     *
     * @var EventInterface[]
     */
    protected $events = [];

    /**
     * Add an event.
     *
     * @param EventInterface $event
     *
     * @return $this
     */
    protected function addEvent(EventInterface $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Release all the added events.
     *
     * @return EventInterface[]
     */
    public function releaseEvents()
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
