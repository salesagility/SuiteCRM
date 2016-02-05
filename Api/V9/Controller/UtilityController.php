<?php
namespace SuiteCRM\Api\V9\Controller;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\V8\Controller\UtilityController as parentController;
use SuiteCRM\Api\V9\Library\UtilityLib;


class UtilityController extends parentController{
    function getServerInfo(Request $req, Response $res, $args)
    {
        $lib = new UtilityLib();
        $server_info = $lib->getServerInfo();
        return $this->generateResponse($res,200,$server_info,'Success');
    }
}