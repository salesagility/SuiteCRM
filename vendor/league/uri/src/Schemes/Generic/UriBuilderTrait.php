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

/**
 * A trait to format URI components
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.1.0
 * @internal
 */
trait UriBuilderTrait
{
    /**
     * Normalize URI components hash
     *
     * @param array $components a hash representation of the URI components
     *                          similar to PHP parse_url function result
     *
     * @return array
     */
    protected static function normalizeUriHash(array $components)
    {
        return array_replace([
            'scheme' => null,
            'user' => null,
            'pass' => null,
            'host' => null,
            'port' => null,
            'path' => '',
            'query' => null,
            'fragment' => null,
        ], $components);
    }

    /**
     * Format the user info
     *
     * @param string $user
     * @param string $pass
     *
     * @return string
     */
    protected static function buildUserInfo($user, $pass)
    {
        $userinfo = $user;
        if (in_array($userinfo, [null, ''], true)) {
            return '';
        }

        if (!in_array($pass, [null, ''], true)) {
            $userinfo .= ':'.$pass;
        }

        return $userinfo.'@';
    }
}
