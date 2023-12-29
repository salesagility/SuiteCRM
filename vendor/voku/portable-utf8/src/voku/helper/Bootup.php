<?php

declare(strict_types=1);

namespace voku\helper;

/**
 * @psalm-immutable
 */
class Bootup
{
    /**
     * Normalizes to UTF-8 NFC, converting from WINDOWS-1252 when needed.
     *
     * @param mixed  $input
     * @param int    $normalization_form
     * @param string $leading_combining
     *
     * @return mixed
     */
    public static function filterString(
        $input,
        int $normalization_form = \Normalizer::NFC,
        string $leading_combining = '◌'
    ) {
        return UTF8::filter(
            $input,
            $normalization_form,
            $leading_combining
        );
    }

    /**
     * Get random bytes via "random_bytes()"
     *
     * @param int $length <p>output length</p>
     *
     * @throws \Exception if it was not possible to gather sufficient entropy
     *
     * @return false|string
     *                      <strong>false</strong> on error
     */
    public static function get_random_bytes($length)
    {
        if (!$length) {
            return false;
        }

        $length = (int) $length;

        if ($length <= 0) {
            return false;
        }

        return \random_bytes($length);
    }

    /**
     * Constant FILTER_SANITIZE_STRING polyfill for PHP > 8.1
     *
     * INFO: https://stackoverflow.com/a/69207369/1155858
     *
     * @param string $str
     *
     * @return false|string
     */
    public static function filter_sanitize_string_polyfill(string $str)
    {
        $str = \preg_replace('/\x00|<[^>]*>?/', '', $str);
        if ($str === null) {
            return false;
        }

        return \str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
    }

    /**
     * @return bool
     */
    public static function initAll(): bool
    {
        $result = \ini_set('default_charset', 'UTF-8');

        // everything else is init via composer, so we are done here ...

        return $result !== false;
    }

    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value.
     *
     * @param string $version <p>e.g. "7.1"<p>
     *
     * @return bool
     *              <p>Return <strong>true</strong> if the current version is $version or greater.</p>
     *
     * @psalm-pure
     */
    public static function is_php($version): bool
    {
        /**
         * @psalm-suppress ImpureStaticVariable
         *
         * @var bool[]
         */
        static $_IS_PHP;

        $version = (string) $version;

        if (!isset($_IS_PHP[$version])) {
            $_IS_PHP[$version] = \version_compare(\PHP_VERSION, $version, '>=');
        }

        return $_IS_PHP[$version];
    }
}
