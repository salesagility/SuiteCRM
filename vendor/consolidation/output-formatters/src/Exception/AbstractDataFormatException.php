<?php

namespace Consolidation\OutputFormatters\Exception;

/**
 * Contains some helper functions used by exceptions in this project.
 */
abstract class AbstractDataFormatException extends \Exception
{
    /**
     * Return a description of the data type represented by the provided parameter.
     *
     * @param \ReflectionClass $data The data type to describe. Note that
     *   \ArrayObject is used as a proxy to mean an array primitive (or an ArrayObject).
     * @return string
     */
    protected static function describeDataType($data)
    {
        if (is_array($data) || ($data instanceof \ReflectionClass)) {
            if (is_array($data) || ($data->getName() == 'ArrayObject')) {
                return 'an array';
            }
            return 'an instance of ' . $data->getName();
        }
        if (is_string($data)) {
            return 'a string';
        }
        if (is_object($data)) {
            return 'an instance of ' . get_class($data);
        }
        throw new \Exception("Undescribable data error: " . var_export($data, true));
    }

    protected static function describeAllowedTypes($allowedTypes)
    {
        if (is_array($allowedTypes) && !empty($allowedTypes)) {
            if (count($allowedTypes) > 1) {
                return static::describeListOfAllowedTypes($allowedTypes);
            }
            $allowedTypes = $allowedTypes[0];
        }
        return static::describeDataType($allowedTypes);
    }

    protected static function describeListOfAllowedTypes($allowedTypes)
    {
        $descriptions = [];
        foreach ($allowedTypes as $oneAllowedType) {
            $descriptions[] = static::describeDataType($oneAllowedType);
        }
        if (count($descriptions) == 2) {
            return "either {$descriptions[0]} or {$descriptions[1]}";
        }
        $lastDescription = array_pop($descriptions);
        $otherDescriptions = implode(', ', $descriptions);
        return "one of $otherDescriptions or $lastDescription";
    }
}
