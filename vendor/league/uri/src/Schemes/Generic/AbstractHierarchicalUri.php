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
namespace League\Uri\Schemes\Generic;

use League\Uri\Components\Fragment;
use League\Uri\Components\HierarchicalPath as Path;
use League\Uri\Components\Host;
use League\Uri\Components\Pass;
use League\Uri\Components\Port;
use League\Uri\Components\Query;
use League\Uri\Components\Scheme;
use League\Uri\Components\User;
use League\Uri\Components\UserInfo;
use League\Uri\Interfaces\Fragment as FragmentInterface;
use League\Uri\Interfaces\HierarchicalPath as PathInterface;
use League\Uri\Interfaces\Host as HostInterface;
use League\Uri\Interfaces\Port as PortInterface;
use League\Uri\Interfaces\Query as QueryInterface;
use League\Uri\Interfaces\Scheme as SchemeInterface;
use League\Uri\Interfaces\UserInfo as UserInfoInterface;
use League\Uri\UriParser;

/**
 * Value object representing a Hierarchical URI.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 *
 * @property-read SchemeInterface   $scheme
 * @property-read UserInfoInterface $userInfo
 * @property-read HostInterface     $host
 * @property-read PortInterface     $port
 * @property-read PathInterface     $path
 * @property-read QueryInterface    $query
 * @property-read FragmentInterface $fragment
 */
abstract class AbstractHierarchicalUri extends AbstractUri
{
    /**
     * Create a new instance of URI
     *
     * @param SchemeInterface   $scheme
     * @param UserInfoInterface $userInfo
     * @param HostInterface     $host
     * @param PortInterface     $port
     * @param PathInterface     $path
     * @param QueryInterface    $query
     * @param FragmentInterface $fragment
     */
    public function __construct(
        SchemeInterface $scheme,
        UserInfoInterface $userInfo,
        HostInterface $host,
        PortInterface $port,
        PathInterface $path,
        QueryInterface $query,
        FragmentInterface $fragment
    ) {
        $this->scheme = $scheme;
        $this->userInfo = $userInfo;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
        $this->assertValidObject();
    }

    /**
     * Create a new instance from a string
     *
     * @param string $uri
     *
     * @return static
     */
    public static function createFromString($uri = '')
    {
        return static::createFromComponents((new UriParser())->__invoke($uri));
    }

    /**
     * Create a new instance from a hash of parse_url parts
     *
     * @param array $components a hash representation of the URI similar to PHP parse_url function result
     *
     * @return static
     */
    public static function createFromComponents(array $components)
    {
        $components = self::normalizeUriHash($components);

        return new static(
            new Scheme($components['scheme']),
            new UserInfo(new User($components['user']), new Pass($components['pass'])),
            new Host($components['host']),
            new Port($components['port']),
            new Path($components['path']),
            new Query($components['query']),
            new Fragment($components['fragment'])
        );
    }

    /**
     * @inheritdoc
     */
    public static function __set_state(array $properties)
    {
        return new static(
            $properties['scheme'],
            $properties['userInfo'],
            $properties['host'],
            $properties['port'],
            $properties['path'],
            $properties['query'],
            $properties['fragment']
        );
    }

    /**
     * Tell whether URI with an authority are valid
     *
     * @return bool
     */
    protected function isValidHierarchicalUri()
    {
        $this->assertSupportedScheme();

        return $this->isAuthorityValid();
    }

    /**
     * Tell whether the Authority part is valid
     *
     * @return bool
     */
    protected function isAuthorityValid()
    {
        $pos = strpos($this->getSchemeSpecificPart(), '//');
        if ('' !== $this->getScheme() && 0 !== $pos) {
            return false;
        }

        return !('' === $this->getHost() && 0 === $pos);
    }
}
