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
use League\Uri\Interfaces\Uri;
use Psr\Http\Message\UriInterface;
use RuntimeException;

/**
 * A class to ease applying multiple modification
 * on a URI object based on the pipeline pattern
 * This class is based on league.pipeline
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class Pipeline extends AbstractUriModifier
{
    /**
     * @var callable[]
     */
    protected $modifiers;

    /**
     * New instance
     *
     * @param callable[] $modifiers
     *
     * @throws InvalidArgumentException
     */
    public function __construct($modifiers = [])
    {
        foreach ($modifiers as $modifier) {
            if (false === is_callable($modifier)) {
                throw new InvalidArgumentException('All submitted modifiers should be callable');
            }
        }
        $this->modifiers = $modifiers;
    }

    /**
     * Create a new pipeline with an appended modifier.
     *
     * @param callable $modifier
     *
     * @return static
     */
    public function pipe(callable $modifier)
    {
        $clone = clone $this;
        $clone->modifiers[] = $modifier;

        return $clone;
    }

    /**
     * Iteratively apply the modifiers to a URI object
     *
     * @param Uri|UriInterface $uri
     *
     * @return Uri|UriInterface
     *
     * @see Pipeline::__invoke
     */
    public function process($uri)
    {
        return $this->__invoke($uri);
    }

    /**
     * Iteratively apply the modifiers to a URI object
     *
     * @param Uri|UriInterface $uri
     *
     * @throws RuntimeException If the resulting URI is not an URI Object
     *
     * @return Uri|UriInterface
     */
    public function __invoke($uri)
    {
        $this->assertUriObject($uri);
        $submittedUriClass = get_class($uri);
        foreach ($this->modifiers as $modifier) {
            $uri = call_user_func($modifier, $uri);
            if (!is_object($uri) || $submittedUriClass !== get_class($uri)) {
                throw new RuntimeException(
                    'The returned value is not of the same class as the submitted URI object'
                );
            }
        }

        return $uri;
    }
}
