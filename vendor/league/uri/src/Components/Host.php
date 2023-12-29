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
use League\Uri\Interfaces\Host as HostInterface;

/**
 * Value object representing a URI host component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   1.0.0
 */
class Host extends AbstractHierarchicalComponent implements HostInterface
{
    use HostIpTrait;

    use HostnameInfoTrait;

    use HostnameTrait;

    /**
     * HierarchicalComponent delimiter
     *
     * @var string
     */
    protected static $separator = '.';

    /**
     * Host literal representation
     *
     * @var string
     */
    protected $host;

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * return a new instance from an array or a traversable object
     *
     * @param \Traversable|string[] $data The segments list
     * @param int                   $type one of the constant IS_ABSOLUTE or IS_RELATIVE
     *
     * @throws InvalidArgumentException If $data is invalid
     * @throws InvalidArgumentException If $type is not a recognized constant
     *
     * @return static
     */
    public static function createFromArray($data, $type = self::IS_RELATIVE)
    {
        return self::createFromLabels($data, $type);
    }

    /**
     * return a new instance from an array or a traversable object
     *
     * @param \Traversable|string[] $data The segments list
     * @param int                   $type one of the constant IS_ABSOLUTE or IS_RELATIVE
     *
     * @throws InvalidArgumentException If $data is invalid
     * @throws InvalidArgumentException If $type is not a recognized constant
     *
     * @return static
     */
    public static function createFromLabels($data, $type = self::IS_RELATIVE)
    {
        static $type_list = [self::IS_ABSOLUTE => 1, self::IS_RELATIVE => 1];

        $data = static::validateIterator($data);
        if (!isset($type_list[$type])) {
            throw new InvalidArgumentException('Please verify the submitted constant');
        }

        if ([] === $data) {
            return new static();
        }

        if ([''] === $data) {
            return new static('');
        }

        return new static(static::format($data, $type));
    }

    /**
     * Return a formatted host string
     *
     * @param string[] $data The segments list
     * @param int      $type
     *
     * @return string
     */
    protected static function format(array $data, $type)
    {
        $hostname = implode(static::$separator, array_reverse($data));
        if (self::IS_ABSOLUTE === $type) {
            return $hostname.static::$separator;
        }

        return $hostname;
    }

    /**
     * New instance
     *
     * @param null|string $host
     */
    public function __construct($host = null)
    {
        $this->data = $this->validate($host);
        $this->host = !$this->isIp() ? $this->__toString() : $this->data[0];
    }

    /**
     * validate the submitted data
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

        $str = $this->validateString($str);
        if ('' === $str) {
            return [''];
        }

        $res = $this->validateIpHost($str);
        if (!empty($res)) {
            return $res;
        }

        return $this->validateStringHost($str);
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
        return $this->createFromLabels($data, $this->isAbsolute);
    }

    /**
     * Returns whether or not the host is an IDN
     *
     * @return bool
     */
    public function isIdn()
    {
        return $this->isIdn;
    }

    /**
     * Returns whether or not the host is an IP address
     *
     * @return bool
     */
    public function isIp()
    {
        return $this->hostAsIpv4 || $this->hostAsIpv6;
    }

    /**
     * Returns whether or not the host is an IPv4 address
     *
     * @return bool
     */
    public function isIpv4()
    {
        return $this->hostAsIpv4;
    }

    /**
     * Returns whether or not the host is an IPv6 address
     *
     * @return bool
     */
    public function isIpv6()
    {
        return $this->hostAsIpv6;
    }

    /**
     * Returns whether or not the host has a ZoneIdentifier
     *
     * @return bool
     *
     * @see http://tools.ietf.org/html/rfc6874#section-4
     */
    public function hasZoneIdentifier()
    {
        return $this->hasZoneIdentifier;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Returns the instance literal representation
     * without encoding
     *
     * @return string
     */
    public function getLiteral()
    {
        return $this->host;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Returns an array representation of the host
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getLabels();
    }

    /**
     * Returns an array representation of the Host
     *
     * @return array
     */
    public function getLabels()
    {
        return $this->convertToAscii($this->data, !$this->isIdn);
    }

    /**
     * Retrieves a single host label.
     *
     * Retrieves a single host label. If the label offset has not been set,
     * returns the default value provided.
     *
     * @param string $offset  the label offset
     * @param mixed  $default Default value to return if the offset does not exist.
     *
     * @return mixed
     */
    public function getLabel($offset, $default = null)
    {
        if (isset($this->data[$offset])) {
            if ($this->isIdn) {
                return rawurldecode($this->data[$offset]);
            }

            if (PHP_VERSION_ID >= 70200) {
                return @idn_to_ascii($this->data[$offset]);
            }

            return idn_to_ascii($this->data[$offset]);
        }

        return $default;
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        if ([] === $this->data) {
            return null;
        }

        if ($this->isIp()) {
            return $this->formatIp($this->data[0]);
        }

        return $this->format($this->getLabels(), $this->isAbsolute);
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['host' => $this->getContent()];
    }

    /**
     * @inheritdoc
     */
    public static function __set_state(array $properties)
    {
        $host = static::createFromLabels($properties['data'], $properties['isAbsolute']);
        $host->hostnameInfoLoaded = $properties['hostnameInfoLoaded'];
        $host->hostnameInfo = $properties['hostnameInfo'];

        return $host;
    }

    /**
     * Returns a host in his punycode encoded form
     *
     * This method MUST retain the state of the current instance, and return
     * an instance with the host transcoded using to ascii the RFC 3492 rules
     *
     * @see http://tools.ietf.org/html/rfc3492
     *
     * @return static
     */
    public function toAscii()
    {
        if ($this->isIp() || !$this->isIdn) {
            return $this;
        }

        return $this->withContent($this->format(
            $this->convertToAscii($this->data, $this->isIdn),
            $this->isAbsolute
        ));
    }

    /**
     * Returns a host in his IDN form
     *
     * This method MUST retain the state of the current instance, and return
     * an instance with the host in its IDN form using RFC 3492 rules
     *
     * @see http://tools.ietf.org/html/rfc3492
     *
     * @return static
     */
    public function toUnicode()
    {
        if ($this->isIp() || $this->isIdn) {
            return $this;
        }

        return $this->withContent($this->format($this->data, $this->isAbsolute));
    }

    /**
     * Return an host without its zone identifier according to RFC6874
     *
     * This method MUST retain the state of the current instance, and return
     * an instance without the host zone identifier according to RFC6874
     *
     * @see http://tools.ietf.org/html/rfc6874#section-4
     *
     * @return static
     */
    public function withoutZoneIdentifier()
    {
        if ($this->hasZoneIdentifier) {
            return $this->withContent(substr($this->data[0], 0, strpos($this->data[0], '%')));
        }

        return $this;
    }

    /**
     * Validated the Host Label Count
     *
     * @param array $labels Host labels
     *
     * @throws InvalidArgumentException If the validation fails
     */
    protected function assertLabelsCount(array $labels)
    {
        if (127 <= count(array_merge($this->data, $labels))) {
            throw new InvalidArgumentException('Invalid Hostname, verify labels count');
        }
    }

    /**
     * set the FQDN property
     *
     * @param string $str
     *
     * @return string
     */
    protected function setIsAbsolute($str)
    {
        $this->isAbsolute = self::IS_RELATIVE;
        if ('.' === mb_substr($str, -1, 1, 'UTF-8')) {
            $this->isAbsolute = self::IS_ABSOLUTE;
            $str = mb_substr($str, 0, -1, 'UTF-8');
        }

        return $str;
    }

    /**
     * @inheritdoc
     */
    public function prepend($component)
    {
        return $this->createFromLabels(
            $this->validateComponent($component),
            $this->isAbsolute
        )->append($this->__toString());
    }

    /**
     * @inheritdoc
     */
    public function append($component)
    {
        return $this->createFromLabels(array_merge(
            iterator_to_array($this->validateComponent($component)),
            $this->getLabels()
        ), $this->isAbsolute);
    }
}
