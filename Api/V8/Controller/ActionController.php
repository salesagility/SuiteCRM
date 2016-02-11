<?php
namespace SuiteCRM\Api\V8\Controller;

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use SuiteCRM\Api\Core\Api;

class ActionController extends Api
{

    function performAction(Request $req, Response $res, $args)
    {
        global $moduleList;
        $module = $args['module'];
        $action = $args['action'];
        if (in_array($module, $moduleList)) {
            require_once('include/MVC/Controller/ControllerFactory.php');

            $controller = \ControllerFactory::getController($module);

            if (method_exists($controller, $action)) {
                $controller->$action();
                return $this->generateResponse($res, 200, null, 'Success');
            } elseif (file_exists("custom/modules/$module/$action.php")) {
                require_once("custom/modules/$module/$action.php");
                return $this->generateResponse($res, 200, null, 'Success');
            } elseif (file_exists("modules/$module/$action.php")) {
                require_once("modules/$module/$action.php");
                return $this->generateResponse($res, 200, null, 'Success');
            } else {
                $GLOBALS['log']->info(__FILE__ . ': ' . __FUNCTION__ . ' called but action not matched.  Module = ' . $module . ' action ' . $action);
                return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
            }

        } else {
            $GLOBALS['log']->info(__FILE__ . ': ' . __FUNCTION__ . ' called but module not matched.  Module = ' . $module);
            return $this->generateResponse($res, 404, 'Non-matched item', 'Failure');
        }


    }
}