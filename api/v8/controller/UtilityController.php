<?php

namespace SuiteCRM\api\v8\controller;

use Slim\Http\Request;
use Slim\Http\Response;
use SuiteCRM\api\core\Api;
use SuiteCRM\api\v8\library\UtilityLib;

class UtilityController extends Api
{
    //default time in seconds that the token is valid for
    const JWT_EXP_TIME = 14400;

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

        $expTime = !empty($sugar_config['api']['timeout']) ? (int)$sugar_config['api']['timeout'] : self::JWT_EXP_TIME;

        if ($login['loginApproved']) {
            $token = [
                'userId' => $login['userId'],
                'exp' => time() + $expTime,
            ];

            //Create the token
            $jwt = \Firebase\JWT\JWT::encode($token, $sugar_config['unique_key']);
            setcookie('SUITECRM_REST_API_TOKEN', json_encode($jwt), null, null, null, isSSL(), true);

            $res = $res->withHeader('Cache-Control', 'no-cache')->withHeader('Pragma', 'no-cache');

            return $this->generateResponse($res, 200, $jwt, 'Success');
        }

        return $this->generateResponse($res, 401, null, 'Unauthorised');
    }

}
