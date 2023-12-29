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
use League\Uri\Interfaces\Path as PathInterface;

/**
 * Value object representing a URI path component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
trait PathTrait
{
    /**
     * Typecode Regular expression
     */
    protected static $typeRegex = ',^(?P<basename>.*);type=(?P<typecode>a|i|d)$,';

    /**
     * Typecode value
     *
     * @var array
     */
    protected static $typecodeList = [
        'a' => PathInterface::FTP_TYPE_ASCII,
        'i' => PathInterface::FTP_TYPE_BINARY,
        'd' => PathInterface::FTP_TYPE_DIRECTORY,
        '' => PathInterface::FTP_TYPE_EMPTY,
    ];

    /**
     * Dot Segment pattern
     *
     * @var array
     */
    protected static $dotSegments = ['.' => 1, '..' => 1];

    /**
     * Filter the encoded path string
     *
     * @param string $str the encoded path
     *
     * @throws InvalidArgumentException If the encoded path is invalid
     *
     * @return string
     */
    protected function filterEncodedPath($str)
    {
        if (!preg_match(',[?#],', $str)) {
            return $str;
        }

        throw new InvalidArgumentException(sprintf(
            'The encoded path `%s` contains invalid characters',
            $str
        ));
    }

    /**
     * Returns the instance string representation; If the
     * instance is not defined an empty string is returned
     *
     * @return string
     */
    abstract public function __toString();

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
    abstract public function withContent($value = null);

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
    abstract public function modify($value);

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['path' => $this->getContent()];
    }

    /**
     * The component raw data
     *
     * @return mixed
     */
    abstract public function getContent();

    /**
     * Returns an instance without dot segments
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component normalized by removing
     * the dot segment.
     *
     * @return static
     */
    public function withoutDotSegments()
    {
        $current = $this->__toString();
        if (false === strpos($current, '.')) {
            return $this;
        }

        $input = explode('/', $current);
        $new = implode('/', array_reduce($input, [$this, 'filterDotSegments'], []));
        if (isset(static::$dotSegments[end($input)])) {
            $new .= '/';
        }

        return $this->withContent($new);
    }

    /**
     * Filter Dot segment according to RFC3986
     *
     * @see http://tools.ietf.org/html/rfc3986#section-5.2.4
     *
     * @param array  $carry   Path segments
     * @param string $segment a path segment
     *
     * @return array
     */
    protected function filterDotSegments(array $carry, $segment)
    {
        if ('..' === $segment) {
            array_pop($carry);

            return $carry;
        }

        if (!isset(static::$dotSegments[$segment])) {
            $carry[] = $segment;
        }

        return $carry;
    }

    /**
     * Returns an instance without duplicate delimiters
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component normalized by removing
     * multiple consecutive empty segment
     *
     * @return static
     */
    public function withoutEmptySegments()
    {
        return $this->withContent(preg_replace(',/+,', '/', $this->__toString()));
    }

    /**
     * Returns whether or not the path has a trailing delimiter
     *
     * @return bool
     */
    public function hasTrailingSlash()
    {
        $path = $this->__toString();

        return '' !== $path && '/' === mb_substr($path, -1, 1, 'UTF-8');
    }

    /**
     * Returns an instance with a trailing slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component with a trailing slash
     *
     *
     * @return static
     */
    public function withTrailingSlash()
    {
        return $this->hasTrailingSlash() ? $this : $this->withContent($this->__toString().'/');
    }

    /**
     * Returns an instance without a trailing slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component without a trailing slash
     *
     * @return static
     */
    public function withoutTrailingSlash()
    {
        return !$this->hasTrailingSlash() ? $this : $this->withContent(mb_substr($this, 0, -1, 'UTF-8'));
    }

    /**
     * Returns whether or not the path is absolute or relative
     *
     * @return bool
     */
    public function isAbsolute()
    {
        $path = $this->__toString();

        return '' !== $path && '/' === mb_substr($path, 0, 1, 'UTF-8');
    }

    /**
     * Returns an instance with a leading slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component with a leading slash
     *
     *
     * @return static
     */
    public function withLeadingSlash()
    {
        return $this->isAbsolute() ? $this : $this->withContent('/'.$this->__toString());
    }

    /**
     * Returns an instance without a leading slash
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the path component without a leading slash
     *
     * @return static
     */
    public function withoutLeadingSlash()
    {
        return !$this->isAbsolute() ? $this : $this->withContent(mb_substr($this, 1, null, 'UTF-8'));
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Retrieve the optional type associated to the path.
     *
     * The value returned MUST be one of the interface constant type
     * If no type is associated the return constant must be self::FTP_TYPE_EMPTY
     *
     * @see http://tools.ietf.org/html/rfc1738#section-3.2.2
     *
     * @return int a typecode constant.
     */
    public function getTypecode()
    {
        if (preg_match(self::$typeRegex, $this->__toString(), $matches)) {
            return self::$typecodeList[$matches['typecode']];
        }

        return PathInterface::FTP_TYPE_EMPTY;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Return an instance with the specified typecode.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified type appended to the path.
     * if not
     *
     * Using self::FTP_TYPE_EMPTY is equivalent to removing the typecode.
     *
     * @param int $type one typecode constant.
     *
     * @throws InvalidArgumentException for invalid typecode.
     *
     * @return static
     *
     */
    public function withTypecode($type)
    {
        if (!in_array($type, self::$typecodeList)) {
            throw new InvalidArgumentException('invalid typecode');
        }

        $path = $this->__toString();
        if (preg_match(self::$typeRegex, $path, $matches)) {
            $path = $matches['basename'];
        }

        $extension = array_search($type, self::$typecodeList);
        $extension = trim($extension);
        if ('' !== $extension) {
            $extension = ';type='.$extension;
        }

        return $this->withContent($path.$extension);
    }
}
