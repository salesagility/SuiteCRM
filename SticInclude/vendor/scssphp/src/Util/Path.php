<?php

namespace ScssPhp\ScssPhp\Util;

/**
 * @internal
 */
final class Path
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isAbsolute(string $path): bool
    {
        if ($path === '') {
            return false;
        }

        if ($path[0] === '/') {
            return true;
        }

        if (\DIRECTORY_SEPARATOR !== '\\') {
            return false;
        }

        if ($path[0] === '\\') {
            return true;
        }

        if (\strlen($path) < 3) {
            return false;
        }

        if ($path[1] !== ':') {
            return false;
        }

        if ($path[2] !== '/' && $path[2] !== '\\') {
            return false;
        }

        if (!preg_match('/^[A-Za-z]$/', $path[0])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $part1
     * @param string $part2
     *
     * @return string
     */
    public static function join(string $part1, string $part2): string
    {
        if ($part1 === '' || self::isAbsolute($part2)) {
            return $part2;
        }

        if ($part2 === '') {
            return $part1;
        }

        $last = $part1[\strlen($part1) - 1];
        $separator = \DIRECTORY_SEPARATOR;

        if ($last === '/' || $last === \DIRECTORY_SEPARATOR) {
            $separator = '';
        }

        return $part1 . $separator . $part2;
    }

    /**
     * Returns a pretty URI for a path
     *
     * @param string $path
     *
     * @return string
     */
    public static function prettyUri(string $path): string
    {
        $normalizedPath = $path;
        $normalizedRootDirectory = getcwd().'/';

        if (\DIRECTORY_SEPARATOR === '\\') {
            $normalizedRootDirectory = str_replace('\\', '/', $normalizedRootDirectory);
            $normalizedPath = str_replace('\\', '/', $path);
        }

        // TODO add support for returning a relative path using ../ in some cases, like Dart's path.prettyUri method

        if (0 === strpos($normalizedPath, $normalizedRootDirectory)) {
            return substr($path, \strlen($normalizedRootDirectory));
        }

        return $path;
    }
}
