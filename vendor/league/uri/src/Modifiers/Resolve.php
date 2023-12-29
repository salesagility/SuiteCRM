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
namespace League\Uri\Modifiers;

use League\Uri\Components\Path;
use League\Uri\Interfaces\Uri;
use League\Uri\Modifiers\Filters\Uri as UriFilter;
use Psr\Http\Message\UriInterface;

/**
 * Resolve an URI according to a base URI using
 * RFC3986 rules
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class Resolve extends AbstractUriModifier
{
    use UriFilter;

    /**
     * New instance
     *
     * @param Uri|UriInterface $uri
     */
    public function __construct($uri)
    {
        $this->assertUriObject($uri);
        $this->uri = $uri;
    }

    /**
     * Return a Uri object modified according to the modifier
     *
     * @param Uri|UriInterface $target
     *
     * @return Uri|UriInterface
     */
    public function __invoke($target)
    {
        $meta = uri_reference($target);
        $target_path = $target->getPath();
        if ($meta['absolute_uri']) {
            return $target
                ->withPath((new Path($target_path))->withoutDotSegments()->__toString());
        }

        if ($meta['network_path']) {
            return $target
                ->withScheme($this->uri->getScheme())
                ->withPath((new Path($target_path))->withoutDotSegments()->__toString());
        }

        $user_info = explode(':', $this->uri->getUserInfo(), 2);
        $components = $this->resolvePathAndQuery($target_path, $target->getQuery());

        return $target
            ->withPath($this->formatPath($components['path']))
            ->withQuery($components['query'])
            ->withHost($this->uri->getHost())
            ->withPort($this->uri->getPort())
            ->withUserInfo((string) array_shift($user_info), array_shift($user_info))
            ->withScheme($this->uri->getScheme());
    }

    /**
     * Resolve the URI for a Authority-less target URI
     *
     * @param string $path  the target path component
     * @param string $query the target query component
     *
     * @return string[]
     */
    protected function resolvePathAndQuery($path, $query)
    {
        $components = ['path' => $path, 'query' => $query];

        if ('' === $components['path']) {
            $components['path'] = $this->uri->getPath();
            if ('' === $components['query']) {
                $components['query'] = $this->uri->getQuery();
            }

            return $components;
        }

        if (0 !== strpos($components['path'], '/')) {
            $components['path'] = $this->mergePath($components['path']);
        }

        return $components;
    }

    /**
     * Merging Relative URI path with Base URI path
     *
     * @param string $path
     *
     * @return string
     */
    protected function mergePath($path)
    {
        $base_path = $this->uri->getPath();
        if ('' !== $this->uri->getAuthority() && '' === $base_path) {
            return (string) (new Path($path))->withLeadingSlash();
        }

        if ('' !== $base_path) {
            $segments = explode('/', $base_path);
            array_pop($segments);
            $path = implode('/', $segments).'/'.$path;
        }

        return $path;
    }

    /**
     * Format the resolved path
     *
     * @param string $path
     *
     * @return string
     */
    protected function formatPath($path)
    {
        $path = (new Path($path))->withoutDotSegments();
        if ('' !== $this->uri->getAuthority() && '' !== $path->__toString()) {
            $path = $path->withLeadingSlash();
        }

        return (string) $path;
    }
}
