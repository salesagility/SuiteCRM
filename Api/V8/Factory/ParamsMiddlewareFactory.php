<?php
namespace Api\V8\Factory;

use Api\V8\Middleware\ParamsMiddleware;
use Interop\Container\ContainerInterface as Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ParamsMiddlewareFactory
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $containerId
     *
     * @return callable
     */
    public function bind($containerId)
    {
        $container = $this->container;

        return function (Request $request, Response $response, callable $next) use ($containerId, $container) {
            $paramMiddleware = new ParamsMiddleware($container->get($containerId));

            return $paramMiddleware($request, $response, $next);
        };
    }
}
