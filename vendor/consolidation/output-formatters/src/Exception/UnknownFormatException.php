<?php

namespace Consolidation\OutputFormatters\Exception;

/**
 * Indicates that the requested format does not exist.
 */
class UnknownFormatException extends \Exception
{
    public function __construct($format)
    {
        $message = "The requested format, '$format', is not available.";
        parent::__construct($message, 1);
    }
}
