<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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




/**
 * This file is used to control the authentication process.
 * It will call on the user authenticate and controll redirection
 * based on the users validation
 *
 */
require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php');
class OpenIDAuthenticate extends SugarAuthenticate
{
    public $userAuthenticateClass = 'OpenIDAuthenticateUser';
    public $authenticationDir = 'OpenIDAuthenticate';
    /**
     * Constructs EmailAuthenticate
     * This will load the user authentication class
     *
     * @return EmailAuthenticate
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function OpenIDAuthenticate()
    {

        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

	public function logout()
    {
    	global $sugar_config;

    	// echo 1;die;
    	$authurl=$sugar_config['OPENID_PROVIDER']['authServerUrl'];
        $realm=$sugar_config['OPENID_PROVIDER']['realm'];
        $redirectUri=$sugar_config['OPENID_PROVIDER']['redirectUri'];        
        $logouturl=$authurl.'/realms/'.$realm.'/protocol/openid-connect/logout?redirect_uri='.$redirectUri;        
    	echo "<script>parent.window.location='$logouturl';</script>";

        session_start();
        session_destroy();
        sugar_cleanup(true);
        
    }
  
    public function getProvider()
    {
        global $sugar_config;
        return new Stevenmaguire\OAuth2\Client\Provider\Keycloak($sugar_config['OPENID_PROVIDER']);
    }
    public function pre_login()
    {
    	global $sugar_config;
        $return_uid_fieldname = $sugar_config['OPENID_PROVIDER']['return_uid_fieldname'];
        
    	$ssoprovider =  $this->getProvider();
    	// echo 'authenticateRemotely';die;

    	 if (!isset($_GET['code'])) {
                    // If we don't have an authorization code then get one
                    $authUrl = $ssoprovider->getAuthorizationUrl();
                    if(isset($_SESSION['oauth2state']))
                    {
                        header('Location: index.php');    
                    }
                    else
                    {
                        $_SESSION['oauth2state'] = $ssoprovider->getState();
                        header('Location: '.$authUrl);    
                    }
                    
                // Check given state against previously stored one to mitigate CSRF attack
                } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
                    unset($_SESSION['oauth2state']);
                    header('Location: index.php');    
                } else {
                    // Try to get an access token (using the authorization coe grant)
                    try {
                        $token = $ssoprovider->getAccessToken('authorization_code', [
                            'code' => $_GET['code']
                        ]);

                    } catch (Exception $e) {
                        header('Location: index.php');    
                    }
                    // Optional: Now you have a token you can look up a users profile data
                    try {
                        $user = $ssoprovider->getResourceOwner($token);
                        $userinfo=$user->toArray();
                        //received [email_verified,name,preferred_username,given_name,family_name,email]
                        $uid=$userinfo[$return_uid_fieldname];
                        $email=$userinfo['email'];
                        $authController = new AuthenticationController();
                        $openidcontroller = $authController->getInstance('OpenIDAuthenticate');

                        $loginsuccess = $openidcontroller->login($uid, '', array());
                        
                      

                    } catch (Exception $e) {
                        $GLOBALS['log']->error('Failed to get resource owner: '.$e->getMessage());
                        header('Location: index.php');    
                    }
                    header('Location: index.php');    
                }
    }


}
