<?php

namespace Consolidation\OutputFormatters\Exception;

use Consolidation\OutputFormatters\Formatters\FormatterInterface;

/**
 * Represents an incompatibility between the output data and selected formatter.
 */
class IncompatibleDataException extends AbstractDataFormatException
{
    public function __construct(FormatterInterface $formatter, $data, $allowedTypes)
    {
        $formatterDescription = get_class($formatter);
        $dataDescription = static::describeDataType($data);
        $allowedTypesDescription = static::describeAllowedTypes($allowedTypes);
        $message = "Data provided to $formatterDescription must be $allowedTypesDescription. Instead, $dataDescription was provided.";
        parent::__construct($message, 1);
    }
}
