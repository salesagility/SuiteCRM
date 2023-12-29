<?php

declare(strict_types=1);

namespace League\Container;

use League\Container\Argument\{ArgumentResolverInterface, ArgumentResolverTrait};
use League\Container\Exception\ContainerException;
use League\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;

class ReflectionContainer implements ArgumentResolverInterface, ContainerInterface
{
    use ArgumentResolverTrait;
    use ContainerAwareTrait;

    /**
     * @var boolean
     */
    protected $cacheResolutions;

    /**
     * @var array
     */
    protected $cache = [];

    public function __construct(bool $cacheResolutions = false)
    {
        $this->cacheResolutions = $cacheResolutions;
    }

    public function get($id, array $args = [])
    {
        if ($this->cacheResolutions === true && array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf('Alias (%s) is not an existing class and therefore cannot be resolved', $id)
            );
        }

        $reflector = new ReflectionClass($id);
        $construct = $reflector->getConstructor();

        if ($construct && !$construct->isPublic()) {
            throw new NotFoundException(
                sprintf('Alias (%s) has a non-public constructor and therefore cannot be instantiated', $id)
            );
        }

        $resolution = $construct === null
            ? new $id()
            : $reflector->newInstanceArgs($this->reflectArguments($construct, $args))
        ;

        if ($this->cacheResolutions === true) {
            $this->cache[$id] = $resolution;
        }

        return $resolution;
    }

    public function has($id): bool
    {
        return class_exists($id);
    }

    public function call(callable $callable, array $args = [])
    {
        if (is_string($callable) && strpos($callable, '::') !== false) {
            $callable = explode('::', $callable);
        }

        if (is_array($callable)) {
            if (is_string($callable[0])) {
                // if we have a definition container, try that first, otherwise, reflect
                try {
                    $callable[0] = $this->getContainer()->get($callable[0]);
                } catch (ContainerException $e) {
                    $callable[0] = $this->get($callable[0]);
                }
            }

            $reflection = new ReflectionMethod($callable[0], $callable[1]);

            if ($reflection->isStatic()) {
                $callable[0] = null;
            }

            return $reflection->invokeArgs($callable[0], $this->reflectArguments($reflection, $args));
        }

        if (is_object($callable)) {
            $reflection = new ReflectionMethod($callable, '__invoke');
            return $reflection->invokeArgs($callable, $this->reflectArguments($reflection, $args));
        }

        $reflection = new ReflectionFunction(\Closure::fromCallable($callable));

        return $reflection->invokeArgs($this->reflectArguments($reflection, $args));
    }
}
