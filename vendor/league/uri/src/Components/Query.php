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
namespace League\Uri\Components;

use InvalidArgumentException;
use League\Uri\Interfaces\Query as QueryInterface;
use League\Uri\QueryParser;
use League\Uri\Types\ImmutableCollectionTrait;
use League\Uri\Types\ImmutableComponentTrait;

/**
 * Value object representing a URI query component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   1.0.0
 */
class Query implements QueryInterface
{
    use ImmutableComponentTrait;

    use ImmutableCollectionTrait;

    /**
     * Key/pair separator character
     *
     * @var string
     */
    protected static $separator = '&';

    /**
     * Preserve the delimiter
     *
     * @var bool
     */
    protected $preserveDelimiter = false;

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * return a new instance from an array or a traversable object
     *
     * @param \Traversable|array $data
     *
     * @return static
     */
    public static function createFromArray($data)
    {
        return self::createFromPairs($data);
    }

    /**
     * return a new Query instance from an Array or a traversable object
     *
     * @param \Traversable|array $data
     *
     * @return static
     */
    public static function createFromPairs($data)
    {
        $data = static::validateIterator($data);
        if (empty($data)) {
            return new static();
        }

        $query = (new QueryParser())->build($data, static::$separator);

        return new static($query);
    }

    /**
     * a new instance
     *
     * @param string $data
     */
    public function __construct($data = null)
    {
        $this->data = $this->validate($data);
        $this->preserveDelimiter = null !== $data;
    }

    /**
     * sanitize the submitted data
     *
     * @param string $str
     *
     * @return array
     */
    protected function validate($str)
    {
        if (null === $str) {
            return [];
        }

        $str = $this->filterEncodedQuery($this->validateString($str));

        return (new QueryParser())->parse($str, static::$separator, PHP_QUERY_RFC3986);
    }

    /**
     * Filter the encoded query string
     *
     * @param string $str the encoded query
     *
     * @throws InvalidArgumentException If the encoded query is invalid
     *
     * @return string
     */
    protected function filterEncodedQuery($str)
    {
        if (false === strpos($str, '#')) {
            return $str;
        }

        throw new InvalidArgumentException(sprintf(
            'The encoded query `%s` contains invalid characters',
            $str
        ));
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['query' => $this->getContent()];
    }

    /**
     * @inheritdoc
     */
    public static function __set_state(array $properties)
    {
        $component = static::createFromPairs($properties['data']);
        $component->preserveDelimiter = $properties['preserveDelimiter'];

        return $component;
    }

    /**
     * Returns the component literal value.
     *
     * @return null|string
     */
    public function getContent()
    {
        if (!$this->preserveDelimiter) {
            return null;
        }

        return (new QueryParser())->build($this->data, static::$separator, PHP_QUERY_RFC3986);
    }

    /**
     * Returns the instance string representation; If the
     * instance is not defined an empty string is returned
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getContent();
    }

    /**
     * Returns the instance string representation
     * with its optional URI delimiters
     *
     * @return string
     */
    public function getUriComponent()
    {
        $query = $this->__toString();
        if ($this->preserveDelimiter) {
            return QueryInterface::DELIMITER.$query;
        }

        return $query;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Returns an array representation of the query
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getPairs();
    }

    /**
     * Returns an array representation of the query
     *
     * @return array
     */
    public function getPairs()
    {
        return $this->data;
    }

    /**
     * Retrieves a single query parameter.
     *
     * Retrieves a single query parameter. If the parameter has not been set,
     * returns the default value provided.
     *
     * @param string $offset  the parameter name
     * @param mixed  $default Default value to return if the parameter does not exist.
     *
     * @return mixed
     */
    public function getValue($offset, $default = null)
    {
        $offset = $this->validateString($offset);
        $offset = $this->decodeComponent($offset);
        if (isset($this->data[$offset])) {
            return $this->data[$offset];
        }

        return $default;
    }

    /**
     * Returns an instance with the specified string
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified data
     *
     * @param string $value
     *
     * @return static
     */
    public function withContent($value = null)
    {
        if ($value === $this->getContent()) {
            return $this;
        }

        return new static($value);
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * @see withContent
     *
     * Returns an instance with the specified string
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified data
     *
     * @param string $value
     *
     * @return static
     */
    public function modify($value)
    {
        return $this->withContent($value);
    }

    /**
     * Returns an instance merge with the specified query
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified query
     *
     * @param QueryInterface|string $query the data to be merged
     *
     * @return static
     */
    public function merge($query)
    {
        $pairs = !$query instanceof QueryInterface ? $this->validate($query) : $query->getPairs();
        if ($this->data === $pairs) {
            return $this;
        }

        return static::createFromPairs(array_merge($this->data, $pairs));
    }

    /**
     * Sort the query string by offset, maintaining offset to data correlations.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified query
     *
     * @param callable|int $sort a PHP sort flag constant or a comparaison function
     *                           which must return an integer less than, equal to,
     *                           or greater than zero if the first argument is
     *                           considered to be respectively less than, equal to,
     *                           or greater than the second.
     *
     * @return static
     */
    public function ksort($sort = SORT_REGULAR)
    {
        $func = is_callable($sort) ? 'uksort' : 'ksort';
        $data = $this->data;
        $func($data, $sort);
        if ($data === $this->data) {
            return $this;
        }

        return static::createFromPairs($data);
    }

    /**
     * @inheritdoc
     */
    public function hasKey($offset)
    {
        $offset = $this->validateString($offset);
        $offset = $this->decodeComponent($offset);

        return array_key_exists($offset, $this->data);
    }

    /**
     * @inheritdoc
     */
    public function keys()
    {
        if (0 === func_num_args()) {
            return array_keys($this->data);
        }

        return array_keys($this->data, $this->decodeComponent(func_get_arg(0)), true);
    }

    /**
     * @inheritdoc
     */
    public function without(array $offsets)
    {
        $data = $this->data;
        foreach ($offsets as $offset) {
            unset($data[$this->decodeComponent($offset)]);
        }

        return $this->newCollectionInstance($data);
    }



    /**
     * Return a new instance when needed
     *
     * @param array $data
     *
     * @return static
     */
    protected function newCollectionInstance(array $data)
    {
        if ($data === $this->data) {
            return $this;
        }

        return static::createFromPairs($data);
    }
}
