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

use InvalidArgumentException;
use League\Uri\Components\HostIpTrait;
use League\Uri\Components\HostnameTrait;
use League\Uri\Schemes\Generic\UriBuilderTrait;
use League\Uri\Types\ValidatorTrait;

/**
 * a class to parse a URI string according to RFC3986
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class UriParser
{
    use HostIpTrait;

    use HostnameTrait;

    use UriBuilderTrait;

    use ValidatorTrait;

    const REGEXP_URI = ',^
        ((?<scheme>[^:/?\#]+):)?      # URI scheme component
        (?<authority>//([^/?\#]*))?   # URI authority part
        (?<path>[^?\#]*)              # URI path component
        (?<query>\?([^\#]*))?         # URI query component
        (?<fragment>\#(.*))?          # URI fragment component
    ,x';

    const REGEXP_AUTHORITY = ',^(?<userinfo>(?<ucontent>.*?)@)?(?<hostname>.*?)?$,';

    const REGEXP_REVERSE_HOSTNAME = ',^((?<port>[^(\[\])]*):)?(?<host>.*)?$,';

    const REGEXP_SCHEME = ',^([a-z]([-a-z0-9+.]+)?)?$,i';

    const REGEXP_INVALID_USER = ',[/?#@:],';

    const REGEXP_INVALID_PASS = ',[/?#@],';


    /**
     * Parse a string as an URI according to the regexp form rfc3986
     *
     * @param string $uri
     *
     * @return array
     */
    public function parse($uri)
    {
        $parts = $this->extractUriParts($uri);

        return $this->normalizeUriHash(array_merge(
            $this->parseAuthority($parts['authority']),
            [
                'scheme' => '' === $parts['scheme'] ? null : $parts['scheme'],
                'path' => $parts['path'],
                'query' => '' === $parts['query'] ? null : mb_substr($parts['query'], 1, null, 'UTF-8'),
                'fragment' => '' === $parts['fragment'] ? null : mb_substr($parts['fragment'], 1, null, 'UTF-8'),
            ]
        ));
    }

    /**
     * Parse a string as an URI according to the regexp form rfc3986
     *
     * @see UriParser::parse
     *
     * @param string $uri The URI to parse
     *
     * @return array the array is similar to PHP's parse_url hash response
     */
    public function __invoke($uri)
    {
        return $this->parse($uri);
    }

    /**
     * Extract URI parts
     *
     * @see http://tools.ietf.org/html/rfc3986#appendix-B
     *
     * @param string $uri The URI to split
     *
     * @return string[]
     */
    protected function extractUriParts($uri)
    {
        preg_match(self::REGEXP_URI, $uri, $parts);
        $parts += ['query' => '', 'fragment' => ''];

        if (preg_match(self::REGEXP_SCHEME, $parts['scheme'])) {
            return $parts;
        }

        $parts['path'] = $parts['scheme'].':'.$parts['authority'].$parts['path'];
        $parts['scheme'] = '';
        $parts['authority'] = '';

        return $parts;
    }

    /**
     * Parse a URI authority part into its components
     *
     * @param string $authority
     *
     * @return array
     */
    protected function parseAuthority($authority)
    {
        $res = ['user' => null, 'pass' => null, 'host' => null, 'port' => null];
        if ('' === $authority) {
            return $res;
        }

        $content = mb_substr($authority, 2, null, 'UTF-8');
        if ('' === $content) {
            return ['host' => ''] + $res;
        }

        preg_match(self::REGEXP_AUTHORITY, $content, $auth);
        if ('' !== $auth['userinfo']) {
            $userinfo = explode(':', $auth['ucontent'], 2);
            $res = ['user' => array_shift($userinfo), 'pass' => array_shift($userinfo)] + $res;
        }

        return $this->parseHostname($auth['hostname']) + $res;
    }

    /**
     * Parse the hostname into its components Host and Port
     *
     * No validation is done on the port or host component found
     *
     * @param string $hostname
     *
     * @return array
     */
    protected function parseHostname($hostname)
    {
        $components = ['host' => null, 'port' => null];
        $hostname = strrev($hostname);
        if (preg_match(self::REGEXP_REVERSE_HOSTNAME, $hostname, $res)) {
            $components['host'] = strrev($res['host']);
            $components['port'] = strrev($res['port']);
        }
        $components['host'] = $this->filterHost($components['host']);
        $components['port'] = $this->validatePort($components['port']);

        return $components;
    }

    /**
     * validate the host component
     *
     * @param string $host
     *
     * @return string
     */
    protected function filterHost($host)
    {
        if (empty($this->validateIpHost($host))) {
            $this->validateStringHost($host);
        }

        return $host;
    }

    /**
     * @inheritdoc
     */
    protected function setIsAbsolute($host)
    {
        return ('.' === mb_substr($host, -1, 1, 'UTF-8')) ? mb_substr($host, 0, -1, 'UTF-8') : $host;
    }

    /**
     * @inheritdoc
     */
    protected function assertLabelsCount(array $labels)
    {
        if (127 <= count($labels)) {
            throw new InvalidArgumentException('Invalid Host, verify labels count');
        }
    }
}
