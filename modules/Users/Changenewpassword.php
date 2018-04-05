<?php
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $app_language;
global $sugar_config;
global $app_list_strings;
global $app_strings;
global $current_language;
/** @var DBManager $db */
global $db;

require_once('modules/Users/language/en_us.lang.php');
$mod_strings = return_module_language('', 'Users');

///////////////////////////////////////////////////////////////////////////////
////	RECAPTCHA CHECK ONLY
require_once __DIR__.'/../../include/utils/recaptcha_utils.php';
if (getRecaptchaChallengeField() !== false) {
    $response =  displayRecaptchaValidation();
    if ($response === 'Success') {
        echo $response;
        return;
    } else {
        die($response);
    }
}
////	RECAPTCHA CHECK ONLY
///////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////
////	PASSWORD GENERATED LINK CHECK USING
////
//// This script :  - check the link expiration
////			   - send the filled form to authenticate.php after changing the password in the database
$redirect = '1';
if (isset($_REQUEST['guid'])) {
    // Change 'deleted = 0' clause to 'COALESCE(deleted, 0) = 0' because by default the values were NULL
    $Q = "SELECT * FROM users_password_link WHERE id = '" . $db->quote($_REQUEST['guid']) . "' AND COALESCE(deleted, 0) = '0'";
    $result = $GLOBALS['db']->limitQuery($Q, 0, 1, false);
    $row = $GLOBALS['db']->fetchByAssoc($result);
    if (!empty($row)) {
        $pwd_settings = $GLOBALS['sugar_config']['passwordsetting'];
        $expired = '0';
        if ($pwd_settings['linkexpiration']) {
            $delay = $pwd_settings['linkexpirationtime'] * $pwd_settings['linkexpirationtype'];
            $stim = strtotime($row['date_generated']) + date('Z');
            $expiretime = TimeDate::getInstance()->fromTimestamp($stim)->get("+$delay  minutes")->asDb();
            $timenow = TimeDate::getInstance()->nowDb();
            if ($timenow > $expiretime) {
                $expired = '1';
            }
        }

        if (!$expired) {
            // if the form is filled and we want to login
            if (isset($_REQUEST['login']) && $_REQUEST['login'] == '1') {
                if ($row['username'] == $_POST['user_name']) {

                    $usr = new user();
                    $usr_id = $usr->retrieve_user_id($_POST['user_name']);
                    $usr->retrieve($usr_id);
                    $usr->setNewPassword($_POST['new_password']);
                    $query2 = "UPDATE users_password_link SET deleted='1' where id='" . $db->quote($_REQUEST['guid']) . "'";
                    $GLOBALS['db']->query($query2, true, "Error setting link for $usr->user_name: ");
                    $_POST['user_name'] = $_REQUEST['user_name'];
                    $_POST['username_password'] = $_REQUEST['new_password'];
                    $_POST['module'] = 'Users';
                    $_POST['action'] = 'Authenticate';
                    $_POST['login_module'] = 'Home';
                    $_POST['login_action'] = 'index';
                    $_POST['Login'] = 'Login';
                    foreach ($_POST as $k => $v) {
                        $_REQUEST[$k] = $v;
                        $_GET[$k] = $v;
                    }
                    unset($_REQUEST['entryPoint']);
                    unset($_GET['entryPoint']);
                    $GLOBALS['app']->execute();
                    die();
                }
            } else {
                $redirect = '0';
            }
        } else {
            $query2 = "UPDATE users_password_link SET deleted='1' where id='" . $db->quote($_REQUEST['guid']) . "'";
            $GLOBALS['db']->query($query2, true, "Error setting link");
        }
    }
}

if ($redirect != '0') {
    header('location:index.php?action=Login&module=Users');
    exit ();
}

////	PASSWORD GENERATED LINK CHECK USING
///////////////////////////////////////////////////////////////////////////////

require_once('include/MVC/View/SugarView.php');
$view = new SugarView();
$view->init();
$view->displayHeader();

$sugar_smarty = new Sugar_Smarty();

$pwd_settings = $GLOBALS['sugar_config']['passwordsetting'];

$sugar_smarty->assign('sugar_md', getWebPath('include/images/sugar_md_open.png'));
$sugar_smarty->assign("MOD", $mod_strings);
$sugar_smarty->assign("CAPTCHA", displayRecaptcha());
$sugar_smarty->assign("IS_ADMIN", '1');
$sugar_smarty->assign("ENTRY_POINT", 'Changenewpassword');
$sugar_smarty->assign('return_action', 'login');
$sugar_smarty->assign("APP", $app_strings);
$sugar_smarty->assign("INSTRUCTION", $app_strings['NTC_LOGIN_MESSAGE']);
$sugar_smarty->assign("USERNAME_FIELD",
    '<td scope="row" width="30%">' . $mod_strings['LBL_USER_NAME'] . ':</td><td width="70%"><input type="text" size="20" tabindex="1" id="user_name" name="user_name"  value=""></td>');
$sugar_smarty->assign('PWDSETTINGS', $GLOBALS['sugar_config']['passwordsetting']);


$rules = "'','',''";

$sugar_smarty->assign('SUBMIT_BUTTON', '<input title="' . $mod_strings['LBL_LOGIN_BUTTON_TITLE']
    . '" class="button" '
    . 'onclick="if(!set_password(form,newrules(' . $rules . '))) return false; validateCaptchaAndSubmit();" '
    . 'type="button" tabindex="3" id="login_button" name="Login" value="' . $mod_strings['LBL_LOGIN_BUTTON_LABEL'] . '" /><br>&nbsp');

if (!empty($_REQUEST['guid'])) {
    $sugar_smarty->assign("GUID", $_REQUEST['guid']);
}
$sugar_smarty->display('modules/Users/Changenewpassword.tpl');
$view->displayFooter();
