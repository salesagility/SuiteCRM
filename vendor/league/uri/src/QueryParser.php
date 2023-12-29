<?php
/**
 * League.Uri (http://uri.thephpleague.com)
 *
 * @package   League.uri
 * @author    Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @copyright 2013-2015 Ignace Nyamagana Butera
 * @license   https://github.com/thephpleague/uri/blob/master/LICENSE (MIT License)
 * @version   4.1.0
 * @link      https://github.com/thephpleague/uri/
 */
namespace League\Uri;

use League\Uri\Types\TranscoderTrait;
use League\Uri\Types\ValidatorTrait;

/**
 * a class to parse a URI query string according to RFC3986
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class QueryParser
{
    use ValidatorTrait;
    use TranscoderTrait;

    /**
     * Parse a query string into an associative array
     *
     * Multiple identical key will generate an array. This function
     * differ from PHP parse_str as:
     *    - it does not modify or remove parameters keys
     *    - it does not create nested array
     *
     * @param string   $str          The query string to parse
     * @param string   $separator    The query string separator
     * @param int|bool $encodingType The query string encoding mechanism
     *
     * @return array
     */
    public function parse($str, $separator = '&', $encodingType = PHP_QUERY_RFC3986)
    {
        $res = [];
        if ('' === $str) {
            return $res;
        }
        $encodingType = $this->validateEncodingType($encodingType);
        $decoder = $this->getDecoder($encodingType);
        foreach (explode($separator, $str) as $pair) {
            $res = $this->parsePair($res, $decoder, $pair);
        }

        return $res;
    }

    /**
     * validate the encoding type for the query related methods
     *
     * @param int|bool $encodingType
     *
     * @return int|bool
     */
    protected function validateEncodingType($encodingType)
    {
        if (!in_array($encodingType, [PHP_QUERY_RFC3986, PHP_QUERY_RFC1738, false])) {
            return PHP_QUERY_RFC3986;
        }

        return $encodingType;
    }

    /**
     * Parse a query string pair
     *
     * @param array    $res     The associative array to add the pair to
     * @param callable $decoder a Callable to decode the query string pair
     * @param string   $pair    The query string pair
     *
     * @return array
     */
    protected function parsePair(array $res, callable $decoder, $pair)
    {
        $param = explode('=', $pair, 2);
        $key = $decoder(array_shift($param));
        $value = array_shift($param);
        if (null !== $value) {
            $value = $decoder($value);
        }

        if (!array_key_exists($key, $res)) {
            $res[$key] = $value;
            return $res;
        }

        if (!is_array($res[$key])) {
            $res[$key] = [$res[$key]];
        }
        $res[$key][] = $value;

        return $res;
    }

    /**
     * Build a query string from an associative array
     *
     * The method expects the return value from Query::parse to build
     * a valid query string. This method differs from PHP http_build_query as:
     *
     *    - it does not modify parameters keys
     *
     * @param array    $arr          Query string parameters
     * @param string   $separator    Query string separator
     * @param int|bool $encodingType Query string encoding
     *
     * @return string
     */
    public function build(array $arr, $separator = '&', $encodingType = PHP_QUERY_RFC3986)
    {
        $encodingType = $this->validateEncodingType($encodingType);
        $encoder = $this->getEncoder($encodingType, $separator);
        $arr = array_map(function ($value) {
            return !is_array($value) ? [$value] : $value;
        }, $arr);

        $pairs = [];
        foreach ($arr as $key => $value) {
            $pairs = array_merge($pairs, $this->buildPair($encoder, $value, $encoder($key)));
        }

        return implode($separator, $pairs);
    }

    /**
     * Build a query key/pair association
     *
     * @param callable $encoder a callable to encode the key/pair association
     * @param array    $value   The query string value
     * @param string   $key     The query string key
     *
     * @return string
     */
    protected function buildPair(callable $encoder, array $value, $key)
    {
        $reducer = function (array $carry, $data) use ($key, $encoder) {
            $pair = $key;
            if (null !== $data) {
                $pair .= '='.call_user_func($encoder, $data);
            }
            $carry[] = $pair;

            return $carry;
        };

        return array_reduce($value, $reducer, []);
    }

    /**
     *subject Return the query string encoding mechanism
     *
     * @param int|bool $encodingType
     *
     * @return callable
     */
    protected function getEncoder($encodingType, $separator)
    {
        $separator = html_entity_decode($separator, ENT_HTML5, 'UTF-8');
        $subdelimChars = str_replace($separator, '', "!$'()*+,;=:@?/&");
        $regexp = '/(%[A-Fa-f0-9]{2})|[^'.self::$unreservedChars.preg_quote($subdelimChars, '/').']+/u';


        if (PHP_QUERY_RFC3986 === $encodingType) {
            return function ($str) use ($regexp) {
                return $this->encode($str, $regexp);
            };
        }

        if (PHP_QUERY_RFC1738 === $encodingType) {
            return function ($str) use ($regexp) {
                return str_replace(['+', '~'], ['%2B', '%7E'], $this->encode($str, $regexp));
            };
        }

        return 'sprintf';
    }

    /**
     * Return the query string decoding mechanism
     *
     * @param int|bool $encodingType
     *
     * @return callable
     */
    protected function getDecoder($encodingType)
    {
        if (PHP_QUERY_RFC3986 === $encodingType) {
            return [$this, 'decodeComponent'];
        }

        return function ($value) {
            return $this->decodeComponent(str_replace('+', ' ', $value));
        };
    }
}
