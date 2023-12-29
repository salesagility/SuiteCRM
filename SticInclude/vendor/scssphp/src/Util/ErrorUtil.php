<?php

/**
 * SCSSPHP
 *
 * @copyright 2018-2020 Anthon Pang
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\Util;

/**
 * @internal
 */
class ErrorUtil
{
    /**
     * @throws \OutOfRangeException
     */
    public static function checkIntInInterval(int $value, int $minValue, int $maxValue, ?string $name = null): void
    {
        if ($value < $minValue || $value > $maxValue) {
            $nameDisplay = $name ? " $name" : '';

            throw new \OutOfRangeException("Invalid value:$nameDisplay must be between $minValue and $maxValue: $value.");
        }
    }

    /**
     * Check that a range represents a slice of an indexable object.
     *
     * Throws if the range is not valid for an indexable object with
     * the given length.
     * A range is valid for an indexable object with a given $length
     * if `0 <= $start <= $end <= $length`.
     * An `end` of `null` is considered equivalent to `length`.
     *
     * @throws \OutOfRangeException
     */
    public static function checkValidRange(int $start, ?int $end, int $length, ?string $startName = null, ?string $endName = null): void
    {
        if ($start < 0 || $start > $length) {
            $startName = $startName ?? 'start';
            $startNameDisplay = $startName ? " $startName" : '';

            throw new \OutOfRangeException("Invalid value:$startNameDisplay must be between 0 and $length: $start.");
        }

        if ($end !== null) {

            if ($end < $start || $end > $length) {
                $endName = $endName ?? 'end';
                $endNameDisplay = $endName ? " $endName" : '';

                throw new \OutOfRangeException("Invalid value:$endNameDisplay must be between $start and $length: $end.");
            }
        }
    }
}
