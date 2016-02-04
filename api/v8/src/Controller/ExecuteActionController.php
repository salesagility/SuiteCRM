<?php
namespace SuiteCRM\Controller;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;


class ExecuteActionController extends Api{

    //This is used by both get_action and post_action
    function performAction(Request $req, Response $res, $args)
    {
        global $errorList, $moduleList;
        $module = $args['module'];
        $action = $args['action'];

        $queryParams = $req->getQueryParams();
        $formParams = $req->getParsedBody();

        //This is to allow the controller action methods to have access to the post / get variables
        $_POST = array_merge($_POST,$queryParams);
        $_GET = array_merge($_GET,$formParams);
        $_REQUEST = array_merge($_REQUEST,$_POST);
        $_REQUEST = array_merge($_REQUEST,$_GET);

        if (in_array($module, $moduleList)) {
            require_once('include/MVC/Controller/ControllerFactory.php');

            $controller = \ControllerFactory::getController($module);

            if(method_exists($controller,$action))
            {
                $controller->$action();
                return $this->generateResponse($res,200,NULL,'Success');
            }
            elseif(file_exists("custom/modules/$module/$action.php"))
            {
                require_once("custom/modules/$module/$action.php");
                return $this->generateResponse($res,200,NULL,'Success');
            }
            elseif(file_exists("modules/$module/$action.php"))
            {
                require_once("modules/$module/$action.php");
                return $this->generateResponse($res,200,NULL,'Success');
            }
            else
            {
                $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but action not matched.  Module = '.$module.' action '.$action);
                return $this->generateResponse($res, 404,NULL,'Non-matched item');
            }

        }
        else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module);
            return $this->generateResponse($res, 404,NULL,'Non-matched item');
        }
    }


}