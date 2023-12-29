<?php
namespace Consolidation\AnnotatedCommand\Parser\Internal;

/**
 * Methods to convert to / from a csv string.
 */
class CsvUtils
{
    /**
     * Ensure that the provided data is a string.
     *
     * @param string|array $data The data to convert to a string.
     * @return string
     */
    public static function toString($data)
    {
        if (is_array($data)) {
            return static::csvEscape($data);
        }
        return $data;
    }

    /**
     * Convert a string to a csv.
     */
    public static function csvEscape(array $data, $delimiter = ',')
    {
        $buffer = fopen('php://temp', 'r+');
        fputcsv($buffer, $data, $delimiter);
        rewind($buffer);
        $csv = fgets($buffer);
        fclose($buffer);
        return rtrim($csv);
    }

    /**
     * Return a specific named annotation for this command.
     *
     * @param string|array $data The data to convert to an array.
     * @return array
     */
    public static function toList($data)
    {
        if (!is_array($data)) {
            return str_getcsv($data);
        }
        return $data;
    }
}
