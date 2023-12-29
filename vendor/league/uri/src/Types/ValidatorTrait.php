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
namespace League\Uri\Types;

use InvalidArgumentException;
use League\Uri\Interfaces\Port;
use League\Uri\Interfaces\Uri;
use Psr\Http\Message\UriInterface;

/**
 * Uri Parameter validation
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
trait ValidatorTrait
{
    /**
     * Assert the submitted object is a UriInterface object
     *
     * @param Uri|UriInterface $uri
     *
     * @throws InvalidArgumentException if the object does not implemet PSR-7 UriInterface
     */
    protected function assertUriObject($uri)
    {
        if (!$uri instanceof Uri && !$uri instanceof UriInterface) {
            throw new InvalidArgumentException(sprintf(
                'URI passed must implement PSR-7 or League\Uri Uri interface; received "%s"',
                (is_object($uri) ? get_class($uri) : gettype($uri))
            ));
        }
    }

    /**
     * validate a string
     *
     * @param mixed $str the value to evaluate as a string
     *
     * @throws InvalidArgumentException if the submitted data can not be converted to string
     *
     * @return string
     */
    protected static function validateString($str)
    {
        if (is_string($str)) {
            return $str;
        }

        throw new InvalidArgumentException(sprintf(
            'Expected data to be a string; received "%s"',
            (is_object($str) ? get_class($str) : gettype($str))
        ));
    }

    /**
     * Validate a Port number
     *
     * @param mixed $port the port number
     *
     * @throws InvalidArgumentException If the port number is invalid
     *
     * @return null|int
     */
    protected function validatePort($port)
    {
        if (is_bool($port)) {
            throw new InvalidArgumentException('The submitted port is invalid');
        }

        if (in_array($port, [null, ''])) {
            return null;
        }
        $res = filter_var($port, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => Port::MINIMUM,
            'max_range' => Port::MAXIMUM,
        ]]);
        if (false === $res) {
            throw new InvalidArgumentException('The submitted port is invalid');
        }

        return $res;
    }
}
