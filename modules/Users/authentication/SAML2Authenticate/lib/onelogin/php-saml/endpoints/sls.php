<?php

/**
 *  SP Single Logout Service Endpoint
 */

session_start();

require_once dirname(__DIR__) . '/_toolkit_loader.php';

$auth = new OneLogin_Saml2_Auth();

$auth->processSLO();

$errors = $auth->getErrors();

if (empty($errors)) {
    print_r('Sucessfully logged out');
} else {
    print_r(implode(', ', $errors));
}
