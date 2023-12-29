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

use InvalidArgumentException;
use League\Uri\Interfaces\Fragment;
use League\Uri\Interfaces\Host;
use League\Uri\Interfaces\Path;
use League\Uri\Interfaces\Port;
use League\Uri\Interfaces\Query;
use League\Uri\Interfaces\Scheme;
use League\Uri\Interfaces\UserInfo;
use League\Uri\Types\ImmutablePropertyTrait;

/**
 * common URI Object properties and methods
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
abstract class AbstractUri
{
    use ImmutablePropertyTrait;

    use UriBuilderTrait;

    /**
     * Scheme Component
     *
     * @var Scheme
     */
    protected $scheme;

    /**
     * User Information Part
     *
     * @var UserInfo
     */
    protected $userInfo;

    /**
     * Host Component
     *
     * @var Host
     */
    protected $host;

    /**
     * Port Component
     *
     * @var Port
     */
    protected $port;

    /**
     * Path Component
     *
     * @var Path
     */
    protected $path;

    /**
     * Query Component
     *
     * @var Query
     */
    protected $query;

    /**
     * Fragment Component
     *
     * @var Fragment
     */
    protected $fragment;

    /**
     * Supported Schemes
     *
     * @var array
     */
    protected static $supportedSchemes = [];

    /**
     * @inheritdoc
     */
    public function getScheme()
    {
        return $this->scheme->__toString();
    }

    /**
     * @inheritdoc
     */
    public function getUserInfo()
    {
        return $this->userInfo->__toString();
    }

    /**
     * @inheritdoc
     */
    public function getHost()
    {
        return $this->host->__toString();
    }

    /**
     * @inheritdoc
     */
    public function getPort()
    {
        return $this->hasStandardPort() ? null : $this->port->getContent();
    }

    /**
     * Returns whether the standard port for the given scheme is used, when
     * the scheme is unknown or unsupported will the method return false
     *
     * @return bool
     */
    protected function hasStandardPort()
    {
        $port = $this->port->getContent();
        if (null === $port) {
            return true;
        }

        $scheme = $this->scheme->__toString();
        if ('' === $scheme) {
            return false;
        }

        return isset(static::$supportedSchemes[$scheme])
            && static::$supportedSchemes[$scheme] === $port;
    }

    /**
     * @inheritdoc
     */
    public function getPath()
    {
        return $this->path->__toString();
    }

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        return $this->query->__toString();
    }

    /**
     * @inheritdoc
     */
    public function getFragment()
    {
        return $this->fragment->__toString();
    }

    /**
     * @inheritdoc
     */
    public function withScheme($scheme)
    {
        return $this->withProperty('scheme', $this->filterPropertyValue($scheme));
    }

    /**
     * @inheritdoc
     */
    public function withUserInfo($user, $password = null)
    {
        if (null === $password) {
            $password = '';
        }

        $userInfo = $this->userInfo
            ->withUser($this->filterPropertyValue($user))
            ->withPass($password);

        if ($this->userInfo->getUser() === $userInfo->getUser()
            && $this->userInfo->getPass() === $userInfo->getPass()
        ) {
            return $this;
        }

        $clone = clone $this;
        $clone->userInfo = $userInfo;

        return $clone;
    }

    /**
     * @inheritdoc
     */
    public function withHost($host)
    {
        return $this->withProperty('host', $this->filterPropertyValue($host));
    }

    /**
     * @inheritdoc
     */
    public function withPort($port)
    {
        return $this->withProperty('port', $port);
    }

    /**
     * @inheritdoc
     */
    public function withPath($path)
    {
        return $this->withProperty('path', $path);
    }

    /**
     * @inheritdoc
     */
    public function withQuery($query)
    {
        return $this->withProperty('query', $this->filterPropertyValue($query));
    }

    /**
     * @inheritdoc
     */
    public function withFragment($fragment)
    {
        return $this->withProperty('fragment', $this->filterPropertyValue($fragment));
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['uri' => $this->__toString()];
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->scheme->getUriComponent().$this->getSchemeSpecificPart();
    }

    /**
     * Retrieve the scheme specific part of the URI.
     *
     * If no specific part information is present, this method MUST return an empty
     * string.
     *
     * @return string
     */
    protected function getSchemeSpecificPart()
    {
        $authority = $this->getAuthority();

        $res = array_filter([
            $this->userInfo->getContent(),
            $this->host->getContent(),
            $this->port->getContent(),
        ], function ($value) {
            return null !== $value;
        });

        if (!empty($res)) {
            $authority = '//'.$authority;
        }

        return $authority
            .$this->path->getUriComponent()
            .$this->query->getUriComponent()
            .$this->fragment->getUriComponent();
    }

    /**
     * @inheritdoc
     */
    public function getAuthority()
    {
        $port = '';
        if (!$this->hasStandardPort()) {
            $port = $this->port->getUriComponent();
        }

        return $this->userInfo->getUriComponent()
            .$this->host->getUriComponent()
            .$port;
    }

    /**
     * Assert if the current URI object is valid
     *
     * @throws InvalidArgumentException for transformations that would result in an object in invalid state.
     */
    protected function assertValidObject()
    {
        if (!$this->isValid()) {
            throw new InvalidArgumentException(sprintf(
                'The URI components will produce a `%s` instance in invalid state',
                get_class($this)
            ));
        }
    }

    /**
     * Tell whether the current URI is valid.
     *
     * The URI object validity depends on the scheme. This method
     * MUST be implemented on every URI object
     *
     * @return bool
     */
    abstract protected function isValid();

    /**
     *  Tell whether any generic URI is valid
     *
     * @return bool
     */
    protected function isValidGenericUri()
    {
        $path = $this->path->getUriComponent();
        if ('' !== $this->getAuthority()) {
            return '' === $path || strpos($path, '/') === 0;
        }

        if (0 === strpos($path, '//')) {
            return false;
        }

        if ('' !== $this->scheme->getUriComponent() || false === ($pos = strpos($path, ':'))) {
            return true;
        }

        return false !== strpos(substr($path, 0, $pos), '/');
    }

    /**
     * Assert whether the current scheme is supported by the URI object
     *
     * @throws InvalidArgumentException If the Scheme is not supported
     */
    protected function assertSupportedScheme()
    {
        if (!array_key_exists($this->scheme->__toString(), static::$supportedSchemes)) {
            throw new InvalidArgumentException(sprintf(
                'The submitted scheme is unsupported by `%s`',
                get_class($this)
            ));
        }
    }
}
