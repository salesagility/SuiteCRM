<?php

namespace Grasmash\Expander;

interface StringifierInterface
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
    public static function stringifyArray(array $array);
}
