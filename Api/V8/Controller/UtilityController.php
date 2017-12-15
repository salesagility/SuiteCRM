<?php
namespace Api\V8\Controller;

use Api\V8\AbstractApiController;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class UtilityController extends AbstractApiController
{
    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * @param AuthorizationServer $authorizationServer
     */
    public function __construct(AuthorizationServer $authorizationServer)
    {
        $this->authorizationServer = $authorizationServer;
    }

    /**
     * @param Request $req
     * @param Response $res
     * @return ResponseInterface
     */
    public function access_token(Request $req, Response $res)
    {
        try {
            return $this->authorizationServer->respondToAccessTokenRequest($req, $res);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($res);
        } catch (\Exception $e) {
            return $this->handleError($res, $e);
        }
    }

    /**
     * @param Request $req
     * @param Response $res
     * @return Response
     */
    public function getServerInfo(Request $req, Response $res)
    {
        require_once 'suitecrm_version.php';

        return $this->generateResponse($res, 200, $GLOBALS['suitecrm_version'], 'Success');
    }
}
