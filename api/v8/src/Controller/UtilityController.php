<?php
namespace SuiteCRM\Controller;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;


class UtilityController extends Api{

    function getServerInfo(Request $req, Response $res, $args)
    {
        require_once('suitecrm_version.php');
        require_once('sugar_version.php');
        require_once('modules/Administration/Administration.php');
        global $sugar_flavor;
        $admin = new \Administration();
        $admin->retrieveSettings('info');
        $ret = array();

        $sugar_version = '';
        if (isset($admin->settings['info_sugar_version'])) {
            $sugar_version = $admin->settings['info_sugar_version'];
        } else {
            $sugar_version = '1.0';
        }
        $ret['data'] = array('suite_version' => $suitecrm_version, 'sugar_version'=> $sugar_version);
        return $this->generateResponse($res,200,$ret,'Success');
    }




}