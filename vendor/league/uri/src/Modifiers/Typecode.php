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
use League\Uri\Components\Path;

/**
 * Path component typecode modifier
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class Typecode extends AbstractPathModifier
{
    /**
     * The typecode selected
     *
     * @var int
     */
    protected $type;

    /**
     * Typecode list
     *
     * @var array
     */
    protected static $typecodeList = [
        Path::FTP_TYPE_ASCII => 1,
        Path::FTP_TYPE_BINARY => 1,
        Path::FTP_TYPE_DIRECTORY => 1,
        Path::FTP_TYPE_EMPTY => 1,
    ];

    /**
     * New instance
     *
     * @param int $type
     */
    public function __construct($type)
    {
        $this->type = $this->filterType($type);
    }

    /**
     * filter and validate the extension to use
     *
     * @param int $type
     *
     * @return int
     */
    protected function filterType($type)
    {
        if (!isset(static::$typecodeList[$type])) {
            throw new InvalidArgumentException('invalid code type');
        }

        return $type;
    }

    /**
     * Return a new instance with a different extension to use
     *
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.1
     *
     * @param int $type
     *
     * @return static
     */
    public function withType($type)
    {
        $clone = clone $this;
        $clone->type = $this->filterType($type);

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
        return (string) (new Path($str))->withTypecode($this->type);
    }
}
