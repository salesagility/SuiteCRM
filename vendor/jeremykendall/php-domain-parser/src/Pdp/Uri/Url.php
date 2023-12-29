<?php

/**
 * PHP Domain Parser: Public Suffix List based URL parsing.
 *
 * @link      http://github.com/jeremykendall/php-domain-parser for the canonical source repository
 *
 * @copyright Copyright (c) 2014 Jeremy Kendall (http://about.me/jeremykendall)
 * @license   http://github.com/jeremykendall/php-domain-parser/blob/master/LICENSE MIT License
 */
namespace Pdp\Uri;

use Pdp\Parser;
use Pdp\Uri\Url\Host;

/**
 * An object representation of a Url.
 */
class Url
{
    /**
     * @var string scheme
     */
    protected $scheme;

    /**
     * @var Host Host object
     */
    protected $host;

    /**
     * @var int port
     */
    protected $port;

    /**
     * @var string user
     */
    protected $user;

    /**
     * @var string pass
     */
    protected $pass;

    /**
     * @var string path
     */
    protected $path;

    /**
     * @var string query
     */
    protected $query;

    /**
     * @var string fragment
     */
    protected $fragment;

    /**
     * Public constructor.
     *
     * @param string $scheme   The URL scheme (e.g. `http`).
     * @param string $user     The username.
     * @param string $pass     The password.
     * @param Host   $host     The host elements.
     * @param int    $port     The port number.
     * @param string $path     The path elements, including format.
     * @param string $query    The query elements.
     * @param string $fragment The fragment.
     */
    public function __construct(
        $scheme,
        $user,
        $pass,
        Host $host,
        $port,
        $path,
        $query,
        $fragment
    ) {
        // Ensure scheme is either a legit scheme or null, never an empty string.
        // @see https://github.com/jeremykendall/php-domain-parser/issues/53
        $this->scheme = mb_strtolower($scheme, 'UTF-8') ?: null;
        $this->user = $user;
        $this->pass = $pass;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    /**
     * Gets schemeless url.
     *
     * @return string Url without scheme
     */
    public function getSchemeless()
    {
        return preg_replace(Parser::SCHEME_PATTERN, '//', $this->__toString(), 1);
    }

    /**
     * Converts the URI object to a string and returns it.
     *
     * @return string The full URI this object represents.
     */
    public function __toString()
    {
        $url = null;

        if ($this->scheme) {
            $url .= $this->scheme . '://';
        }

        if ($this->user) {
            $url .= urlencode($this->user);
            if ($this->pass) {
                $url .= ':' . urlencode($this->pass);
            }
            $url .= '@';
        }

        $host = $this->host->__toString();

        if ($host) {
            $url .= $host;
        }

        if ($this->port) {
            $url .= ':' . (int) $this->port;
        }

        if ($this->path) {
            $url .= $this->path;
        }

        if ($this->query) {
            $url .= '?' . $this->query;
        }

        if ($this->fragment) {
            $url .= '#' . urlencode($this->fragment);
        }

        return $url;
    }

    /**
     * Converts the URI object to an array and returns it.
     *
     * @return array Array of URI component parts
     */
    public function toArray()
    {
        return array(
            'scheme' => $this->getScheme(),
            'user' => $this->getUser(),
            'pass' => $this->getPass(),
            'host' => $this->getHost()->__toString(),
            'subdomain' => $this->getHost()->getSubdomain(),
            'registrableDomain' => $this->getHost()->getRegistrableDomain(),
            'publicSuffix' => $this->getHost()->getPublicSuffix(),
            'port' => $this->getPort(),
            'path' => $this->getPath(),
            'query' => $this->getQuery(),
            'fragment' => $this->getFragment(),
        );
    }

    /**
     * Get Scheme.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Get User.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get Pass.
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Get Host object.
     *
     * @return Host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get Port.
     *
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Get Path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get Query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get Fragment.
     *
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }
}
