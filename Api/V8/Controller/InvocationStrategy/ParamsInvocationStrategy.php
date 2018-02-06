<?php
namespace Api\V8\Controller\InvocationStrategy;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

class ParamsInvocationStrategy implements InvocationStrategyInterface
{
    /**
     * @param callable $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $routeArguments
     *
     * @return ResponseInterface|string
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ) {
        foreach ($routeArguments as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }

        $controllerArgs = [$request, $response, $routeArguments];

        if ($request->getAttribute('params')) {
            $controllerArgs[] = $request->getAttribute('params');
        }

        return $callable(...$controllerArgs);
    }
}
