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
use League\Uri\Components\Host;
use League\Uri\Components\Query;
use League\Uri\Interfaces\Host as HostInterface;
use League\Uri\Interfaces\Query as QueryInterface;
use League\Uri\Interfaces\Uri;
use League\Uri\Interfaces\UriPart;
use League\Uri\Schemes\Generic\UriBuilderTrait;
use Psr\Http\Message\UriInterface;

/**
 * A class to manipulate URI and URI components output
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class Formatter
{
    use UriBuilderTrait;

    const HOST_AS_UNICODE = 1;

    const HOST_AS_ASCII = 2;

    /**
     * host encoding property
     *
     * @var int
     */
    protected $hostEncoding = self::HOST_AS_UNICODE;

    /**
     * query encoding property
     *
     * @var int
     */
    protected $queryEncoding = PHP_QUERY_RFC3986;

    /**
     * Query Parser object
     *
     * @var QueryParser
     */
    protected $queryParser;

    /**
     * query separator property
     *
     * @var string
     */
    protected $querySeparator = '&';

    /**
     * Should the query component be preserved
     *
     * @var bool
     */
    protected $preserveQuery = false;

    /**
     * Should the fragment component string be preserved
     *
     * @var bool
     */
    protected $preserveFragment = false;

    /**
     * New Instance
     */
    public function __construct()
    {
        $this->queryParser = new QueryParser();
    }

    /**
     * Host encoding setter
     *
     * @param int $encode a predefined constant value
     */
    public function setHostEncoding($encode)
    {
        if (!in_array($encode, [self::HOST_AS_UNICODE, self::HOST_AS_ASCII])) {
            throw new InvalidArgumentException('Unknown Host encoding rule');
        }
        $this->hostEncoding = $encode;
    }

    /**
     * Host encoding getter
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @return int
     */
    public function getHostEncoding()
    {
        return $this->hostEncoding;
    }

    /**
     * Query encoding setter
     *
     * @param int $encode a predefined constant value
     */
    public function setQueryEncoding($encode)
    {
        if (!in_array($encode, [PHP_QUERY_RFC3986, PHP_QUERY_RFC1738])) {
            throw new InvalidArgumentException('Unknown Query encoding rule');
        }
        $this->queryEncoding = $encode;
    }

    /**
     * Query encoding getter
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @return int
     */
    public function getQueryEncoding()
    {
        return $this->queryEncoding;
    }

    /**
     * Query separator setter
     *
     * @param string $separator
     */
    public function setQuerySeparator($separator)
    {
        $separator = filter_var($separator, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

        $this->querySeparator = trim($separator);
    }

    /**
     * Query separator getter
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @return string
     */
    public function getQuerySeparator()
    {
        return $this->querySeparator;
    }

    /**
     * Whether we should preserve the Query component
     * regardless of its value.
     *
     * If set to true the query delimiter will be appended
     * to the URI regardless of the query string value
     *
     * @param bool $status
     */
    public function preserveQuery($status)
    {
        $this->preserveQuery = (bool) $status;
    }

    /**
     * Whether we should preserve the Fragment component
     * regardless of its value.
     *
     * If set to true the fragment delimiter will be appended
     * to the URI regardless of the query string value
     *
     * @param bool $status
     */
    public function preserveFragment($status)
    {
        $this->preserveFragment = (bool) $status;
    }

    /**
     * Format an object
     *
     * @see Formatter::format
     *
     * @param UriPart|Uri|UriInterface $input
     *
     * @return string
     */
    public function __invoke($input)
    {
        return $this->format($input);
    }

    /**
     * Format an object
     *
     * Format an object according to the formatter properties.
     * The object must implement one of the following interface:
     * <ul>
     * <li>League\Uri\Interfaces\Uri
     * <li>League\Uri\Interfaces\UriPart
     * <li>Psr\Http\Message\UriInterface
     * </ul>
     *
     * @param UriPart|Uri|UriInterface $input
     *
     * @return string
     */
    public function format($input)
    {
        if ($input instanceof UriPart) {
            return $this->formatUriPart($input);
        }

        if ($input instanceof Uri || $input instanceof UriInterface) {
            return $this->formatUri($input);
        }

        throw new InvalidArgumentException(
            'input must be an URI object or a League UriPart object'
        );
    }

    /**
     * Format a UriPart implemented object according to the Formatter properties
     *
     * @param UriPart $part
     *
     * @return string
     */
    protected function formatUriPart(UriPart $part)
    {
        if ($part instanceof QueryInterface) {
            return $this->queryParser->build($part->toArray(), $this->querySeparator, $this->queryEncoding);
        }

        if ($part instanceof HostInterface) {
            return $this->formatHost($part);
        }

        return $part->__toString();
    }

    /**
     * Format a Host according to the Formatter properties
     *
     * @param HostInterface $host
     *
     * @return string
     */
    protected function formatHost(HostInterface $host)
    {
        if (self::HOST_AS_ASCII === $this->hostEncoding) {
            return $host->toAscii()->__toString();
        }

        return $host->toUnicode()->__toString();
    }

    /**
     * Format an Uri according to the Formatter properties
     *
     * @param Uri|UriInterface $uri
     *
     * @return string
     */
    protected function formatUri($uri)
    {
        $scheme = $uri->getScheme();
        if ('' !== $scheme) {
            $scheme .= ':';
        }

        $path = $uri->getPath();
        if ('' != $uri->getAuthority() && '' != $path && '/' != $path[0]) {
            $path = '/'.$path;
        }

        return $scheme
            .$this->formatAuthority($uri)
            .$path
            .$this->formatQuery($uri)
            .$this->formatFragment($uri)
        ;
    }

    /**
     * Format a URI authority according to the Formatter properties
     *
     * @param Uri|UriInterface $uri
     *
     * @return string
     */
    protected function formatAuthority($uri)
    {
        if ('' === $uri->getAuthority()) {
            return '';
        }

        $userInfo = $uri->getUserInfo();
        if ('' !== $userInfo) {
            $userInfo .= '@';
        }

        return '//'
            .$userInfo
            .$this->formatHost(new Host($uri->getHost()))
            .$this->formatPort($uri->getPort())
        ;
    }

    /**
     * Format a URI port component according to the Formatter properties
     *
     * @param null|int $port
     *
     * @return string
     */
    protected function formatPort($port)
    {
        if (null !== $port) {
            return ':'.$port;
        }

        return '';
    }

    /**
     * Format a URI Query component according to the Formatter properties
     *
     * @param Uri|UriInterface $uri
     *
     * @return string
     */
    protected function formatQuery($uri)
    {
        $query = $this->formatUriPart(new Query($uri->getQuery()));
        if ($this->preserveQuery || '' !== $query) {
            $query = '?'.$query;
        }

        return $query;
    }

    /**
     * Format a URI Fragment component according to the Formatter properties
     *
     * @param Uri|UriInterface $uri
     *
     * @return string
     */
    protected function formatFragment($uri)
    {
        $fragment = $uri->getFragment();
        if ($this->preserveFragment || '' != $fragment) {
            $fragment = '#'.$fragment;
        }

        return $fragment;
    }
}
