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

use League\Uri\Interfaces\Fragment as FragmentInterface;

/**
 * Value object representing a URI fragment component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   1.0.0
 */
class Fragment extends AbstractComponent implements FragmentInterface
{
    /**
     * Returns the component literal value
     *
     * @return string|null
     */
    public function getContent()
    {
        if (null === $this->data) {
            return null;
        }

        $regexp = '/(?:[^'.self::$unreservedChars.self::$subdelimChars.'\:\/@\?]+
            |%(?!'.self::$encodedChars.'))/x';

        return $this->encode($this->data, $regexp);
    }

    /**
     * Return the decoded string representation of the component
     *
     * @return null|string
     */
    public function getDecoded()
    {
        if (null === $this->data) {
            return null;
        }

        return $this->data;
    }

    /**
     * Returns the instance string representation
     * with its optional URI delimiters
     *
     * @return string
     */
    public function getUriComponent()
    {
        $component = $this->__toString();
        if (null !== $this->data) {
            return FragmentInterface::DELIMITER.$component;
        }

        return $component;
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['fragment' => $this->getContent()];
    }
}
