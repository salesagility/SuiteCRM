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

use InvalidArgumentException;
use League\Uri\Components\Query;

/**
 * Sort the URI object Query
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class KsortQuery extends AbstractQueryModifier
{
    /**
     * Sort algorithm use to sort the query string keys
     *
     * @var callable|int
     */
    protected $sort;

    /**
     * New instance
     *
     * @param callable|int $sort a PHP sort flag constant or a comparison function
     *                           which must return an integer less than, equal to,
     *                           or greater than zero if the first argument is
     *                           considered to be respectively less than, equal to,
     *                           or greater than the second.
     */
    public function __construct($sort = SORT_REGULAR)
    {
        $this->sort = $this->filterAlgorithm($sort);
    }

    /**
     * Validate the sorting Parameter
     *
     * @param callable|int $sort a PHP sort flag constant or a comparison function
     *                           which must return an integer less than, equal to,
     *                           or greater than zero if the first argument is
     *                           considered to be respectively less than, equal to,
     *                           or greater than the second.
     *
     * @throws InvalidArgumentException if the sort argument is invalid
     *
     * @return callable|int
     */
    protected function filterAlgorithm($sort)
    {
        if (is_callable($sort) || is_int($sort)) {
            return $sort;
        }

        throw new InvalidArgumentException('The submitted keys are invalid');
    }

    /**
     * Return a new instance with a new sort algorithm
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @param callable|int $sort a PHP sort flag constant or a comparison function
     *                           which must return an integer less than, equal to,
     *                           or greater than zero if the first argument is
     *                           considered to be respectively less than, equal to,
     *                           or greater than the second.
     *
     * @return $this
     */
    public function withAlgorithm($sort)
    {
        $clone = clone $this;
        $clone->sort = $clone->filterAlgorithm($sort);

        return $clone;
    }

    /**
     * Modify a URI part
     *
     * @param string $str the URI part string representation
     *
     * @return string the modified URI part string representation
     */
    protected function modify($str)
    {
        return (string) (new Query($str))->ksort($this->sort);
    }
}
