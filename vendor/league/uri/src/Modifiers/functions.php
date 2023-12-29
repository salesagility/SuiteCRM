<?php
/**
 * League.Uri (http://uri.thephpleague.com)
 *
 * @package   League.uri
 * @author    Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @copyright 2016 Ignace Nyamagana Butera
 * @license   https://github.com/thephpleague/uri/blob/master/LICENSE (MIT License)
 * @version   4.1.0
 * @link      https://github.com/thephpleague/uri/
 */
namespace League\Uri\Modifiers;

use InvalidArgumentException;
use League\Uri\Interfaces\Uri;
use Psr\Http\Message\UriInterface;

/**
 * A function to give information about URI Reference
 *
 * This function returns an associative array representing the URI Reference information:
 * each key represents a given state and each value is a boolean to indicate the current URI
 * status against the declared state.
 *
 * <ul>
 * <li>absolute_uri: Tell whether the URI is absolute
 * <li>network_path: Tell whether the URI is a network-path relative reference
 * <li>absolute_path: Tell whether the URI is a absolute-path relative reference
 * <li>relative_path: Tell whether the URI is a relative-path relative reference
 * <li>same_document: Tell whether the URI is a same-document relative reference
 * </ul>
 *
 * @link https://tools.ietf.org/html/rfc3986#section-4.2
 * @link https://tools.ietf.org/html/rfc3986#section-4.3
 * @link https://tools.ietf.org/html/rfc3986#section-4.4
 *
 * @since 4.2.0
 *
 * @param Uri|UriInterface      $uri      The uri to get reference info from
 * @param Uri|UriInterface|null $base_uri The base uri to use to get same document reference info
 *
 * @throws InvalidArgumentException if the submitted Uri is invalid
 *
 * @return array
 */
function uri_reference($uri, $base_uri = null)
{
    if (!$uri instanceof Uri && !$uri instanceof UriInterface) {
        throw new InvalidArgumentException(
            'URI passed must implement PSR-7 UriInterface or League\Uri Uri interface'
        );
    }

    if (null !== $base_uri && (!$base_uri instanceof Uri && !$base_uri instanceof UriInterface)) {
        throw new InvalidArgumentException(
            'The base URI passed must implement PSR-7 UriInterface or League\Uri Uri interface'
        );
    }

    $infos = [
        'absolute_uri' => false,
        'network_path' => false,
        'absolute_path' => false,
        'relative_path' => false,
        'same_document' => false,
    ];

    static $normalizer;
    if (null === $normalizer) {
        $normalizer = new Normalize();
    }

    if (null !== $base_uri) {
        $uri_string = (string) $normalizer($uri)->withFragment('');
        $base_uri_string = (string) $normalizer($base_uri)->withFragment('');
        $infos['same_document'] = $uri_string === $base_uri_string;
    }

    if ('' !== $uri->getScheme()) {
        $infos['absolute_uri'] = true;

        return $infos;
    }

    if ('' !== $uri->getAuthority()) {
        $infos['network_path'] = true;

        return $infos;
    }

    $path = $uri->getPath();
    if (isset($path[0]) && '/' === $path[0]) {
        $infos['absolute_path'] = true;

        return $infos;
    }

    $infos['relative_path'] = true;

    return $infos;
}
