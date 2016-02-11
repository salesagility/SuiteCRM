<?php
namespace SuiteCRM\Api\V8\Controller;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UtilityLib;

class UtilityController extends Api
{

    //This is the millisecond time that the token is valid for
    //TODO decide appropriate timeout value
    public $jwtValidTime = 86400;

    function getServerInfo(Request $req, Response $res, $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();
        return $this->generateResponse($res, 200, $server_info, 'Success');
    }

    function login(Request $req, Response $res, $args)
    {
        global $sugar_config;
        $jwtExpiry = $this->jwtValidTime;
        $lib = new UtilityLib();
        $login = $lib->login();

        if ($login["loginApproved"]) {
            $token = array(
                "userId" => $login["userId"],
                "exp" => time() + $jwtExpiry
            );

            //Create the token
            $jwt = \Firebase\JWT\JWT::encode($token, $sugar_config["JWT_SECRET"]);
            setcookie("SUITECRM_REST_API_TOKEN", json_encode($jwt));
            return $this->generateResponse($res, 200, json_encode($jwt), 'Success');
        } else {
            return $this->generateResponse($res, 401, null, 'Unauthorised');
        }
    }

}