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

use SuiteCRM\Utility\SuiteValidator;

if (isset($_POST['saveConfig'])) {
    require_once('modules/Users/User.php');
	$focus = new User();
	$isValidator = new SuiteValidator();
        if (!$isValidator->isValidId($_POST['record'])) {
            LoggerManager::getLogger()->warn('Invalid ID in post request');
        } else {
            $record = $_POST['record'];
            $focus->retrieve($record);
            if(!$focus->change_password($_POST['old_password'], $_POST['new_password'])) {
                SugarApplication::appendErrorMessage($focus->error_string);
                SugarApplication::redirect('index.php?action=ChangePassword&module=Users&record=' . $record);
            }

            // Send to new user wizard if it hasn't been run
            $ut = $GLOBALS['current_user']->getPreference('ut');
        }
    if(empty($ut)) {
        SugarApplication::redirect('index.php?module=Users&action=Wizard');
    }

    // Otherwise, send to home page
    SugarApplication::redirect('index.php?module=Home&action=index');
}

require_once('modules/Administration/Forms.php');
require_once('modules/Configurator/Configurator.php');
$configurator = new Configurator();
$sugarConfig = SugarConfig::getInstance();


require_once('include/SugarLogger/SugarLogger.php');
$sugar_smarty = new Sugar_Smarty();
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('MODULE', 'Users');
$sugar_smarty->assign('ACTION', 'ChangePassword');
$sugar_smarty->assign('return_action', 'index');
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('config', $configurator->config);
$sugar_smarty->assign('error', $configurator->errors);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign('PWDSETTINGS', $GLOBALS['sugar_config']['passwordsetting']);
$sugar_smarty->assign('ID', $current_user->id);
$sugar_smarty->assign('IS_ADMIN', $current_user->is_admin);
$sugar_smarty->assign('USER_NAME', $current_user->user_name);
$sugar_smarty->assign("INSTRUCTION", $mod_strings['LBL_CHANGE_SYSTEM_PASSWORD']);
$sugar_smarty->assign('sugar_md', getWebPath('include/images/sugar_md_open.png'));
$sugar_smarty->assign('OLD_PASSWORD_FIELD', '<td scope="row" width="30%">'.$mod_strings['LBL_OLD_PASSWORD'].':</td><td width="70%"><input type="password" size="26" tabindex="1" id="old_password" name="old_password"  value="" /></td>');
$pwd_settings=$GLOBALS['sugar_config']['passwordsetting'];


$rules = "'','',''";
$sugar_smarty->assign(
    'SUBMIT_BUTTON',
    '<input title="'.$app_strings['LBL_SAVE_BUTTON_TITLE'].'" class="button" '
  . 'onclick="if (!set_password(form,newrules(' . $rules . '))) return false; this.form.saveConfig.value=\'1\';" '
  . 'type="submit" name="button" value="'.$app_strings['LBL_SAVE_BUTTON_LABEL'].'" />'
);


if (isset($_SESSION['expiration_type']) && $_SESSION['expiration_type'] != '') {
    $sugar_smarty->assign('EXPIRATION_TYPE', $_SESSION['expiration_type']);
}/*
if ($current_user->system_generated_password == '1')
    $sugar_smarty->assign('EXPIRATION_TYPE', $mod_strings['LBL_PASSWORD_EXPIRATION_GENERATED']);*/
if (isset($_REQUEST['error_password'])) {
    $sugar_smarty->assign('EXPIRATION_TYPE', $_REQUEST['error_password']);
}
$sugar_smarty->display('modules/Users/Changenewpassword.tpl');
