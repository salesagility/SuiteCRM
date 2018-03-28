<?php
namespace Api\V8\Factory;

use Api\V8\Middleware\ParamObjectConverter;
use Interop\Container\ContainerInterface as Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ParamObjectConverterFactory
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $serviceId
     *
     * @return \Closure
     */
    public function create($serviceId)
    {
        $container = $this->container;

        return function (Request $request, Response $response, callable $next) use ($serviceId, $container) {
            return (new ParamObjectConverter($container->get($serviceId)))($request, $response, $next);
        };
    }
}
