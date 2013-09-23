<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


 function canSendPassword() {
 	require_once('include/SugarPHPMailer.php');
    global $mod_strings;
	global $current_user;
	global $app_strings;
	$mail = new SugarPHPMailer();
 	$emailTemp = new EmailTemplate();
 	$mail->setMailerForSystem();
    $emailTemp->disable_row_level_security = true;


    if ($current_user->is_admin){
    	if ($emailTemp->retrieve($GLOBALS['sugar_config']['passwordsetting']['generatepasswordtmpl']) == '')
        	return $mod_strings['LBL_EMAIL_TEMPLATE_MISSING'];
    	if(empty($emailTemp->body) && empty($emailTemp->body_html))
    		return $app_strings['LBL_EMAIL_TEMPLATE_EDIT_PLAIN_TEXT'];
    	if($mail->Mailer == 'smtp' && $mail->Host =='')
    		return $mod_strings['ERR_SERVER_SMTP_EMPTY'];

		$email_errors=$mod_strings['ERR_EMAIL_NOT_SENT_ADMIN'];
		if ($mail->Mailer == 'smtp')
			$email_errors.="<br>-".$mod_strings['ERR_SMTP_URL_SMTP_PORT'];
		if ($mail->SMTPAuth)
		 	$email_errors.="<br>-".$mod_strings['ERR_SMTP_USERNAME_SMTP_PASSWORD'];
		$email_errors.="<br>-".$mod_strings['ERR_RECIPIENT_EMAIL'];
		$email_errors.="<br>-".$mod_strings['ERR_SERVER_STATUS'];
		return $email_errors;
	}
	else
		return $mod_strings['LBL_EMAIL_NOT_SENT'];
}

function  hasPasswordExpired($username){
    $current_user= new user();
    $usr_id=$current_user->retrieve_user_id($username);
	$current_user->retrieve($usr_id);
	$type = '';
	if ($current_user->system_generated_password == '1'){
        $type='syst';
    }

    if ($current_user->portal_only=='0'){
	    global $mod_strings, $timedate;
	    $res=$GLOBALS['sugar_config']['passwordsetting'];
	  	if ($type != '') {
		    switch($res[$type.'expiration']){

	        case '1':
		    	global $timedate;
		    	if ($current_user->pwd_last_changed == ''){
		    		$current_user->pwd_last_changed= $timedate->nowDb();
		    		$current_user->save();
		    		}

		        $expireday = $res[$type.'expirationtype']*$res[$type.'expirationtime'];
		        $expiretime = $timedate->fromUser($current_user->pwd_last_changed)->get("+{$expireday} days")->ts;

			    if ($timedate->getNow()->ts < $expiretime)
			    	return false;
			    else{
			    	$_SESSION['expiration_type']= $mod_strings['LBL_PASSWORD_EXPIRATION_TIME'];
			    	return true;
			    	}
				break;


		    case '2':
		    	$login=$current_user->getPreference('loginexpiration');
		    	$current_user->setPreference('loginexpiration',$login+1);
		        $current_user->save();
		        if ($login+1 >= $res[$type.'expirationlogin']){
		        	$_SESSION['expiration_type']= $mod_strings['LBL_PASSWORD_EXPIRATION_LOGIN'];
		        	return true;
		        }
		        else
		            {
			    	return false;
			    	}
		    	break;

		    case '0':
		        return false;
		   	 	break;
		    }
		}
    }
}
