<?php

namespace SuiteCRM\Api\V8\Library;

class UtilityLib
{
    /**
     * @return array
     */
    public function getServerInfo()
    {
        require_once 'suitecrm_version.php';

        return ['suite_version' => $suitecrm_version];
    }

    /**
     * @param $postData
     *
     * @return array
     */
    public function login($postData)
    {
        //Get the parameters
        require_once 'modules/Users/authentication/AuthenticationController.php';
        $authController = new \AuthenticationController();
        $username = $postData['username'];
        $password = $postData['password'];

        if ($authController->login($username, $password, ['passwordEncrypted' => false])) {
            $usr = new \user();

            return ['loginApproved' => true, 'userId' => $usr->retrieve_user_id($username)];
        } else {
            return ['loginApproved' => false, 'userId' => null];
        }
    }
}
