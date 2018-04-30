<?php
namespace Api\V8\Controller\InvocationStrategy;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

class SuiteInvocationStrategy implements InvocationStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ) {
        foreach ($routeArguments as $attribute => $value) {
            $request = $request->withAttribute($attribute, $value);
        }

        $controllerArgs = [$request, $response, $routeArguments];

        if ($request->getAttribute('params')) {
            $controllerArgs[] = $request->getAttribute('params');
        }

        return $callable(...$controllerArgs);
    }
}
