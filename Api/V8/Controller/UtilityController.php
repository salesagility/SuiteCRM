<?php
namespace SuiteCRM\Api\V8\Controller;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\Core\Api;
use SuiteCRM\Api\V8\Library\UtilityLib;

class UtilityController extends Api{

    function getServerInfo(Request $req, Response $res, $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();
        return $this->generateResponse($res,200,$server_info,'Success');
    }


}