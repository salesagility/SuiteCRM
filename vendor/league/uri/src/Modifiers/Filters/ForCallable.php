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

/**
 * Trait to register a callable
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 * @internal
 */
trait ForCallable
{
    /**
     * a filter callable to filter the
     * data to keep
     *
     * @var callable
     */
    protected $callable;

    /**
     * Return a new instance with a new set of keys
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @param callable $callable should filter the component to list the data to keep
     *
     * @return self
     */
    public function withCallable(callable $callable)
    {
        $clone = clone $this;
        $clone->callable = $callable;

        return $clone;
    }
}
