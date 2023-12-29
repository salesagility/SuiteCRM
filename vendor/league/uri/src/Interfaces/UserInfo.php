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
namespace League\Uri\Interfaces;

/**
 * Value object representing the UserInfo part of an URI.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 * @see     https://tools.ietf.org/html/rfc3986#section-3.2.1
 */
interface UserInfo extends UriPart
{
    const DELIMITER = '@';

    const SEPARATOR = ':';

    /**
     * Retrieve the user component of the URI User Info part
     *
     * @return string
     */
    public function getUser();

    /**
     * Retrieve the pass component of the URI User Info part
     *
     * @return string
     */
    public function getPass();

    /**
     * Return an instance with the specified user.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified user.
     *
     * An empty user is equivalent to removing the user information.
     *
     * @param string $user The user to use with the new instance.
     *
     * @throws \InvalidArgumentException for invalid user.
     *
     * @return static
     */
    public function withUser($user);

    /**
     * Return an instance with the specified password.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified password.
     *
     * An empty password is equivalent to removing the password.
     *
     * @param string $pass The password to use with the new instance.
     *
     * @throws \InvalidArgumentException for invalid password.
     *
     * @return static
     */
    public function withPass($pass);
}
