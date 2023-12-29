<?php

namespace League\Event;

abstract class AbstractListener implements ListenerInterface
{
    /**
     * @inheritdoc
     */
    public function isListener($listener)
    {
        return $this === $listener;
    }
}
