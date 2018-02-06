<?php
namespace Api\V8\Middleware;

use Api\V8\Params\AbstractParams;
use Slim\Http\Request;
use Slim\Http\Response;

class ParamObjectConverter
{
    /**
     * @var AbstractParams
     */
    private $params;

    /**
     * @param AbstractParams $params
     */
    public function __construct(AbstractParams $params)
    {
        $this->params = $params;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $routeArgs = array_map(
            function ($value) {
                return is_bool($value) ? $value : urldecode($value);
            },
            $request->getAttribute('route')->getArguments()
        );

        $queryParams = $request->getQueryParams();
        $parsedBody = $request->getParsedBody();
        $arguments = array_merge(
            $routeArgs,
            isset($queryParams) ? $queryParams : [],
            isset($parsedBody) ? $parsedBody : []
        );

        if (!$arguments) {
            return $response->withJson(
                ['message' => 'unable to create params object data'],
                400
            );
        }

        try {
            $this->params->configure($arguments);
        } catch (\Exception $e) {
            return $response->withJson(['message' => $e->getMessage()], 400);
        }
        $request = $request->withAttribute('params', $this->params);

        return $next($request, $response);
    }
}
