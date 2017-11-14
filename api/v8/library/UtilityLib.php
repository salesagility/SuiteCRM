<?php

namespace SuiteCRM\api\v8\library;

class UtilityLib
{
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
        }

        return ['loginApproved' => false, 'userId' => null];
    }
}
