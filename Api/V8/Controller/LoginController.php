<?php
namespace Api\V8\Controller;

use Api\V8\Params\LoginParams;
use Api\V8\Repository\ConfigRepository;
use Firebase\JWT\JWT;
use Slim\Http\Cookies;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginController extends AbstractApiController
{
    /**
     * @var \AuthenticationController
     */
    private $authentication;

    /**
     * @var JWT
     */
    private $jwt;

    /**
     * @var Cookies
     */
    private $cookies;

    /**
     * @var \User
     */
    private $currentUser;

    /**
     * @var array
     */
    private $suiteConfig;

    /**
     * @param \AuthenticationController $authentication
     * @param JWT $jwt
     * @param Cookies $cookies
     * @param \User $currentUser
     * @param array $suiteConfig
     */
    public function __construct(
        \AuthenticationController $authentication,
        JWT $jwt,
        Cookies $cookies,
        \User $currentUser,
        array $suiteConfig
    ) {
        $this->authentication = $authentication;
        $this->jwt = $jwt;
        $this->cookies = $cookies;
        $this->currentUser = $currentUser;
        $this->suiteConfig = $suiteConfig;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param LoginParams $params
     *
     * @return Response
     */
    public function login(Request $request, Response $response, array $args, LoginParams $params)
    {
        $this->authentication->login(
            $params->getUsername(),
            $params->getPassword()
        );

        if ($this->authentication->sessionAuthenticate()) {
            $jwt = $this->jwt;
            $jwt = $jwt::encode(
                [
                    'userId' => $this->currentUser->id,
                    'exp' => time() + ConfigRepository::TIMEOUT,
                ],
                $this->suiteConfig['unique_key'],
                ConfigRepository::ALGORITHM
            );

            $this->cookies->set(ConfigRepository::TOKEN_COOKIE, [
                'value' => $jwt,
                'path' => '/',
                'httponly' => true,
                'secure' => isSSL()
            ]);

            $response = $response
                ->withHeader('Set-Cookie', $this->cookies->toHeaders())
                ->withHeader('Cache-Control', 'no-cache')
                ->withHeader('Pragma', 'no-cache');

            return $this->generateResponse($response, 200);
        }

        return $this->generateResponse($response, 401);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function logout(Request $request, Response $response)
    {
        $this->cookies->set(ConfigRepository::TOKEN_COOKIE, [
            'value' => 'deleted',
            'path' => '/',
            'expires' => 100,
            'httponly' => true,
            'secure' => isSSL()
        ]);
        $response = $response->withHeader('Set-Cookie', $this->cookies->toHeaders());

        return $this->generateResponse($response, 200);
    }
}
