<?php

namespace League\Event;

class CallbackListener implements ListenerInterface
{
    /**
     * The callback.
     *
     * @var callable
     */
    protected $callback;

    /**
     * Create a new callback listener instance.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Get the callback.
     *
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @inheritdoc
     */
    public function handle(EventInterface $event)
    {
        call_user_func_array($this->callback, func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function isListener($listener)
    {
        if ($listener instanceof CallbackListener) {
            $listener = $listener->getCallback();
        }

        return $this->callback === $listener;
    }

    /**
     * Named constructor
     *
     * @param callable $callable
     *
     * @return static
     */
    public static function fromCallable(callable $callable)
    {
        return new static($callable);
    }
}
