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


require_once('include/SugarFields/SugarFieldHandler.php');
require_once('modules/MySettings/TabController.php');

$display_tabs_def = isset($_REQUEST['display_tabs_def']) ? urldecode($_REQUEST['display_tabs_def']) : '';
$hide_tabs_def = isset($_REQUEST['hide_tabs_def']) ? urldecode($_REQUEST['hide_tabs_def']): '';
$remove_tabs_def = isset($_REQUEST['remove_tabs_def']) ? urldecode($_REQUEST['remove_tabs_def']): '';

$DISPLAY_ARR = array();
$HIDE_ARR = array();
$REMOVE_ARR = array();

parse_str($display_tabs_def,$DISPLAY_ARR);
parse_str($hide_tabs_def,$HIDE_ARR);
parse_str($remove_tabs_def,$REMOVE_ARR);



if (isset($_POST['id']))
	sugar_die("Unauthorized access to administration.");
if (isset($_POST['record']) && !is_admin($current_user)
     && !$GLOBALS['current_user']->isAdminForModule('Users')
     && $_POST['record'] != $current_user->id)
sugar_die("Unauthorized access to administration.");
elseif (!isset($_POST['record']) && !is_admin($current_user)
     && !$GLOBALS['current_user']->isAdminForModule('Users'))
sugar_die ("Unauthorized access to user administration.");
$focus = new User();
$focus->retrieve($_POST['record']);

//update any ETag seeds that are tied to the user object changing
$focus->incrementETag("mainMenuETag");

// Flag to determine whether to save a new password or not.
// Bug 43241 - Changed $focus->id to $focus->user_name to make sure that a system generated password is made when converting employee to user
if(empty($focus->user_name))
{
    $newUser = true;
    clear_register_value('user_array',$focus->object_name);
} else {
    $newUser = false;
}


if(!$current_user->is_admin && !$GLOBALS['current_user']->isAdminForModule('Users')
) {
    if($current_user->id != $focus->id
    || !empty($_POST['is_admin'])
    || (!empty($_POST['UserType']) && $_POST['UserType'] == 'Administrator')
    ) {
        $GLOBALS['log']->fatal("SECURITY:Non-Admin ". $current_user->id . " attempted to change settings for user:". $focus->id);
        header("Location: index.php?module=Users&action=Logout");
        exit;
    }
}


    // Populate the custom fields
    $sfh = new SugarFieldHandler();
    foreach ($focus->field_defs as $fieldName => $field)
    {
        if (isset($field['source']) && $field['source'] == 'custom_fields')
        {
            $type = !empty($field['custom_type']) ? $field['custom_type'] : $field['type'];
            $sf = $sfh->getSugarField($type);
            if ($sf != null)
            {
                $sf->save($focus, $_POST, $fieldName, $field, '');
            }
            else
            {
                $GLOBALS['log']->fatal("Field '$fieldName' does not have a SugarField handler");
            }
        }
    }


	$portal=array("user_name","last_name","status","portal_only");
	$group=array("user_name","last_name","status","is_group");
	if(isset($_POST['portal_only']) && ($_POST['portal_only']=='1' || $focus->portal_only)){
		foreach($portal as $field){
			if(isset($_POST[$field]))
			{
				$value = $_POST[$field];
				$focus->$field = $value;

			}
		}
	}

	if(isset($_POST['is_group']) && ($_POST['is_group']=='1' || $focus->is_group)){
		foreach($group as $field){
			if(isset($_POST[$field]))
			{
				$value = $_POST[$field];
				$focus->$field = $value;

			}
		}
	}


	// copy the group or portal user name over.  We renamed the field in order to ensure auto-complete would not change the value
	if(isset($_POST['user_name']))
	{
		$focus->user_name = $_POST['user_name'];
	}

	// if the user saved is a Regular User
	if(!$focus->is_group && !$focus->portal_only){

        foreach ($focus->column_fields as $fieldName)
        {
            $field = $focus->field_defs[$fieldName];
            $type = !empty($field['custom_type']) ? $field['custom_type'] : $field['type'];
            $sf = $sfh->getSugarField($type);
            if ($sf != null)
            {
                $sf->save($focus, $_POST, $fieldName, $field, '');
            }
            else
            {
                $GLOBALS['log']->fatal("Field '$fieldName' does not have a SugarField handler");
            }
        }
        foreach ($focus->additional_column_fields as $fieldName)
        {
            $field = $focus->field_defs[$fieldName];
            $type = !empty($field['custom_type']) ? $field['custom_type'] : $field['type'];
            $sf = $sfh->getSugarField($type);
            if ($sf != null)
            {
                $sf->save($focus, $_POST, $fieldName, $field, '');
            }
            else
            {
                $GLOBALS['log']->fatal("Field '$fieldName' does not have a SugarField handler");
            }
        }

		$focus->is_group=0;
		$focus->portal_only=0;

     		if(isset($_POST['status']) && $_POST['status']== "Inactive") $focus->employee_status = "Terminated"; //bug49972

			if(isset($_POST['user_name']))
		{
			$focus->user_name = $_POST['user_name'];
		}
		if((isset($_POST['is_admin']) && ($_POST['is_admin'] == 'on' || $_POST['is_admin'] == '1')) ||
           (isset($_POST['UserType']) && $_POST['UserType'] == "Administrator")) $focus->is_admin = 1;
		elseif(isset($_POST['is_admin']) && empty($_POST['is_admin'])) $focus->is_admin = 0;
		//if(empty($_POST['portal_only']) || !empty($_POST['is_admin'])) $focus->portal_only = 0;
		//if(empty($_POST['is_group'])    || !empty($_POST['is_admin'])) $focus->is_group = 0;
		if(empty($_POST['receive_notifications'])) $focus->receive_notifications = 0;

		if(isset($_POST['mailmerge_on']) && !empty($_POST['mailmerge_on'])) {
			$focus->setPreference('mailmerge_on','on', 0, 'global');
		} else {
			$focus->setPreference('mailmerge_on','off', 0, 'global');
		}

	    if(isset($_POST['user_swap_last_viewed']))
	    {
	        $focus->setPreference('swap_last_viewed', $_POST['user_swap_last_viewed'], 0, 'global');
	    }
	    else
	    {
	    	$focus->setPreference('swap_last_viewed', '', 0, 'global');
	    }

	    if(isset($_POST['user_swap_shortcuts']))
	    {
	        $focus->setPreference('swap_shortcuts', $_POST['user_swap_shortcuts'], 0, 'global');
	    }
	    else
	    {
	        $focus->setPreference('swap_shortcuts', '', 0, 'global');
	    }

	    if(isset($_POST['use_group_tabs']))
	    {
	        $focus->setPreference('navigation_paradigm', $_POST['use_group_tabs'], 0, 'global');
	    }
	    else
	    {
	        $focus->setPreference('navigation_paradigm', 'gm', 0, 'global');
	    }

	    if(isset($_POST['user_subpanel_tabs']))
	    {
	        $focus->setPreference('subpanel_tabs', $_POST['user_subpanel_tabs'], 0, 'global');
	    }
	    else
	    {
	        $focus->setPreference('subpanel_tabs', '', 0, 'global');
	    }

        if(isset($_POST['user_theme']))
        {
            $focus->setPreference('user_theme', $_POST['user_theme'], 0, 'global');
            $_SESSION['authenticated_user_theme'] = $_POST['user_theme'];
        }

        if(isset($_POST['user_module_favicon']))
	    {
	        $focus->setPreference('module_favicon', $_POST['user_module_favicon'], 0, 'global');
	    }
	    else
	    {
	        $focus->setPreference('module_favicon', '', 0, 'global');
	    }

		$tabs = new TabController();
		if(isset($_POST['display_tabs']))
			$tabs->set_user_tabs($DISPLAY_ARR['display_tabs'], $focus, 'display');
		if(isset($HIDE_ARR['hide_tabs'])){
			$tabs->set_user_tabs($HIDE_ARR['hide_tabs'], $focus, 'hide');

		}else{
			$tabs->set_user_tabs(array(), $focus, 'hide');
		}
		if(is_admin($current_user)){
			if(isset($REMOVE_ARR['remove_tabs'])){
				$tabs->set_user_tabs($REMOVE_ARR['remove_tabs'], $focus, 'remove');
			}else{
				$tabs->set_user_tabs(array(), $focus, 'remove');
			}
		}

	    if(isset($_POST['no_opps'])) {
	        $focus->setPreference('no_opps',$_POST['no_opps'], 0, 'global');
	    }
	    else {
	        $focus->setPreference('no_opps','off', 0, 'global');
	    }

		if(isset($_POST['reminder_checked']) && $_POST['reminder_checked'] == '1' && isset($_POST['reminder_checked'])){
			$focus->setPreference('reminder_time', $_POST['reminder_time'], 0, 'global');
		}else{
			// cn: bug 5522, need to unset reminder time if unchecked.
			$focus->setPreference('reminder_time', -1, 0, 'global');
		}

		if(isset($_POST['email_reminder_checked']) && $_POST['email_reminder_checked'] == '1' && isset($_POST['email_reminder_checked'])){
			$focus->setPreference('email_reminder_time', $_POST['email_reminder_time'], 0, 'global');
		}else{
			$focus->setPreference('email_reminder_time', -1, 0, 'global');
		}
		if(isset($_POST['timezone'])) $focus->setPreference('timezone',$_POST['timezone'], 0, 'global');
		if(isset($_POST['ut'])) $focus->setPreference('ut', '0', 0, 'global');
		else $focus->setPreference('ut', '1', 0, 'global');
		if(isset($_POST['currency'])) $focus->setPreference('currency',$_POST['currency'], 0, 'global');
		if(isset($_POST['default_currency_significant_digits'])) $focus->setPreference('default_currency_significant_digits',$_POST['default_currency_significant_digits'], 0, 'global');
		if(isset($_POST['num_grp_sep'])) $focus->setPreference('num_grp_sep', $_POST['num_grp_sep'], 0, 'global');
		if(isset($_POST['dec_sep'])) $focus->setPreference('dec_sep', $_POST['dec_sep'], 0, 'global');
                if(isset($_POST['fdow'])) $focus->setPreference('fdow', $_POST['fdow'], 0, 'global');
		if(isset($_POST['dateformat'])) $focus->setPreference('datef',$_POST['dateformat'], 0, 'global');
		if(isset($_POST['timeformat'])) $focus->setPreference('timef',$_POST['timeformat'], 0, 'global');
		if(isset($_POST['timezone'])) $focus->setPreference('timezone',$_POST['timezone'], 0, 'global');
		if(isset($_POST['mail_fromname'])) $focus->setPreference('mail_fromname',$_POST['mail_fromname'], 0, 'global');
		if(isset($_POST['mail_fromaddress'])) $focus->setPreference('mail_fromaddress',$_POST['mail_fromaddress'], 0, 'global');
		if(isset($_POST['mail_sendtype'])) $focus->setPreference('mail_sendtype', $_POST['mail_sendtype'], 0, 'global');
		if(isset($_POST['mail_smtpserver'])) $focus->setPreference('mail_smtpserver',$_POST['mail_smtpserver'], 0, 'global');
		if(isset($_POST['mail_smtpport'])) $focus->setPreference('mail_smtpport',$_POST['mail_smtpport'], 0, 'global');
		if(isset($_POST['mail_smtpuser'])) $focus->setPreference('mail_smtpuser',$_POST['mail_smtpuser'], 0, 'global');
		if(isset($_POST['mail_smtppass'])) $focus->setPreference('mail_smtppass',$_POST['mail_smtppass'], 0, 'global');
		if(isset($_POST['default_locale_name_format'])) $focus->setPreference('default_locale_name_format',$_POST['default_locale_name_format'], 0, 'global');
		if(isset($_POST['export_delimiter'])) $focus->setPreference('export_delimiter', $_POST['export_delimiter'], 0, 'global');
		if(isset($_POST['default_export_charset'])) $focus->setPreference('default_export_charset', $_POST['default_export_charset'], 0, 'global');
		if(isset($_POST['use_real_names'])) {
			$focus->setPreference('use_real_names', 'on', 0, 'global');
		} elseif(!isset($_POST['use_real_names']) && !isset($_POST['from_dcmenu'])) {
			// Make sure we're on the full form and not the QuickCreate.
			$focus->setPreference('use_real_names', 'off', 0, 'global');
		}

		if(isset($_POST['mail_smtpauth_req'])) {
			$focus->setPreference('mail_smtpauth_req',$_POST['mail_smtpauth_req'] , 0, 'global');
		} else {
			$focus->setPreference('mail_smtpauth_req','', 0, 'global');
		}

		// SSL-enabled SMTP connection
		if(isset($_POST['mail_smtpssl'])) {
			$focus->setPreference('mail_smtpssl', 1, 0, 'global');
		} else {
			$focus->setPreference('mail_smtpssl', 0, 0, 'global');
		}
	    ///////////////////////////////////////////////////////////////////////////
	    ////    PDF SETTINGS
	    foreach($_POST as $k=>$v){
	        if(strpos($k,"sugarpdf_pdf") !== false){
	            $focus->setPreference($k, $v, 0, 'global');
	        }
	    }
	    ////    PDF SETTINGS
		///////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////////////
		////	SIGNATURES
		if(isset($_POST['signature_id']))
			$focus->setPreference('signature_default', $_POST['signature_id'], 0, 'global');

		if(isset($_POST['signature_prepend'])) $focus->setPreference('signature_prepend',$_POST['signature_prepend'], 0, 'global');
		////	END SIGNATURES
		///////////////////////////////////////////////////////////////////////////


		 if(isset($_POST['email_link_type'])) $focus->setPreference('email_link_type', $_REQUEST['email_link_type']);
		if(isset($_REQUEST['email_show_counts'])) {
			$focus->setPreference('email_show_counts', $_REQUEST['email_show_counts'], 0, 'global');
		} else {
			$focus->setPreference('email_show_counts', 0, 0, 'global');
		}
		if(isset($_REQUEST['email_editor_option']))
			$focus->setPreference('email_editor_option', $_REQUEST['email_editor_option'], 0, 'global');
		if(isset($_REQUEST['default_email_charset']))
			$focus->setPreference('default_email_charset', $_REQUEST['default_email_charset'], 0, 'global');

		if(isset($_POST['calendar_publish_key'])) $focus->setPreference('calendar_publish_key',$_POST['calendar_publish_key'], 0, 'global');
	}

	if (!$focus->verify_data())
	{
		header("Location: index.php?action=Error&module=Users&error_string=".urlencode($focus->error_string));
		exit;
	}
	else
	{	$GLOBALS['sugar_config']['disable_team_access_check'] = true;
		$focus->save();
		$GLOBALS['sugar_config']['disable_team_access_check'] = false;
		$return_id = $focus->id;
		$ieVerified = true;

		global $new_pwd;
		$new_pwd='';
		if((isset($_POST['old_password']) || $focus->portal_only) &&
			(isset($_POST['new_password']) && !empty($_POST['new_password'])) &&
			(isset($_POST['password_change']) && $_POST['password_change'] == 'true') ) {
			if (!$focus->change_password($_POST['old_password'], $_POST['new_password'])) {
			   if((isset($_POST['page']) && $_POST['page'] == 'EditView')){
			       header("Location: index.php?action=EditView&module=Users&record=".$_POST['record']."&error_password=".urlencode($focus->error_string));
			       exit;
			   }
			   if((isset($_POST['page']) && $_POST['page'] == 'Change')){
			       header("Location: index.php?action=ChangePassword&module=Users&record=".$_POST['record']."&error_password=".urlencode($focus->error_string));
			       exit;
			   }
		   }
		   else{
		   		if ($newUser)
		   			$new_pwd='3';
		   		else
		   			$new_pwd='1';
		   }
		}

		///////////////////////////////////////////////////////////////////////////
		////	OUTBOUND EMAIL SAVES
		///////////////////////////////////////////////////////////////////////////

		$sysOutboundAccunt = new OutboundEmail();

		//If a user is not alloweed to use the default system outbound account then they will be
		//saving their own username/password for the system account
		if( ! $sysOutboundAccunt->isAllowUserAccessToSystemDefaultOutbound() )
        {
            $userOverrideOE = $sysOutboundAccunt->getUsersMailerForSystemOverride($focus->id);
            if($userOverrideOE != null)
            {
                //User is alloweed to clear username and pass so no need to check for blanks.
                $userOverrideOE->mail_smtpuser = $_REQUEST['mail_smtpuser'];
                $userOverrideOE->mail_smtppass = $_REQUEST['mail_smtppass'];
                $userOverrideOE->save();
            }
            else
            {
                //If a user name and password for the mail account is set, create the users override account.
                if( ! (empty($_REQUEST['mail_smtpuser']) || empty($_REQUEST['mail_smtppass'])) )
                    $sysOutboundAccunt->createUserSystemOverrideAccount($focus->id,$_REQUEST['mail_smtpuser'],$_REQUEST['mail_smtppass'] );
            }
        }


		///////////////////////////////////////////////////////////////////////////
		////	INBOUND EMAIL SAVES
		if(isset($_REQUEST['server_url']) && !empty($_REQUEST['server_url'])) {

			$ie = new InboundEmail();
			if(false === $ie->savePersonalEmailAccount($return_id, $focus->user_name)) {
				header("Location: index.php?action=Error&module=Users&error_string=&ie_error=true&id=".$return_id);
				die(); // die here, else the header redirect below takes over.
			}
		} elseif(isset($_REQUEST['ie_id']) && !empty($_REQUEST['ie_id']) && empty($_REQUEST['server_url'])) {
			// user is deleting their I-E

			$ie = new InboundEmail();
			$ie->deletePersonalEmailAccount($_REQUEST['ie_id'], $focus->user_name);
		}
		////	END INBOUND EMAIL SAVES
		///////////////////////////////////////////////////////////////////////////
		if(($newUser) && !($focus->is_group) && !($focus->portal_only) && isset($sugar_config['passwordsetting']['SystemGeneratedPasswordON']) && $sugar_config['passwordsetting']['SystemGeneratedPasswordON']){
			$new_pwd='2';
			require_once('modules/Users/GeneratePassword.php');
		}

	}


    //handle navigation from user wizard
    if(isset($_REQUEST['whatnext'])){
        if($_REQUEST['whatnext']== 'import'){
            header("Location:index.php?module=Import&action=step1&import_module=Administration");
            return;
        }elseif($_REQUEST['whatnext']== 'users'){
            header("Location:index.php?module=Users&action=index");
            return;
        }elseif($_REQUEST['whatnext']== 'settings'){
            header("Location:index.php?module=Configurator&action=EditView");
            return;
        }elseif($_REQUEST['whatnext']== 'studio'){
            header("Location:index.php?module=ModuleBuilder&action=index&type=studio");
            return;
        }else{
            //do nothing, let the navigation continue as normal using code below
        }

    }

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Users";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

$GLOBALS['log']->debug("Saved record with id of ".$return_id);

$redirect = "index.php?action={$return_action}&module={$return_module}&record={$return_id}";
$redirect .= isset($_REQUEST['type']) ? "&type={$_REQUEST['type']}" : ''; // cn: bug 6897 - detect redirect to Email compose
$redirect .= isset($_REQUEST['return_id']) ? "&return_id={$_REQUEST['return_id']}" : '';
$redirect .= ($new_pwd!='') ? "&pwd_set=".$new_pwd : '';
header("Location: {$redirect}");
?>
