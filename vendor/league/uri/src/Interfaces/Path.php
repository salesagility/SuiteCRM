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

use InvalidArgumentException;

/**
 * Value object representing a URI Path component.
 *
 * Instances of this interface are considered immutable; all methods that
 * might change state MUST be implemented such that they retain the internal
 * state of the current instance and return an instance that contains the
 * changed state.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 * @see     https://tools.ietf.org/html/rfc3986#section-3.3
 */
interface Path extends Component
{
    const FTP_TYPE_ASCII = 1;

    const FTP_TYPE_BINARY = 2;

    const FTP_TYPE_DIRECTORY = 3;

    const FTP_TYPE_EMPTY = 4;

    /**
     * Returns an instance without dot segments
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component normalized by removing
     * the dot segment.
     *
     * @return static
     */
    public function withoutDotSegments();

    /**
     * Returns an instance without duplicate delimiters
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component normalized by removing
     * multiple consecutive empty segment
     *
     * @return static
     */
    public function withoutEmptySegments();

    /**
     * Returns whether or not the path has a trailing delimiter
     *
     * @return bool
     */
    public function hasTrailingSlash();

    /**
     * Returns an instance with a trailing slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component with a trailing slash
     *
     *
     * @return static
     */
    public function withTrailingSlash();

    /**
     * Returns an instance without a trailing slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component without a trailing slash
     *
     * @return static
     */
    public function withoutTrailingSlash();

    /**
     * Returns whether or not the path is absolute or relative
     *
     * @return bool
     */
    public function isAbsolute();

    /**
     * Returns an instance with a leading slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component with a leading slash
     *
     *
     * @return static
     */
    public function withLeadingSlash();

    /**
     * Returns an instance without a leading slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component without a leading slash
     *
     * @return static
     */
    public function withoutLeadingSlash();

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Retrieve the optional type associated to the path.
     *
     * The value returned MUST be one of the interface constant type
     * If no type is associated the return constant must be self::FTP_TYPE_EMPTY
     *
     * @see http://tools.ietf.org/html/rfc1738#section-3.2.2
     *
     * @return int a typecode constant.
     */
    public function getTypecode();

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Return an instance with the specified typecode.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified type appended to the path.
     * if not
     *
     * Using self::FTP_TYPE_EMPTY is equivalent to removing the typecode.
     *
     * @param int $type one typecode constant.
     *
     * @throws InvalidArgumentException for invalid typecode.
     *
     * @return static
     *
     */
    public function withTypecode($type);
}
