<?php

namespace SuiteCRM\Api\V8\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UtilityLib;

class UtilityController extends Api
{
    //This is the millisecond time that the token is valid for
    //TODO decide appropriate timeout value
    const JWT_VALID_TIME = 86400;

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function getServerInfo(Request $req, Response $res, array $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();

        return $this->generateResponse($res, 200, $server_info, 'Success');
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $args
     * @return Response
     */
    public function login(Request $req, Response $res, array $args)
    {
        global $sugar_config;

        $data = $req->getParsedBody();

        $lib = new UtilityLib();
        $login = $lib->login($data);

        if ($login['loginApproved']) {
            $token = [
                'userId' => $login['userId'],
                'exp' => time() + self::JWT_VALID_TIME,
            ];

            //Create the token
            $jwt = \Firebase\JWT\JWT::encode($token, $sugar_config['unique_key']);
            setcookie('SUITECRM_REST_API_TOKEN', json_encode($jwt), null, null, null, isSSL(), true);

            return $this->generateResponse($res, 200, $jwt, 'Success');
        } else {
            return $this->generateResponse($res, 401, null, 'Unauthorised');
        }
    }
}
