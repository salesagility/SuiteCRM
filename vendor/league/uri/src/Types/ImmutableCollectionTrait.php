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
namespace League\Uri\Types;

use ArrayIterator;
use InvalidArgumentException;
use League\Uri\Interfaces\Collection;
use Traversable;

/**
 * Common methods for Immutable Collection objects
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since  4.0.0
 */
trait ImmutableCollectionTrait
{
    /**
     * The Component Data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Count elements of an object
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Returns an external iterator
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Returns an array representation of the collection
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Returns whether the given key exists in the current instance
     *
     * @param string $offset
     *
     * @return bool
     */
    public function hasKey($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * Returns the component $keys.
     *
     * If a value is specified only the keys associated with
     * the given value will be returned
     *
     * @return array
     */
    public function keys()
    {
        if (0 === func_num_args()) {
            return array_keys($this->data);
        }

        return array_keys($this->data, func_get_arg(0), true);
    }

    /**
     * Returns an instance without the specified keys
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified component
     *
     * @param array $offsets the list of keys to remove from the collection
     *
     * @return static
     */
    public function without(array $offsets)
    {
        $data = $this->data;
        foreach ($offsets as $offset) {
            unset($data[$offset]);
        }

        return $this->newCollectionInstance($data);
    }

    /**
     * Returns an instance with only the specified value
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified component
     *
     * @param callable $callable the list of keys to keep from the collection
     * @param int      $flag     flag to determine what argument are sent to callback
     *
     * @return static
     */
    public function filter(callable $callable, $flag = Collection::FILTER_USE_VALUE)
    {
        static $flags_list = [
            Collection::FILTER_USE_VALUE => 1,
            Collection::FILTER_USE_BOTH => 1,
            Collection::FILTER_USE_KEY => 1,
        ];

        if (!isset($flags_list[$flag])) {
            throw new InvalidArgumentException('Invalid or Unknown flag parameter');
        }

        if ($flag === Collection::FILTER_USE_KEY) {
            return $this->filterByKeys($callable);
        }

        if ($flag === Collection::FILTER_USE_BOTH) {
            return $this->filterBoth($callable);
        }

        return $this->newCollectionInstance(array_filter($this->data, $callable));
    }

    /**
     * Return a new instance when needed
     *
     * @param array $data
     *
     * @return Collection
     */
    abstract protected function newCollectionInstance(array $data);

    /**
     * Filter The Collection according to its offsets
     *
     * @param callable $callable
     *
     * @return static
     */
    protected function filterByKeys(callable $callable)
    {
        $data = [];
        foreach (array_filter(array_keys($this->data), $callable) as $offset) {
            $data[$offset] = $this->data[$offset];
        }

        return $this->newCollectionInstance($data);
    }

    /**
     * Filter The Collection according to its offsets AND its values
     *
     * @param callable $callable
     *
     * @return static
     */
    protected function filterBoth(callable $callable)
    {
        $data = [];
        foreach ($this->data as $key => $value) {
            if (true === call_user_func($callable, $value, $key)) {
                $data[$key] = $value;
            }
        }

        return $this->newCollectionInstance($data);
    }

    /**
     * Validate an Iterator or an array
     *
     * @param Traversable|array $data
     *
     * @throws InvalidArgumentException if the value can not be converted
     *
     * @return array
     */
    protected static function validateIterator($data)
    {
        if ($data instanceof Traversable) {
            return iterator_to_array($data);
        }

        if (is_array($data)) {
            return $data;
        }

        throw new InvalidArgumentException(
            'Data passed to the method must be an array or a Traversable object'
        );
    }
}
