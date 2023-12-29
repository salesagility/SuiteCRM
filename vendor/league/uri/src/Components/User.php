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
use League\Uri\Interfaces\User as UserInterface;

/**
 * Value object representing a URI user component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   1.0.0
 */
class User extends AbstractComponent implements UserInterface
{
    /**
     * @inheritdoc
     */
    protected function validate($str)
    {
        if (!is_string($str) || !preg_match(',[/:@?#],', $str)) {
            return parent::validate($str);
        }

        throw new InvalidArgumentException(sprintf(
            'The encoded user string `%s` contains invalid characters `/:@?#`',
            $str
        ));
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        if (null === $this->data) {
            return $this->data;
        }

        $regexp = '/(?:[^'.self::$unreservedChars.self::$subdelimChars.']+
            |%(?!'.self::$encodedChars.'))/x';

        return $this->encode((string) $this->data, $regexp);
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['user' => $this->getContent()];
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
}
