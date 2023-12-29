<?php

namespace Consolidation\OutputFormatters\Transformations;

/**
 * Transform a string of properties into a PHP associative array.
 *
 * Input:
 *
 *   one: red
 *   two: white
 *   three: blue
 *
 * Output:
 *
 *   [
 *      'one' => 'red',
 *      'two' => 'white',
 *      'three' => 'blue',
 *   ]
 */
class PropertyParser
{
    public static function parse($data)
    {
        if (!is_string($data)) {
            return $data;
        }
        $result = [];
        $lines = explode("\n", $data);
        foreach ($lines as $line) {
            list($key, $value) = explode(':', trim($line), 2) + ['', ''];
            if (!empty($key) && !empty($value)) {
                $result[$key] = trim($value);
            }
        }
        return $result;
    }
}
