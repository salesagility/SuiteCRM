<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace ScssPhp\ScssPhp\Util;

/**
 * @internal
 */
final class StringUtil
{
    /**
     * Checks whether $haystack starts with $needle.
     *
     * This is a userland implementation of `str_starts_with` of PHP 8+.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        if (\PHP_VERSION_ID >= 80000) {
            return str_starts_with($haystack, $needle);
        }

        return '' === $needle || ('' !== $haystack && 0 === substr_compare($haystack, $needle, 0, \strlen($needle)));
    }

    /**
     * Checks whether $haystack ends with $needle.
     *
     * This is a userland implementation of `str_ends_with` of PHP 8+.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        if (\PHP_VERSION_ID >= 80000) {
            return str_ends_with($haystack, $needle);
        }

        return '' === $needle || ('' !== $haystack && 0 === substr_compare($haystack, $needle, -\strlen($needle)));
    }

    public static function trimAsciiRight(string $string, bool $excludeEscape = false): string
    {
        if (!$excludeEscape) {
            return rtrim($string, ' ');
        }

        $end = self::lastNonWhitespace($string, $excludeEscape);

        if ($end === null) {
            return '';
        }

        return substr($string, 0, $end + 1);
    }

    /**
     * Returns the index of the last character in $string that's not ASCII
     * whitespace, or `null` if $string is entirely spaces.
     *
     * If $excludeEscape is `true`, this doesn't move past whitespace that's
     * included in a CSS escape.
     */
    private static function lastNonWhitespace(string $string, bool $excludeEscape = false): ?int
    {
        for ($i = \strlen($string) - 1; $i >= 0; $i--) {
            $char = $string[$i];

            if (!Character::isWhitespace($char)) {
                if ($excludeEscape && $i !== 0 && $i !== \strlen($string) && $char === '\\') {
                    return $i + 1;
                }

                return $i;
            }
        }

        return null;
    }

    /**
     * Returns whether $string1 and $string2 are equal, ignoring ASCII case.
     *
     * @param string|null $string1
     * @param string      $string2
     *
     * @return bool
     */
    public static function equalsIgnoreCase(?string $string1, string $string2): bool
    {
        if ($string1 === $string2) {
            return true;
        }

        if ($string1 === null) {
            return false;
        }

        return self::toAsciiLowerCase($string1) === self::toAsciiLowerCase($string2);
    }

    /**
     * Converts all ASCII chars to lowercase in the input string.
     *
     * This does not uses `strtolower` because `strtolower` is locale-dependant
     * rather than operating on ASCII.
     * Passing an input string in an encoding that it is not ASCII compatible is
     * unsupported, and will probably generate garbage.
     *
     * @param string $string
     *
     * @return string
     */
    public static function toAsciiLowerCase(string $string): string
    {
        return strtr($string, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
    }
}
