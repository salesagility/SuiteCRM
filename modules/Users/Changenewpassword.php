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

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
global $app_language, $sugar_config;
global $app_strings;
global $current_language;



require_once('modules/Users/language/en_us.lang.php');
$mod_strings=return_module_language('','Users');

///////////////////////////////////////////////////////////////////////////////
////	RECAPTCHA CHECK ONLY

if(isset($_REQUEST['recaptcha_challenge_field']) && isset($_REQUEST['recaptcha_response_field'])){
	require_once('include/reCaptcha/recaptchalib.php');

	$admin=new Administration();
	$admin->retrieveSettings('captcha');
	if($admin->settings['captcha_on']=='1' && !empty($admin->settings['captcha_private_key'])){
		$privatekey = $admin->settings['captcha_private_key'];
	}else
		echo("Captcha settings not found");
	$response = recaptcha_check_answer($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$_REQUEST["recaptcha_challenge_field"],
										$_REQUEST["recaptcha_response_field"]);
	if(!$response->is_valid){
		switch ($response->error){
		case 'invalid-site-private-key':
			echo $mod_strings['LBL_RECAPTCHA_INVALID_PRIVATE_KEY'];
			break;
		case 'incorrect-captcha-sol' :
			echo $mod_strings['LBL_RECAPTCHA_FILL_FIELD'];
			break;
		case 'invalid-request-cookie' :
			echo $mod_strings['LBL_RECAPTCHA_INVALID_REQUEST_COOKIE'];
			break;
		case 'unknown' :
			echo $mod_strings['LBL_RECAPTCHA_UNKNOWN'];
			break;

		default:
			echo "Invalid captcha entry, go back and fix. ". $response->error. " ";
		}
	}
	else {
		echo("Success");
	}
	return;
}
////	RECAPTCHA CHECK ONLY
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////	PASSWORD GENERATED LINK CHECK USING
////
//// This script :  - check the link expiration
////			   - send the filled form to authenticate.php after changing the password in the database
$redirect='1';
if (isset($_REQUEST['guid']))
 	{
 	// Change 'deleted = 0' clause to 'COALESCE(deleted, 0) = 0' because by default the values were NULL
 	$Q = "SELECT * FROM users_password_link WHERE id = '" . $_REQUEST['guid'] . "' AND COALESCE(deleted, 0) = '0'";
 	$result =$GLOBALS['db']->limitQuery($Q,0,1,false);
	$row = $GLOBALS['db']->fetchByAssoc($result);
	if (!empty($row)){
		$pwd_settings=$GLOBALS['sugar_config']['passwordsetting'];
	    $expired='0';
	    if($pwd_settings['linkexpiration']){
	    	$delay=$pwd_settings['linkexpirationtime']*$pwd_settings['linkexpirationtype'];
            $stim = strtotime($row['date_generated']) + date('Z');
			$expiretime = TimeDate::getInstance()->fromTimestamp($stim)->get("+$delay  minutes")->asDb();
	    	$timenow = TimeDate::getInstance()->nowDb();
	    	if ($timenow > $expiretime)
	    		$expired='1';
	    }

	    if (!$expired)
	    	{
	    		// if the form is filled and we want to login
	    		if (isset($_REQUEST['login']) && $_REQUEST['login'] =='1'){
	    			if ( $row['username'] == $_POST['user_name'] ){

						$usr= new user();
						$usr_id=$usr->retrieve_user_id($_POST['user_name']);
	    				$usr->retrieve($usr_id);
	    				$usr->setNewPassword($_POST['new_password']);
					    $query2 = "UPDATE users_password_link SET deleted='1' where id='".$_REQUEST['guid']."'";
				   		$GLOBALS['db']->query($query2, true, "Error setting link for $usr->user_name: ");
				   		$_POST['user_name'] = $_REQUEST['user_name'];
						$_POST['user_password'] = $_REQUEST['new_password'];
						$_POST['module'] = 'Users';
						$_POST['action'] = 'Authenticate';
						$_POST['login_module'] = 'Home';
						$_POST['login_action'] = 'index';
						$_POST['Login'] = 'Login';
						foreach($_POST as $k=>$v){
							$_REQUEST[$k] = $v;
							$_GET[$k]= $v;
						}
						unset($_REQUEST['entryPoint']);
						unset($_GET['entryPoint']);
						$GLOBALS['app']->execute();
						die();
				   	}
	    		}
				else
				$redirect='0';
    		}
		else
			{
				$query2 = "UPDATE users_password_link SET deleted='1' where id='".$_REQUEST['guid']."'";
		    	$GLOBALS['db']->query($query2, true, "Error setting link");
			}
 		}
 	}

if ($redirect!='0')
	{
	header('location:index.php?action=Login&module=Users');
	exit ();
	}

////	PASSWORD GENERATED LINK CHECK USING
///////////////////////////////////////////////////////////////////////////////

	require_once('include/MVC/View/SugarView.php');
	$view= new SugarView();
	$view->init();
	$view->displayHeader();

	$sugar_smarty = new Sugar_Smarty();

	$admin = new Administration();
	$admin->retrieveSettings('captcha');
	$add_captcha = 0;
	$captcha_privatekey = "";
	$captcha_publickey="";
	$captcha_js = "";
	$Captcha="";
	if(isset($admin->settings['captcha_on'])&& $admin->settings['captcha_on']=='1' && !empty($admin->settings['captcha_private_key']) && !empty($admin->settings['captcha_public_key'])){
		$add_captcha = 1;
		$captcha_privatekey = $admin->settings['captcha_private_key'];
		$captcha_publickey = $admin->settings['captcha_public_key'];
		$captcha_js .="<script type='text/javascript' src='" . getJSPath('cache/include/javascript/sugar_grp1_yui.js') . "'></script><script type='text/javascript' src='" . getJSPath('cache/include/javascript/sugar_grp_yui2.js') . "'></script>
		<script type='text/javascript' src='http://api.recaptcha.net/js/recaptcha_ajax.js'></script>
		<script> //var oldFormAction = document.getElementById('form').action; //save old action
		function initCaptcha(){
				Recaptcha.create('$captcha_publickey' ,'captchaImage',{theme:'custom',callback:Recaptcha.focus_response_field});
				}

		window.onload=initCaptcha;

		var handleFailure=handleSuccess;
		var handleSuccess = function(o){
			if(o.responseText!==undefined && o.responseText =='Success'){

				document.getElementById('user_password').value=document.getElementById('new_password').value;
				document.getElementById('ChangePasswordForm').submit();
			}
			else{
				alert(o.responseText);
				Recaptcha.reload();

			}
		}
		var callback2 =
		{
		  success:handleSuccess,
		  failure: handleFailure
		};
		function validateCaptchaAndSubmit(){
				var form = document.getElementById('form');
				var url = '&to_pdf=1&module=Home&action=index&entryPoint=Changenewpassword&recaptcha_challenge_field='+Recaptcha.get_challenge()+'&recaptcha_response_field='+ Recaptcha.get_response();
				YAHOO.util.Connect.asyncRequest('POST','index.php',callback2,url);

		}

	</script>";
	$Captcha.=$captcha_js;
	$Captcha.= "<tr>
					<td scope='row' width='20%'>".$mod_strings['LBL_RECAPTCHA_INSTRUCTION_OPPOSITE'].":</td>
		            <td width='70%'><input type='text' size='26' id='recaptcha_response_field' value=''></td>
		        	<th rowsapn='2' class='x-sqs-list' ><div  id='recaptcha_image'></div></th>
			    </tr>

			    <tr>
		         	<td colspan='2'>
		         		<a href='javascript:Recaptcha.reload()'> ".$mod_strings['LBL_RECAPTCHA_NEW_CAPTCHA']."</a>&nbsp;&nbsp;
		         		<a class='recaptcha_only_if_image' href='javascript:Recaptcha.switch_type('audio')'>".$mod_strings['LBL_RECAPTCHA_SOUND']."</a>
		         		<a class='recaptcha_only_if_audio' href='javascript:Recaptcha.switch_type('image')'>".$mod_strings['LBL_RECAPTCHA_IMAGE']."</a>
		         	</td>
		        </tr>";

	}else{
		echo"<script>function validateCaptchaAndSubmit(){document.getElementById('user_password').value=document.getElementById('new_password').value;document.getElementById('ChangePasswordForm').submit();}</script>";
	}
$pwd_settings=$GLOBALS['sugar_config']['passwordsetting'];

$sugar_smarty->assign('sugar_md',getWebPath('include/images/sugar_md_open.png'));
$sugar_smarty->assign("MOD", $mod_strings);
$sugar_smarty->assign("CAPTCHA", $Captcha);
$sugar_smarty->assign("IS_ADMIN", '1');
$sugar_smarty->assign("ENTRY_POINT", 'Changenewpassword');
$sugar_smarty->assign('return_action', 'login');
$sugar_smarty->assign("APP", $app_strings);
$sugar_smarty->assign("INSTRUCTION", $app_strings['NTC_LOGIN_MESSAGE']);
$sugar_smarty->assign("USERNAME_FIELD", '<td scope="row" width="30%">'.$mod_strings['LBL_USER_NAME'].':</td><td width="70%"><input type="text" size="20" tabindex="1" id="user_name" name="user_name"  value=""</td>');
$sugar_smarty->assign('PWDSETTINGS', $GLOBALS['sugar_config']['passwordsetting']);


$rules = "'','',''";

$sugar_smarty->assign('SUBMIT_BUTTON','<input title="'.$mod_strings['LBL_LOGIN_BUTTON_TITLE']
	.'" class="button" '
	. 'onclick="if(!set_password(form,newrules(' . $rules . '))) return false; validateCaptchaAndSubmit();" '
	. 'type="button" tabindex="3" id="login_button" name="Login" value="'.$mod_strings['LBL_LOGIN_BUTTON_LABEL'].'" /><br>&nbsp');

if(!empty($_REQUEST['guid'])) $sugar_smarty->assign("GUID", $_REQUEST['guid']);
$sugar_smarty->display('modules/Users/Changenewpassword.tpl');
$view->displayFooter();
?>