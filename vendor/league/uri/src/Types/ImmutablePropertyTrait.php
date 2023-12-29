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

use InvalidArgumentException;
use RuntimeException;

/**
 * A trait to set and get immutable value
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
trait ImmutablePropertyTrait
{
    /**
     * Returns an instance with the modified component
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the modified component
     *
     * @param string $property the property to set
     * @param string $value    the property value
     *
     * @return static
     */
    protected function withProperty($property, $value)
    {
        if ('' === $value && 'path' !== $property) {
            $value = null;
        }

        $value = $this->$property->withContent($value);
        if ($this->$property === $value) {
            return $this;
        }
        $newInstance = clone $this;
        $newInstance->$property = $value;
        $newInstance->assertValidObject();

        return $newInstance;
    }

    /**
     * Convert an empty string into a null value
     *
     * @param string $value
     *
     * @return string|null
     */
    protected function filterPropertyValue($value)
    {
        if (null === $value) {
            throw new InvalidArgumentException(sprintf(
                'Expected data to be a string; received "%s"',
                (is_object($value) ? get_class($value) : gettype($value))
            ));
        }

        if ('' === $value) {
            return null;
        }

        return $value;
    }

    /**
     * Assert the object is valid
     *
     * @throws InvalidArgumentException if an object component is considered invalid
     * @throws RuntimeException         if the resulting object is invalid
     */
    abstract protected function assertValidObject();

    /**
     * @inheritdoc
     */
    public function __set($property, $value)
    {
        throw new InvalidArgumentException(sprintf('%s is an undefined property', $property));
    }

    /**
     * @inheritdoc
     */
    public function __unset($property)
    {
        throw new InvalidArgumentException(sprintf('%s is an undefined property', $property));
    }

    /**
     * Magic read-only for protected properties
     *
     * @param string $property The property to read from
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }
}
