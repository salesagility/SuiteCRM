<?php
namespace SuiteCRM\Api\V8\Controller;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UtilityLib;

class UtilityController extends Api{

    function getServerInfo(Request $req, Response $res, $args)
    {
        global $container;

        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();
        return $this->generateResponse($res,200,$server_info,'Success');
    }

    function login(Request $req, Response $res, $args)
    {
        $jwtExpiry = (60 * 60 * 24);
        $lib = new UtilityLib();
        $login = $lib->login();

        if($login["loginApproved"])
        {
            $token = array(
                "userId"=>$login["userId"],
                "exp" => time() + $jwtExpiry
            );

            //Create the token
            $jwt = \Firebase\JWT\JWT::encode($token,"supersecretkeyyoushouldnotcommittogithub");
            setcookie("SUITECRM_REST_API_TOKEN",json_encode($jwt));
            return $this->generateResponse($res,200,json_encode($jwt),'Success');
        }

        else
            return $this->generateResponse($res,401,NULL,'Unauthorised');
    }

}