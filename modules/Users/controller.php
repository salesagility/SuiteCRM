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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once("include/OutboundEmail/OutboundEmail.php");

class UsersController extends SugarController
{
	/**
	 * bug 48170
	 * Action resetPreferences gets fired when user clicks on  'Reset User Preferences' button
	 * This action is set in UserViewHelper.php
	 */
	protected function action_resetPreferences(){
	    if($_REQUEST['record'] == $GLOBALS['current_user']->id || ($GLOBALS['current_user']->isAdminForModule('Users'))){
	        $u = new User();
	        $u->retrieve($_REQUEST['record']);
	        $u->resetPreferences();
	        if($u->id == $GLOBALS['current_user']->id) {
	            SugarApplication::redirect('index.php');
	        }
	        else{
	            SugarApplication::redirect("index.php?module=Users&record=".$_REQUEST['record']."&action=DetailView"); //bug 48170]
	
	        }
	    }
	}  
	protected function action_delete()
	{
	    if($_REQUEST['record'] != $GLOBALS['current_user']->id && ($GLOBALS['current_user']->isAdminForModule('Users')
            ))
        {
            $u = new User();
            $u->retrieve($_REQUEST['record']);
            $u->status = 'Inactive';
            $u->employee_status = 'Terminated';
            $u->save();
            $u->mark_deleted($u->id);
            $GLOBALS['log']->info("User id: {$GLOBALS['current_user']->id} deleted user record: {$_REQUEST['record']}");

            $eapm = loadBean('EAPM');
            $eapm->delete_user_accounts($_REQUEST['record']);
            $GLOBALS['log']->info("Removing user's External Accounts");
            
            SugarApplication::redirect("index.php?module=Users&action=index");
        }
        else 
            sugar_die("Unauthorized access to administration.");
	}
	protected function action_wizard() 
	{
		$this->view = 'wizard';
	}

	protected function action_saveuserwizard() 
	{
	    global $current_user, $sugar_config;
	    
	    // set all of these default parameters since the Users save action will undo the defaults otherwise
	    $_POST['record'] = $current_user->id;
	    $_POST['is_admin'] = ( $current_user->is_admin ? 'on' : '' );
	    $_POST['use_real_names'] = true;
		$_POST['reminder_checked'] = '1';
		$_POST['email_reminder_checked'] = '1';
	    $_POST['reminder_time'] = 1800;
		$_POST['email_reminder_time'] = 3600;
        $_POST['mailmerge_on'] = 'on';
        $_POST['receive_notifications'] = $current_user->receive_notifications;
        $_POST['user_theme'] = (string) SugarThemeRegistry::getDefault();


		//Only process the scenario item for admin users!
		if($current_user->isAdmin())
		{
			//Process the scenarios selected in the wizard
			require_once 'install/suite_install/enabledTabs.php';
			//We need to load the tabs so that we can remove those which are scenario based and un-selected
			//Remove the custom tabConfig as this overwrites the complete list containined in the include/tabConfig.php
			if(file_exists('custom/include/tabConfig.php')){
				unlink('custom/include/tabConfig.php');
			}
			require_once('include/tabConfig.php');
			//Remove the custom dashlet so that we can use the complete list of defaults to filter by category
			if(file_exists('custom/modules/Home/dashlets.php')){
				unlink('custom/modules/Home/dashlets.php');
			}
			//Check if the folder is in place
			if(!file_exists('custom/modules/Home')){
				sugar_mkdir('custom/modules/Home', 0775);
			}
			//Check if the folder is in place
			if(!file_exists('custom/include')){
				sugar_mkdir('custom/include', 0775);
			}
			require_once 'modules/Home/dashlets.php';

			require_once 'install/suite_install/scenarios.php';

			foreach($installation_scenarios as $scenario)
			{
				//If the item is not in $_SESSION['scenarios'], then unset them as they are not required
				if(!in_array($scenario['key'],$_REQUEST['scenarios']))
				{
					foreach($scenario['modules'] as $module)
					{
						if (($removeKey = array_search($module, $enabled_tabs)) !== false) {
							unset($enabled_tabs[$removeKey]);
						}
					}
					//Loop through the dashlets to remove from the default home page based on this scenario
					foreach($scenario['dashlets'] as $dashlet)
					{
						//if (($removeKey = array_search($dashlet, $defaultDashlets)) !== false) {
						//    unset($defaultDashlets[$removeKey]);
						// }
						if(isset($defaultDashlets[$dashlet]))
							unset($defaultDashlets[$dashlet]);
					}
					//If the scenario has an associated group tab, remove accordingly (by not adding to the custom tabconfig.php
					if(isset($scenario['groupedTabs']))
					{
						unset($GLOBALS['tabStructure'][$scenario['groupedTabs']]);
					}
				}
			}
			//Have a 'core' options, with accounts / contacts if no other scenario is selected
			if(!is_null($_SESSION['scenarios']))
			{
				unset($GLOBALS['tabStructure']['LBL_TABGROUP_DEFAULT']);
			}
			//Write the tabstructure to custom so that the grouping are not shown for the un-selected scenarios
			$fp = sugar_fopen('custom/include/tabConfig.php', 'w');
			$fileContents = "<?php \n" .'$GLOBALS["tabStructure"] ='.var_export($GLOBALS['tabStructure'],true).';';
			fwrite($fp, $fileContents);
			fclose($fp);
			//Write the dashlets to custom so that the dashlets are not shown for the un-selected scenarios
			$fp = sugar_fopen('custom/modules/Home/dashlets.php', 'w');
			$fileContents = "<?php \n" .'$defaultDashlets ='.var_export($defaultDashlets,true).';';
			fwrite($fp, $fileContents);
			fclose($fp);
			// End of the scenario implementations
		}

	    // save and redirect to new view
	    $_REQUEST['return_module'] = 'Home';
	    $_REQUEST['return_action'] = 'index';
		require('modules/Users/Save.php');
	}

    protected function action_saveftsmodules()
    {
        $this->view = 'fts';
        $GLOBALS['current_user']->setPreference('fts_disabled_modules', $_REQUEST['disabled_modules']);
    }

    /**
     * action "save" (with a lower case S that is for OSX users ;-)
     * @see SugarController::action_save()
     */
    public function action_save()
    {
        require 'modules/Users/Save.php';
    }
}	

