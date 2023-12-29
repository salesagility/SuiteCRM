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
use League\Uri\Interfaces\Port as PortInterface;

/**
 * Value object representing a URI port component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   1.0.0
 */
class Port extends AbstractComponent implements PortInterface
{
    /**
     * @inheritdoc
     */
    protected function validate($data)
    {
        if ('' === $data) {
            throw new InvalidArgumentException('Expected port to be a int or null; received an empty string');
        }

        return $this->validatePort($data);
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Return an integer representation of the Port component
     *
     * @return int|null
     */
    public function toInt()
    {
        return $this->getContent();
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['port' => $this->getContent()];
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
        if ('' !== $component) {
            return PortInterface::DELIMITER.$component;
        }

        return $component;
    }
}
