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
 * This file is where the user authentication occurs. No redirection should happen in this file.
 *
 */
require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticateUser.php');
class OpenIDAuthenticateUser extends SugarAuthenticateUser
{
    public $passwordLength = 4;


    /**
     * this is called when a user logs in
     *
     * @param STRING $name
     * @param STRING $password
     * @return boolean
     */
    public function loadUserOnLogin($name='', $password='', $fallback = false, $PARAMS = array())
    {
        global $login_error,$sugar_config;
        $sql = "SELECT id FROM users WHERE user_name='$name' AND status='Active'";

      	$result = DBManagerFactory::getInstance()->query($sql);
        $row = DBManagerFactory::getInstance()->fetchByAssoc($result);
        if($row['id'])
        {
        	      	 $this->loadUserOnSession($row['id']);
			    	 unset($_SESSION['lastUserId']);
				     unset($_SESSION['lastUserName']);
				     unset($_SESSION['emailAuthToken']);
				     return true;

        }
        else
        {
             $authurl=$sugar_config['OPENID_PROVIDER']['authServerUrl'];
            $realm=$sugar_config['OPENID_PROVIDER']['realm'];
            $redirectUri=$sugar_config['OPENID_PROVIDER']['redirectUri'];        
            $logouturl=$authurl.'/realms/'.$realm.'/protocol/openid-connect/logout?redirect_uri='.$redirectUri;                                
            header("Location: $logouturl");     	
        }
       
    }

    
}
