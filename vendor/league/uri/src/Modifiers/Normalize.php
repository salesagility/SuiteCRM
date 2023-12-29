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

use League\Uri\Interfaces\Uri;
use Psr\Http\Message\UriInterface;

/**
 * A class to normalize URI objects
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class Normalize extends AbstractUriModifier
{
    /**
     * Return a Uri object modified according to the modifier
     *
     * @param Uri|UriInterface $uri
     *
     * @return Uri|UriInterface
     */
    public function __invoke($uri)
    {
        $this->assertUriObject($uri);
        $modifiers = $this->getDefaultModifiers();
        $path = $uri->getPath();
        if ('' !== $uri->getScheme().$uri->getAuthority()
            || (isset($path[0]) && '/' === $path[0])) {
            return $modifiers->pipe(new RemoveDotSegments())->__invoke($uri);
        }

        return $modifiers->__invoke($uri);
    }

    /**
     * Return the default modifier to apply on any URI object
     *
     * @return array
     */
    protected function getDefaultModifiers()
    {
        static $defaults;
        if (null === $defaults) {
            $defaults = new Pipeline([
                new HostToAscii(),
                new KsortQuery(),
                new DecodeUnreservedCharacters(),
            ]);
        }

        return $defaults;
    }
}
