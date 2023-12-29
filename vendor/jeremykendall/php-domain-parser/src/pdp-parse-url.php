<?php

/**
 * PHP Domain Parser: Public Suffix List based URL parsing.
 *
 * @link      http://github.com/jeremykendall/php-domain-parser for the canonical source repository
 *
 * @copyright Copyright (c) 2014 Jeremy Kendall (http://about.me/jeremykendall)
 * @license   http://github.com/jeremykendall/php-domain-parser/blob/master/LICENSE MIT License
 */
namespace {
    if (!function_exists('pdp_parse_url')) {
        /**
         * UTF-8 aware parse_url() replacement.
         *
         * Taken from php.net manual comments {@link http://php.net/manual/en/function.parse-url.php#114817}
         *
         * @param string $url       The URL to parse
         * @param int    $component Specify one of PHP_URL_SCHEME, PHP_URL_HOST,
         *                          PHP_URL_PORT, PHP_URL_USER, PHP_URL_PASS, PHP_URL_PATH, PHP_URL_QUERY or
         *                          PHP_URL_FRAGMENT to retrieve just a specific URL component as a string
         *                          (except when PHP_URL_PORT is given, in which case the return value will
         *                          be an integer).
         *
         * @return mixed See parse_url documentation {@link http://us1.php.net/parse_url}
         */
        function pdp_parse_url($url, $component = -1)
        {
            $pattern = '%([a-zA-Z][a-zA-Z0-9+\-.]*)?(:?//)?([^:/@?&=#\[\]]+)%usD';

            $enc_url = preg_replace_callback(
                $pattern,
                function ($matches) {
                    $encoded = urlencode($matches[3]);

                    return sprintf('%s%s%s', $matches[1], $matches[2], $encoded);
                },
                    $url
                );

            $parts = parse_url($enc_url, $component);

            if ($parts === false) {
                return $parts;
            }

            if (is_array($parts)) {
                foreach ($parts as $name => $value) {
                    if ($name === 'scheme') {
                        continue;
                    }

                    $parts[$name] = urldecode($value);
                }
            } else {
                $parts = urldecode($parts);
            }

            return $parts;
        }
    }
}
