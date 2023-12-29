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

use Pdp\Parser;
use Pdp\PublicSuffixListManager;

/**
 * Value object representing a URI host component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
trait HostnameInfoTrait
{
    /**
     * Pdp Parser
     *
     * @var Parser
     */
    protected static $pdpParser;

    /**
     * Hostname public info
     *
     * @var array
     */
    protected $hostnameInfo = [
        'isPublicSuffixValid' => false,
        'publicSuffix' => '',
        'registerableDomain' => '',
        'subdomain' => '',
    ];

    /**
     * is the Hostname Info loaded
     *
     * @var bool
     */
    protected $hostnameInfoLoaded = false;

    /**
     * Return the host public suffix
     *
     * @return string
     */
    public function getPublicSuffix()
    {
        return $this->getHostnameInfo('publicSuffix');
    }

    /**
     * Return the host registrable domain
     *
     * @return string
     */
    public function getRegisterableDomain()
    {
        return $this->getHostnameInfo('registerableDomain');
    }

    /**
     * Return the hostname subdomain
     *
     * @return string
     */
    public function getSubdomain()
    {
        return $this->getHostnameInfo('subdomain');
    }

    /**
     * Tell whether the current public suffix is valid
     *
     * @return bool
     */
    public function isPublicSuffixValid()
    {
        return $this->getHostnameInfo('isPublicSuffixValid');
    }

    /**
     * Load the hostname info
     *
     * @param string $key hostname info key
     *
     * @return mixed
     */
    protected function getHostnameInfo($key)
    {
        $this->loadHostnameInfo();
        return $this->hostnameInfo[$key];
    }

    /**
     * parse and save the Hostname information from the Parser
     */
    protected function loadHostnameInfo()
    {
        if ($this->isIp() || $this->hostnameInfoLoaded) {
            return;
        }

        $host = $this->__toString();
        if ($this->isAbsolute()) {
            $host = mb_substr($host, 0, -1, 'UTF-8');
        }

        $this->hostnameInfo = array_merge(
            $this->hostnameInfo,
            array_map('sprintf', $this->getPdpParser()->parseHost($host)->toArray())
        );

        if ('' !== $this->hostnameInfo['publicSuffix']) {
            $this->hostnameInfo['isPublicSuffixValid'] = $this->getPdpParser()->isSuffixValid($host);
        }

        $this->hostnameInfoLoaded = true;
    }

    /**
     * Returns the instance string representation; If the
     * instance is not defined an empty string is returned
     *
     * @return string
     */
    abstract public function __toString();

    /**
     * Returns whether or not the host is an IP address
     *
     * @return bool
     */
    abstract public function isIp();

    /**
     * Returns whether or not the host is a full qualified domain name
     *
     * @return bool
     */
    abstract public function isAbsolute();

    /**
     * Initialize and access the Parser object
     *
     * @return Parser
     */
    protected function getPdpParser()
    {
        if (!static::$pdpParser instanceof Parser) {
            static::$pdpParser = new Parser((new PublicSuffixListManager())->getList());
        }

        return static::$pdpParser;
    }
}
