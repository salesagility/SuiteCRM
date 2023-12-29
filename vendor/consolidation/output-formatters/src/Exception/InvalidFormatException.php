<?php

namespace Consolidation\OutputFormatters\Exception;

/**
 * Represents an incompatibility between the output data and selected formatter.
 */
class InvalidFormatException extends AbstractDataFormatException
{
    public function __construct($format, $data, $validFormats)
    {
        $dataDescription = static::describeDataType($data);
        $message = "The format $format cannot be used with the data produced by this command, which was $dataDescription.  Valid formats are: " . implode(',', $validFormats);
        parent::__construct($message, 1);
    }
}
