<?php
namespace Api\V8\Middleware;

use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware
{
    /**
     * @var ResourceServer
     */
    private $resourceServer;

    /**
     * @param ResourceServer $resourceServer
     */
    public function __construct(ResourceServer $resourceServer)
    {
        $this->resourceServer = $resourceServer;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            // we skip the access_token
            if ($request->getUri()->getPath() !== 'V8/access_token') {
                $request = $this->resourceServer->validateAuthenticatedRequest($request);
            }
            $response = $next($request, $response);
        } catch (\InvalidArgumentException $e) {
            return $response->withStatus(422, $e->getMessage());
        }

        return $response;
    }
}
