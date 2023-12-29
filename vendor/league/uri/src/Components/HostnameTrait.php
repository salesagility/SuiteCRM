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

/**
 * A Trait to validate a Hostname
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
trait HostnameTrait
{
    /**
     * Tells whether we have a IDN or not
     *
     * @var bool
     */
    protected $isIdn = false;

    /**
     * Format an label collection for string representation of the Host
     *
     * @param array $labels  host labels
     * @param bool  $convert should we transcode the labels into their ascii equivalent
     *
     * @return array
     */
    protected function convertToAscii(array $labels, $convert)
    {
        if (!$convert) {
            return $labels;
        }

        foreach ($labels as &$label) {
            if ('' !== $label) {
                $label = PHP_VERSION_ID >= 70200 ? @idn_to_ascii($label) : idn_to_ascii($label);
            }
        }
        unset($label);

        return $labels;
    }

    /**
     * Validate a string only host
     *
     * @param string $str
     *
     * @return array
     */
    protected function validateStringHost($str)
    {
        $host = $this->lower($this->setIsAbsolute($str));
        $raw_labels = explode('.', $host);
        $labels = array_map(function ($value) {
            return PHP_VERSION_ID >= 70200 ? @idn_to_ascii($value) : idn_to_ascii($value);
        }, $raw_labels);

        $this->assertValidHost($labels);
        $this->isIdn = $raw_labels !== $labels;

        return array_reverse(array_map(function ($label) {
            return PHP_VERSION_ID >= 70200 ? @idn_to_utf8($label) : idn_to_utf8($label);
        }, $labels));
    }

    /**
     * set the FQDN property
     *
     * @param string $str
     *
     * @return string
     */
    abstract protected function setIsAbsolute($str);

    /**
     * Convert to lowercase a string without modifying unicode characters
     *
     * @param string $str
     *
     * @return string
     */
    protected function lower($str)
    {
        return preg_replace_callback('/[A-Z]+/', function ($matches) {
            return strtolower($matches[0]);
        }, $str);
    }

    /**
     * Validate a String Label
     *
     * @param array $labels found host labels
     *
     * @throws InvalidArgumentException If the validation fails
     */
    protected function assertValidHost(array $labels)
    {
        $verifs = array_filter($labels, function ($value) {
            return '' !== trim($value);
        });

        if ($verifs !== $labels) {
            throw new InvalidArgumentException('Invalid Hostname, empty labels are not allowed');
        }

        $this->assertLabelsCount($labels);
        $this->isValidContent($labels);
    }

    /**
     * Validated the Host Label Count
     *
     * @param array $labels host labels
     *
     * @throws InvalidArgumentException If the validation fails
     */
    abstract protected function assertLabelsCount(array $labels);

    /**
     * Validated the Host Label Pattern
     *
     * @param array $data host labels
     *
     * @throws InvalidArgumentException If the validation fails
     */
    protected function isValidContent(array $data)
    {
        if (count(preg_grep('/^[0-9a-z]([0-9a-z-]{0,61}[0-9a-z])?$/i', $data, PREG_GREP_INVERT))) {
            throw new InvalidArgumentException('Invalid Hostname, some labels contain invalid characters');
        }
    }
}
