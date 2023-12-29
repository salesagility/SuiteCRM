<?php

namespace Robo\Exception;

class TaskException extends \Exception
{

    /**
     * TaskException constructor.
     *
     * @param string|object $class
     * @param string $message
     */
    public function __construct($class, $message)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        parent::__construct("  in task $class \n\n  $message");
    }
}
