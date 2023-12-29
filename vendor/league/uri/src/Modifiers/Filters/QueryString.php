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

use League\Uri\Components\Query;
use League\Uri\Types\ValidatorTrait;

/**
 * Query string modifier
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 * @internal
 */
trait QueryString
{
    use ValidatorTrait;

    /**
     * A Query object
     *
     * @var Query
     */
    protected $query;

    /**
     * Return a instance with the specified query string
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @param string $query the data to be merged
     *
     * @return $this
     */
    public function withQuery($query)
    {
        $query = $this->filterQuery($query);
        $clone = clone $this;
        $clone->query = $query;

        return $clone;
    }

    /**
     * Filter and validate the query data
     *
     * @param string $query the data to be merged
     *
     * @return Query
     */
    protected function filterQuery($query)
    {
        return new Query($this->validateString($query));
    }
}
