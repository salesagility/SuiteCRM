<?php
namespace Api\V8\Middleware;

use Api\V8\JsonApi\Response\ErrorResponse;
use Api\V8\Param\BaseParam;
use Slim\Http\Request;
use Slim\Http\Response;

class ParamsMiddleware
{
    /**
     * @var BaseParam
     */
    private $params;

    /**
     * @param BaseParam $params
     */
    public function __construct(BaseParam $params)
    {
        $this->params = $params;
    }

    /**
     * @param Request $request
     * @param Response $httpResponse
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $httpResponse, callable $next)
    {
        try {
            $parameters = $this->getParameters($request);
            $this->params->configure($parameters);
            $request = $request->withAttribute('params', $this->params);
        } catch (\Exception $exception) {
            $response = new ErrorResponse();
            $response->setStatus(400);
            $response->setDetail($exception->getMessage());

            return $httpResponse->withJson($response);
        }

        return $next($request, $httpResponse);
    }

    private function getParameters(Request $request)
    {
        $routeParams = array_map(
            function ($value) {
                return is_bool($value) ? $value : urldecode($value);
            },
            $request->getAttribute('route')->getArguments()
        );

        $queryParams = $request->getQueryParams();
        $parsedBody = $request->getParsedBody();
        $parameters = array_merge(
            $routeParams,
            isset($queryParams) ? $queryParams : [],
            isset($parsedBody) ? $parsedBody : []
        );

        return $parameters;
    }
}
