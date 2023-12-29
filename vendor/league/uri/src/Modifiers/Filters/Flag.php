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
namespace League\Uri\Modifiers\Filters;

use InvalidArgumentException;
use League\Uri\Interfaces\Collection;

/**
 * Flag trait to Filter League\Uri Collections
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 * @internal
 */
trait Flag
{
    /**
     * A HostInterface object
     *
     * @var int
     */
    protected $flag;

    /**
     * Available flags
     *
     * @var array
     */
    protected static $flagList = [
        Collection::FILTER_USE_VALUE => 1,
        Collection::FILTER_USE_BOTH => 1,
        Collection::FILTER_USE_KEY => 1,
    ];

    /**
     * Return a instance with the specified host
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @param int $flag the data to be used
     *
     * @throws InvalidArgumentException for invalid flag
     *
     * @return $this
     */
    public function withFlag($flag)
    {
        $clone = clone $this;
        $clone->flag = $clone->filterFlag($flag);

        return $clone;
    }

    /**
     * Filter and validate the host string
     *
     * @param int $flag the data to validate
     *
     * @throws InvalidArgumentException for invalid flag
     *
     * @return int
     */
    protected function filterFlag($flag)
    {
        if (isset(static::$flagList[$flag])) {
            return $flag;
        }

        throw new InvalidArgumentException('Invalid Flag');
    }
}
