<?php

namespace Grasmash\Expander;

/**
 * Class Stringifier
 * @package Grasmash\Expander
 */
class Stringifier implements StringifierInterface
{
    /**
     * Converts array to string.
     *
     * @param array $array
     *   The array to convert.
     *
     * @return string
     *   The resultant string.
     */
    public static function stringifyArray(array $array)
    {
        return implode(',', $array);
    }
}
