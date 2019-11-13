<?php
namespace Api\V8\Controller;

use Api\V8\Service\LogoutService;
use League\OAuth2\Server\ResourceServer;
use Slim\Http\Request;
use Slim\Http\Response;

class LogoutController extends BaseController
{
    /**
     * @var LogoutService
     */
    protected $logoutService;

    /**
     * @var ResourceServer
     */
    protected $resourceServer;

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
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
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
