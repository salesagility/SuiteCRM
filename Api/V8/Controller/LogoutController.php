<?php
namespace Api\V8\Controller;

use Api\V8\Service\LogoutService;
use League\OAuth2\Server\ResourceServer;
use Slim\Http\Request;
use Slim\Http\Response;

class LogoutController extends BaseController
{
    const LOGOUT = self::class . ':logout';

    /**
     * @var LogoutService
     */
    private $logoutService;

    /**
     * @var ResourceServer
     */
    private $resourceServer;

    /**
     * @param LogoutService $logoutService
     * @param ResourceServer $resourceServer
     */
    public function __construct(LogoutService $logoutService, ResourceServer $resourceServer)
    {
        $this->logoutService = $logoutService;
        $this->resourceServer = $resourceServer;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     */
    public function logout(Request $request, Response $response, array $args)
    {
        try {
            $accessToken = $this->resourceServer
                ->validateAuthenticatedRequest($request)
                ->getAttribute('oauth_access_token_id');

            $logoutResponse = $this->logoutService->logout($accessToken);

            return $this->generateResponse($response, $logoutResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }
}
