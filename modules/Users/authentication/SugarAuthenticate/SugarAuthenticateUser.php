<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


include_once __DIR__ . '/FactorAuthFactory.php';

/**
 * This file is where the user authentication occurs. No redirection should happen in this file.
 *
 */
class SugarAuthenticateUser{

	/**
	 * Does the actual authentication of the user and returns an id that will be used
	 * to load the current user (loadUserOnSession)
	 *
	 * @param STRING $name
	 * @param STRING $password
	 * @param STRING $fallback - is this authentication a fallback from a failed authentication
	 * @return STRING id - used for loading the user
	 */
	function authenticateUser($name, $password, $fallback=false)
	{
	    $row = User::findUserPassword($name, $password, "(portal_only IS NULL OR portal_only !='1') AND (is_group IS NULL OR is_group !='1') AND status !='Inactive'");
    
	    // set the ID in the seed user.  This can be used for retrieving the full user record later
		//if it's falling back on Sugar Authentication after the login failed on an external authentication return empty if the user has external_auth_disabled for them
		if (empty ($row) || !empty($row['external_auth_only'])) {
			return '';
		} else {
			return $row['id'];
		}
	}
	/**
	 * Checks if a user is a sugarLogin user
	 * which implies they should use the sugar authentication to login
	 *
	 * @param STRING $name
	 * @param STRIUNG $password
	 * @return boolean
	 */
	function isSugarLogin($name, $password)
	{
	    $row = User::findUserPassword($name, $password, "(portal_only IS NULL OR portal_only !='1') AND (is_group IS NULL OR is_group !='1') AND status !='Inactive' AND sugar_login=1");
	    return !empty($row);
	}

	/**
	 * this is called when a user logs in
	 *
	 * @param STRING $name
	 * @param STRING $password
	 * @param STRING $fallback - is this authentication a fallback from a failed authentication
	 * @return boolean
	 */
	function loadUserOnLogin($name, $password, $fallback = false, $PARAMS = array()) {
		global $login_error;

		$GLOBALS['log']->debug("Starting user load for ". $name);
		if(empty($name) || empty($password)) return false;
		$input_hash = $password;
		$passwordEncrypted = false;
		if (!empty($PARAMS) && isset($PARAMS['passwordEncrypted']) && $PARAMS['passwordEncrypted']) {
			$passwordEncrypted = true;
		}// if
		if (!$passwordEncrypted) {
			$input_hash = SugarAuthenticate::encodePassword($password);
		} // if
		$user_id = $this->authenticateUser($name, $input_hash, $fallback);
		if(empty($user_id)) {
			$GLOBALS['log']->fatal('SECURITY: User authentication for '.$name.' failed');
			return false;
		}
		$this->loadUserOnSession($user_id);
		return true;
	}
	/**
	 * Loads the current user bassed on the given user_id
	 *
	 * @param STRING $user_id
	 * @return boolean
	 */
	function loadUserOnSession($user_id=''){
		if(!empty($user_id)){
			$_SESSION['authenticated_user_id'] = $user_id;
		}

		if(!empty($_SESSION['authenticated_user_id']) || !empty($user_id)){
			$GLOBALS['current_user'] = new User();
			if($GLOBALS['current_user']->retrieve($_SESSION['authenticated_user_id'])){

				return true;
			}
		}
		return false;

	}



	public function isUserNeedFactorAuthentication() {
		global $current_user;
		$ret = false;
		if ($current_user->factor_auth) {
			$ret = true;
		}
		return $ret;
	}

    public function isUserFactorAuthenticated() {
		$ret = true;
        if (!isset($_SESSION['user_factor_authenticated']) || !$_SESSION['user_factor_authenticated']) {
            $ret = false;
        }
        return $ret;
    }

	public function isUserFactorTokenReceived() {
		$ret = false;
		if (isset($_REQUEST['factor_token'])) {
			$ret = true;
		}
		return $ret;
	}

	public function factorAuthenticateCheck() {
		if($_SESSION['user_factor_authenticated'] || $_REQUEST['factor_token'] == $_SESSION['factor_token']) {
			$_SESSION['user_factor_authenticated'] = true;
		} else {
            $_SESSION['user_factor_authenticated'] = false;
		}
		return $_SESSION['user_factor_authenticated'];
	}

	public function showFactorTokenInput() {
		global $current_user;

        $GLOBALS['log']->fatal('DEBUG: redirect to factor token input.....');

        $factorAuthClass = $current_user->factor_auth_interface;
        $factory = new FactorAuthFactory();
        $factorAuth = $factory->getFactorAuth($factorAuthClass);
        $factorAuth->showTokenInput();

        die();
	}

	public function isFactorTokenSent() {
		$ret = false;
		if(isset($_SESSION['factor_token']) && $_SESSION['factor_token']) {
			$ret = true;
		}
		return $ret;
	}

	public function sendFactorTokenToUser() {
		global $current_user;

		$token = rand(1000, 9999);

        $GLOBALS['log']->fatal('DEBUG: token sent to user: ' . $current_user->id . ', token: ' . $token . ' so we store it in the session');

        $_SESSION['user_factor_authenticated'] = false;
		$_SESSION['factor_token'] = $token;

		$GLOBALS['log']->fatal('TODO: implement token sending here....!!!!!!!!!!!!!!!');
        // todo: return false when token sending failed

        return true;
	}

	public function redirectToLogout()
	{
        $GLOBALS['log']->fatal('DEBUG: session destroy and redirect to logout.....');
		session_destroy();
		header('Location: index.php?action=Logout&module=Users');
		sugar_cleanup(true);
		die();
	}

	public function isUserLogoutRequest() {
		$logout = false;
		if($_REQUEST['module'] == 'Users' && $_REQUEST['action'] == 'Logout') {
			$logout = true;
		}
		return $logout;
	}


}

?>
