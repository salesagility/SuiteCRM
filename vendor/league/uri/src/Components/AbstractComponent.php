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

use League\Uri\Types\ImmutableComponentTrait;

/**
 * An abstract class to ease component manipulation
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
abstract class AbstractComponent
{
    use ImmutableComponentTrait;

    /**
     * The component data
     *
     * @var int|string
     */
    protected $data;

    /**
     * @inheritdoc
     */
    public static function __set_state(array $properties)
    {
        return new static($properties['data']);
    }

    /**
     * new instance
     *
     * @param string|null $data the component value
     */
    public function __construct($data = null)
    {
        $this->data = $this->validate($data);
    }

    /**
     * Validate the component string
     *
     * @param mixed $data
     *
     * @throws InvalidArgumentException if the component is no valid
     *
     * @return mixed
     */
    protected function validate($data)
    {
        if (null === $data) {
            return $data;
        }

        return $this->decodeComponent($this->validateString($data));
    }


    /**
     * The component raw data
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->data;
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
        return $this->__toString();
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
}
