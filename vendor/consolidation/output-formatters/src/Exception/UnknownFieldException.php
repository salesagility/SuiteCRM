<?php

namespace Consolidation\OutputFormatters\Exception;

/**
 * Indicates that the requested format does not exist.
 */
class UnknownFieldException extends \Exception
{
    public function __construct($field)
    {
        $message = "The requested field, '$field', is not defined.";
        parent::__construct($message, 1);
    }
}
