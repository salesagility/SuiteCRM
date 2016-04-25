<?php

namespace SuiteCRM\Api\V8\Controller;

use AuthenticationController;
use Firebase\JWT\JWT;
use Slim\Http\Request as Request;
use Slim\Http\Cookies as Cookies;
use Slim\Http\Response as Response;
use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UtilityLib;
use User;

class UtilityController extends Api
{
    //This is the millisecond time that the token is valid for
    //TODO decide appropriate timeout value
    public $jwtValidTime = 86400;

    /**
     * @var array
     */
    protected $sugarConfig;

    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * @var AuthenticationController
     */
    protected $authentication;

    /**
     * @var User
     */
    protected $currentUser;

    /**
     * @var JWT
     */
    protected $jwt;

    /**
     * UtilityController constructor.
     * @param array $sugarConfig
     * @param Cookies $cookies
     * @param User $current_user
     * @param AuthenticationController $authentication
     * @param JWT $jwt
     */
    public function __construct($sugarConfig, $cookies, $current_user,$authentication, $jwt)
    {
        $this->sugarConfig = $sugarConfig;
        $this->cookies = $cookies;
        $this->currentUser = $current_user;
        $this->authentication = $authentication;
        $this->jwt = $jwt;
    }

    public function getServerInfo(Request $req, Response $res, $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();

        return $this->generateResponse($res, 200, $server_info, 'Success');
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param $args
     * @return Response
     */
    public function login(Request $req, Response $res, $args)
    {
        $jwtExpiry = $this->jwtValidTime;

        $data = $req->getParsedBody();

        $this->authentication->login($data['username'], $data['password'], ['passwordEncrypted' => false]);
        if ($this->authentication->sessionAuthenticate()) {
            $token = [
                'userId' => $GLOBALS['current_user']->id,
                'exp' => time() + $jwtExpiry,
            ];

            //Create the token
            $jwt = $this->jwt->encode($token, $this->sugarConfig['unique_key']);

            //Add Cookie
            $this->cookies->set('SUITECRM_REST_API_TOKEN', [
                'value' => $jwt,
                'path' => '/',
                'httponly' => true,
                'secure' => false
            ]);
            $res = $res->withHeader('Set-Cookie', $this->cookies->toHeaders());

            return $this->generateResponse($res, 200, null, 'Success');
        } else {
            return $this->generateResponse($res, 401, null, 'Unauthorised');
        }
    }

    public function logout(Request $req, Response $res)
    {
        $this->cookies->set('SUITECRM_REST_API_TOKEN', [
            'value' => 'deleted',
            'path' => '/',
            'expires' => 100,
            'httponly' => true,
            'secure' => false
        ]);
        $res = $res->withHeader('Set-Cookie', $this->cookies->toHeaders());
        return $this->generateResponse($res, 200, null, 'Success');
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $pairs = explode('&', $_SERVER['QUERY_STRING']);
        $vars = array();
        foreach ($pairs as $pair) {
            $nv = explode('=', $pair);
            $name = urldecode($nv[0]);
            $value = urldecode($nv[1]);
            $vars[$name] = $value;
        }

        return $vars;
    }
}
