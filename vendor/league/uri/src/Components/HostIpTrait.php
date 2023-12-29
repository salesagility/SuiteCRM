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

/**
 * A Trait to validate a IP type Host
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
trait HostIpTrait
{
    /**
     * Is the Host an IPv4
     *
     * @var bool
     */
    protected $hostAsIpv4 = false;

    /**
     * Is the Host an IPv6
     *
     * @var bool
     */
    protected $hostAsIpv6 = false;

    /**
     * Tell whether the IP has a zone Identifier
     *
     * @var bool
     */
    protected $hasZoneIdentifier = false;

    /**
     * IPv6 Local Link binary-like prefix
     *
     * @var string
     */
    protected static $local_link_prefix = '1111111010';

    /**
     * Validate a Host as an IP
     *
     * @param string $str
     *
     * @return array
     */
    protected function validateIpHost($str)
    {
        $res = $this->filterIpv6Host($str);
        if (is_string($res)) {
            $this->hostAsIpv4 = false;
            $this->hostAsIpv6 = true;

            return [$res];
        }

        if (filter_var($str, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->hostAsIpv4 = true;
            $this->hostAsIpv6 = false;

            return [$str];
        }

        return [];
    }

    /**
     * validate and filter a Ipv6 Hostname
     *
     * @param string $str
     *
     * @return string|false
     */
    protected function filterIpv6Host($str)
    {
        preg_match(',^(?P<ldelim>[\[]?)(?P<ipv6>.*?)(?P<rdelim>[\]]?)$,', $str, $matches);
        if (!in_array(strlen($matches['ldelim'].$matches['rdelim']), [0, 2])) {
            return false;
        }

        if (false === strpos($str, '%')) {
            return filter_var($matches['ipv6'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        }

        return $this->validateScopedIpv6($matches['ipv6']);
    }

    /**
     * Scope Ip validation according to RFC6874 rules
     *
     * @see http://tools.ietf.org/html/rfc6874#section-2
     * @see http://tools.ietf.org/html/rfc6874#section-4
     *
     * @param string $ip The ip to validate
     *
     * @return string
     */
    protected function validateScopedIpv6($ip)
    {
        $pos = strpos($ip, '%');
        if (preg_match(',[^\x20-\x7f]|[?#@\[\]],', rawurldecode(substr($ip, $pos)))) {
            return false;
        }

        $ipv6 = substr($ip, 0, $pos);
        if (!$this->isLocalLink($ipv6)) {
            return false;
        }

        $this->hasZoneIdentifier = true;

        return strtolower(rawurldecode($ip));
    }

    /**
     * Tell whether the submitted string is a local link IPv6
     *
     * @param string $ipv6
     *
     * @return bool
     */
    protected function isLocalLink($ipv6)
    {
        if (!filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return false;
        }

        $convert = function ($carry, $char) {
            return $carry.str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        };
        $res = array_reduce(str_split(unpack('A16', inet_pton($ipv6))[1]), $convert, '');

        return substr($res, 0, 10) === self::$local_link_prefix;
    }

    /**
     * Format an IP for string representation of the Host
     *
     * @param string $ip_address IP address
     *
     * @return string
     */
    protected function formatIp($ip_address)
    {
        $tmp = explode('%', $ip_address);
        if (isset($tmp[1])) {
            $ip_address = $tmp[0].'%25'.rawurlencode($tmp[1]);
        }

        if ($this->hostAsIpv6) {
            return "[$ip_address]";
        }

        return $ip_address;
    }
}
