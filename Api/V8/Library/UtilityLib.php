<?php
namespace SuiteCRM\Api\V8\Library;


class UtilityLib
{

    function getServerInfo()
    {
        require_once('suitecrm_version.php');
        return array('suite_version' => $suitecrm_version);
    }

    function login()
    {
        //Get the parameters
        require_once('modules/Users/authentication/AuthenticationController.php');
        $authController = new \AuthenticationController();
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];


        if ($authController->login($username, $password)) {
            $usr = new \user();
            return array("loginApproved" => true, "userId" => $usr->retrieve_user_id($username));
        } else {
            return array("loginApproved" => false, "userId" => null);
        }

    }


}