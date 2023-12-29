<?php

namespace League\Event;

interface ListenerAcceptorInterface
{
    /**
     * High priority.
     *
     * @const int
     */
    const P_HIGH = 100;

    /**
     * Normal priority.
     *
     * @const int
     */
    const P_NORMAL = 0;

    /**
     * Low priority.
     *
     * @const int
     */
    const P_LOW = -100;

    /**
     * Add a listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable". In this case, the priority emitter also accepts
     * an optional third parameter specifying the priority as an integer. You
     * may use one of our predefined constants here if you want.
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     * @param int                        $priority
     *
     * @return $this
     */
    public function addListener($event, $listener, $priority = self::P_NORMAL);

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
    public function addOneTimeListener($event, $listener, $priority = self::P_NORMAL);
}
