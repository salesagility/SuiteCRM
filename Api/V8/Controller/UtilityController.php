<?php

namespace SuiteCRM\Api\V8\Controller;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UtilityLib;

class UtilityController extends Api
{
    //This is the millisecond time that the token is valid for
    //TODO decide appropriate timeout value
    public $jwtValidTime = 86400;

    public function getServerInfo(Request $req, Response $res, $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();

        return $this->generateResponse($res, 200, $server_info, 'Success');
    }

    public function login(Request $req, Response $res, $args)
    {
        global $sugar_config;
        $jwtExpiry = $this->jwtValidTime;

        $data = $req->getParsedBody();

        $lib = new UtilityLib();
        $login = $lib->login($data);

        if ($login['loginApproved']) {
            $token = array(
                'userId' => $login['userId'],
                'exp' => time() + $jwtExpiry,
            );

            //Create the token
            $jwt = \Firebase\JWT\JWT::encode($token, $sugar_config['unique_key']);
            setcookie('SUITECRM_REST_API_TOKEN', json_encode($jwt));

            return $this->generateResponse($res, 200, $jwt, 'Success');
        } else {
            return $this->generateResponse($res, 401, null, 'Unauthorised');
        }
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
