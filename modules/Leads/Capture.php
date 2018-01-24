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


require_once('modules/Leads/LeadFormBase.php');

global $app_strings, $app_list_strings;

$mod_strings = return_module_language($sugar_config['default_language'], 'Leads');

$app_list_strings['record_type_module'] = array('Contact'=>'Contacts', 'Account'=>'Accounts', 'Opportunity'=>'Opportunities', 'Case'=>'Cases', 'Note'=>'Notes', 'Call'=>'Calls', 'Email'=>'Emails', 'Meeting'=>'Meetings', 'Task'=>'Tasks', 'Lead'=>'Leads','Bug'=>'Bugs',
);
/**
 * To make your changes upgrade safe create a file called leadCapture_override.php and place the changes there
 */
$users = array(
	'PUT A RANDOM KEY FROM THE WEBSITE HERE' => array('name'=>'PUT THE USER_NAME HERE', 'pass'=>'PUT THE USER_HASH FOR THE RESPECTIVE USER HERE'),
);
if(file_exists('leadCapture_override.php')){
	include('leadCapture_override.php');
}
if (!empty($_POST['user']) && !empty($users[$_POST['user']])) {

    $current_user = new User();
	$current_user->user_name = $users[$_POST['user']]['name'];

	if($current_user->load_user($users[$_POST['user']]['pass'], true)){
		$leadForm = new LeadFormBase();
		$prefix = '';
		if(!empty($_POST['prefix'])){
			$prefix = 	$_POST['prefix'];
		}

		if( !isset($_POST['assigned_user_id']) || !empty($_POST['assigned_user_id']) ){
			$_POST['prefix'] = $current_user->id;
		}

		$_POST['record'] ='';

		if( isset($_POST['_splitName']) ) {
			$name = explode(' ',$_POST['name']);
			if(sizeof($name) == 1) {
				$_POST['first_name'] = '';  $_POST['last_name'] = $name[0];
			}
			else {
				$_POST['first_name'] = $name[0];  $_POST['last_name'] = $name[1];
			}
		}

		$return_val = $leadForm->handleSave($prefix, false, true);

		if(isset($_POST['redirect']) && !empty($_POST['redirect'])){

			//header("Location: ".$_POST['redirect']);
			echo '<html ' . get_language_header() .'><head><title>SugarCRM</title></head><body>';
			echo '<form name="redirect" action="' .$_POST['redirect']. '" method="POST">';

			foreach($_POST as $param => $value) {

				if($param != 'redirect' && $param != 'submit') {
					echo '<input type="hidden" name="'.$param.'" value="'.$value.'">';
				}

			}

			if( ($return_val == '') || ($return_val  == 0) || ($return_val < 0) ) {
				echo '<input type="hidden" name="error" value="1">';
			}
			echo '</form><script language="javascript" type="text/javascript">document.redirect.submit();</script>';
			echo '</body></html>';
		}
		else{
			echo "Thank You For Your Submission.";
		}
		sugar_cleanup();
		// die to keep code from running into redirect case below
		die();
	}
}

echo "We're sorry, the server is currently unavailable, please try again later.";
if (!empty($_POST['redirect'])) {
	echo '<html ' . get_language_header() . '><head><title>SugarCRM</title></head><body>';
	echo '<form name="redirect" action="' .$_POST['redirect']. '" method="POST">';
	echo '</form><script language="javascript" type="text/javascript">document.redirect.submit();</script>';
	echo '</body></html>';
}
