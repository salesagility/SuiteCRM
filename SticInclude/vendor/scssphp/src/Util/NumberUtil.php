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
 * Utilities to deal with numbers with fuzziness for the Sass precision
 *
 * @internal
 */
class NumberUtil
{
    public const EPSILON = 0.00000000001; // 10^(-PRECISION-1)

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return bool
     */
    public static function fuzzyEquals($number1, $number2): bool
    {
        return abs($number1 - $number2) < self::EPSILON;
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return bool
     */
    public static function fuzzyLessThan($number1, $number2): bool
    {
        return $number1 < $number2 && !self::fuzzyEquals($number1, $number2);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return bool
     */
    public static function fuzzyLessThanOrEquals($number1, $number2): bool
    {
        return $number1 <= $number2 || self::fuzzyEquals($number1, $number2);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return bool
     */
    public static function fuzzyGreaterThan($number1, $number2): bool
    {
        return $number1 > $number2 && !self::fuzzyEquals($number1, $number2);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return bool
     */
    public static function fuzzyGreaterThanOrEquals($number1, $number2): bool
    {
        return $number1 >= $number2 || self::fuzzyEquals($number1, $number2);
    }

    /**
     * @param int|float $number
     *
     * @return bool
     */
    public static function fuzzyIsInt($number): bool
    {
        if (\is_int($number)) {
            return true;
        }

        // Check against 0.5 rather than 0.0 so that we catch numbers that are both
        // very slightly above an integer, and very slightly below.
        return self::fuzzyEquals(fmod(abs($number - 0.5), 1), 0.5);
    }

    /**
     * @param int|float $number
     *
     * @return int|null
     */
    public static function fuzzyAsInt($number): ?int
    {
        if (\is_int($number)) {
            return $number;
        }

        if (self::fuzzyIsInt($number)) {
            return (int) round($number);
        }

        return null;
    }

    /**
     * @param int|float $number
     *
     * @return int
     */
    public static function fuzzyRound($number): int
    {
        if (\is_int($number)) {
            return $number;
        }

        if ($number > 0) {
            return intval(self::fuzzyLessThan(fmod($number, 1), 0.5) ? floor($number) : ceil($number));
        }

        return intval(self::fuzzyLessThanOrEquals(fmod($number, 1), 0.5) ? floor($number) : ceil($number));
    }

    /**
     * @param int|float $number
     * @param int|float $min
     * @param int|float $max
     *
     * @return int|float|null
     */
    public static function fuzzyCheckRange($number, $min, $max)
    {
        if (self::fuzzyEquals($number, $min)) {
            return $min;
        }

        if (self::fuzzyEquals($number, $max)) {
            return $max;
        }

        if ($number > $min && $number < $max) {
            return $number;
        }

        return null;
    }

    /**
     * @param int|float $number
     * @param int|float $min
     * @param int|float $max
     * @param string|null $name
     *
     * @return int|float
     *
     * @throws \OutOfRangeException
     */
    public static function fuzzyAssertRange($number, $min, $max, ?string $name = null)
    {
        $result = self::fuzzyCheckRange($number, $min, $max);

        if (!\is_null($result)) {
            return $result;
        }

        $nameDisplay = $name ? " $name" : '';

        throw new \OutOfRangeException("Invalid value:$nameDisplay must be between $min and $max: $number.");
    }

    /**
     * Returns $num1 / $num2, using Sass's division semantic.
     *
     * Sass allows dividing by 0.
     *
     * @param int|float $num1
     * @param int|float $num2
     *
     * @return int|float
     */
    public static function divideLikeSass($num1, $num2)
    {
        if ($num2 == 0) {
            if ($num1 == 0) {
                return NAN;
            }

            if ($num1 > 0) {
                return INF;
            }

            return -INF;
        }

        return $num1 / $num2;
    }

    /**
     * Returns $num1 module $num2, using Sass's modulo semantic, which is inherited from Ruby.
     *
     * PHP's fdiv has a different semantic when the 2 numbers have a different sign.
     *
     * @param int|float $num1
     * @param int|float $num2
     *
     * @return int|float
     */
    public static function moduloLikeSass($num1, $num2)
    {
        if ($num2 == 0) {
            return NAN;
        }

        $result = fmod($num1, $num2);

        if ($result == 0) {
            return 0;
        }

        if ($num2 < 0 xor $num1 < 0) {
            $result += $num2;
        }

        return $result;
    }
}
