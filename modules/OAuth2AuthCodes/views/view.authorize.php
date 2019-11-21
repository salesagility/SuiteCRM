<?php
/**
*
* SugarCRM Community Edition is a customer relationship management program developed by
* SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
*
* SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
* Copyright (C) 2011 - 2019 SalesAgility Ltd.
*
* This program is free software; you can redistribute it and/or modify it under
* the terms of the GNU Affero General Public License version 3 as published by the
* Free Software Foundation with the addition of the following permission added
* to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
* IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
* OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
*
* This program is distributed in the hope that it will be useful, but WITHOUT
* ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
* details.
*
* You should have received a copy of the GNU Affero General Public License along with
* this program; if not, see http://www.gnu.org/licenses or write to the Free
* Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
* 02110-1301 USA.
*
* You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
* SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
*
* The interactive user interfaces in modified source and object code versions
* of this program must display Appropriate Legal Notices, as required under
* Section 5 of the GNU Affero General Public License version 3.
*
* In accordance with Section 7(b) of the GNU Affero General Public License version 3,
* these Appropriate Legal Notices must retain the display of the "Powered by
* SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
* reasonably feasible for technical reasons, the Appropriate Legal Notices must
* display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
*/

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use League\OAuth2\Server\AuthorizationServer;
use Api\V8\OAuth2\Entity\UserEntity;

/**
* Class Oauth2AuthCodesViewAuthorize
*/
class Oauth2AuthCodesViewAuthorize extends SugarView
{
    /**
    * @var array $options
    * Options for what UI elements to hide/show/
    */
    public $options = array(
        'show_header' => false,
        'show_title' => false,
        'show_subpanels' => false,
        'show_search' => false,
        'show_footer' => false,
        'show_javascript' => true,
        'view_print' => false,
    );

    public function display()
    {
        $app = new \Slim\App(\Api\Core\Loader\ContainerLoader::configure());
        $server   = $app->getContainer()->get(AuthorizationServer::class);
        $request  = $app->getContainer()->get('request');
        $response = $app->getContainer()->get('response');

        if(strpos($_SERVER['HTTP_REFERER'], 'action=Login') !== false){
            $_SESSION['oauth2authcode_logout'] = TRUE;
        } else {
            unset($_SESSION['oauth2authcode_logout']);
        }

        if(!isset($_SESSION['oauth2authcode']) ||
        $request->getParam('confirmed') == null ||
        $request->getParam('session_id') == null ||
        $request->getParam('session_id') != session_id() ||
        $request->getParam('oauth2authcode_hash') == null ||
        $request->getParam('oauth2authcode_hash') != $_SESSION['oauth2authcode_hash'])
        {
            try {
                $authRequest = $server->validateAuthorizationRequest($request);
            } catch (League\OAuth2\Server\Exception\OAuthServerException $exception) {
                sugar_die($GLOBALS['mod_strings']['LBL_INVALID_REQUEST'].": ".$exception->getMessage());
            }

            global $current_user;
            $authRequest->setUser(new UserEntity($current_user->id)); // an instance of UserEntityInterface

            /** @var \OAuth2AuthCodes $authCode */
            $authCode = BeanFactory::newBean('OAuth2AuthCodes');
            if ($authCode->is_scope_authorized($authRequest)) {
                try {
                    $authRequest->setAuthorizationApproved(true);
                    $response = $server->completeAuthorizationRequest($authRequest, $response);
                } catch (OAuthServerException $exception) {
                }
                $app->respond($response);
            }

            $_SESSION['oauth2authcode'] = serialize($authRequest);
            $hash = md5($_SESSION['oauth2authcode']);
            $_SESSION['oauth2authcode_hash'] = $hash;

            $sugar_smarty = new Sugar_Smarty();
            echo SugarThemeRegistry::current()->getJS();
            echo SugarThemeRegistry::current()->getCSS();
            echo '<link rel="stylesheet" type="text/css" media="all" href="' . getJSPath('modules/Users/login.css') . '">';
            $sugar_smarty->assign('oauth2authcode_hash', $hash);
            $sugar_smarty->assign('scope', $authRequest->getScopes());
            $sugar_smarty->assign('client', array(
                'name' => $authRequest->getClient()->getName(),
                'redirectUri' => $authRequest->getClient()->getRedirectUri()
            ));
            $sugar_smarty->assign('session_id', session_id());
            $sugar_smarty->assign('LOGO_IMAGE', SugarThemeRegistry::current()->getImageURL('company_logo.png'));

            echo $sugar_smarty->fetch('modules/OAuth2AuthCodes/tpl/authorize.tpl');

        } else {
            $authRequest = unserialize($_SESSION['oauth2authcode']);
            unset($_SESSION['oauth2authcode']);
            unset($_SESSION['oauth2authcode_hash']);

            if($_SESSION['oauth2authcode_logout']){
                session_destroy();
            }

            try {
                $authRequest->setAuthorizationApproved($request->getParam('confirmed') == 'always' || $request->getParam('confirmed') == 'once' );
                $response = $server->completeAuthorizationRequest($authRequest, $response);
            } catch (OAuthServerException $exception) {
                $response = $exception->generateHttpResponse($response);
                sugar_cleanup();
                // send response directly, because $app->respond($response) does not work due to some reason (?)
                print($response);
            }
            sugar_cleanup();
            $app->respond($response);
        }
    }
}
