<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2021 SalesAgility Ltd.
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

global $app_list_strings, $mod_strings, $app_strings;

$sugarSmarty = new Sugar_Smarty();

$sugarSmarty->assign('MOD', $mod_strings);
$sugarSmarty->assign('APP', $app_strings);
$sugarSmarty->assign('ISDUPLICATE', '');
$sugarSmarty->assign('APP_LIST', $app_list_strings);
$sugarSmarty->assign('TDWIDTH', 10);

$role = BeanFactory::newBean('ACLRoles');
$role_name = '';
$return = ['module' => 'ACLRoles', 'action' => 'index', 'record' => ''];
if (!empty($_REQUEST['record'])) {
    $role->retrieve($_REQUEST['record']);
    $categories = (new ACLRole())->getRoleActions($_REQUEST['record']);
    $role_name = $role->name;
    if (!empty($_REQUEST['isDuplicate'])) {
        // Role id is stripped here in duplicate so anything using role id after this will not have it.
        $role->id = '';
        $sugarSmarty->assign('ISDUPLICATE', $_REQUEST['record']);
        $duplicateString = translate('LBL_DUPLICATE_OF', 'ACLRoles');
    } else {
        $return['record'] = $role->id;
        $return['action'] = 'DetailView';
    }
} else {
    $categories = (new ACLRole())->getRoleActions('');
}
$sugarSmarty->assign('ROLE', $role->toArray());
$sugarSmarty->assign('CATEGORIES', $categories);

if (isset($_REQUEST['return_module'])) {
    $return['module'] = $_REQUEST['return_module'];
    if (isset($_REQUEST['return_id'])) {
        $return['record'] = $_REQUEST['return_id'];
    }
    if (isset($_REQUEST['return_record'])) {
        $return['record'] = $_REQUEST['return_record'];
    }
    if (isset($_REQUEST['return_action'])) {
        $return['action'] = $_REQUEST['return_action'];
    }
    if (!empty($return['record'])) {
        $return['action'] = 'DetailView';
    }
}

$names = ACLAction::setupCategoriesMatrix($categories);

$sugarSmarty->assign('RETURN', $return);
$sugarSmarty->assign('ACTION_NAMES', $names);

$params = [];
$params[] = "<a href='index.php?module=ACLRoles&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>";
if (empty($role->id)) {
    $params[] = $GLOBALS['app_strings']['LBL_CREATE_BUTTON_LABEL'];
} else {
    $params[] = $role->get_summary_text();
}

$title = getClassicModuleTitle('ACLRoles', $params, true);

$sugarSmarty->assign('TITLE', $title);

$actionButtons = [
    "<input title=" . $app_strings['LBL_SAVE_BUTTON_TITLE'] . " id='save_button'
		accessKey=" . $app_strings['LBL_SAVE_BUTTON_KEY'] . " class='button primary'
		onclick=\"this.form.action.value='Save';return check_form('EditView');\"
		type='submit' name='button' value=" . $app_strings['LBL_SAVE_BUTTON_LABEL'] . " >",
    "<input title=" . $app_strings['LBL_CANCEL_BUTTON_TITLE'] . "
		class='button cancel_button' accessKey=" . $app_strings['LBL_CANCEL_BUTTON_KEY'] . "
		type='submit' name='save' value=" . $app_strings['LBL_CANCEL_BUTTON_LABEL'] . "
		onclick=\"document.EditView.action.value='" . $return['action'] . "';document.EditView.module.value='" .
    $return['module'] . "';document.EditView.record.value='" . $return['record'] . "';document.EditView.submit();\">",
];

$sugarSmarty->assign('ACTION_MENU', $actionButtons);
$sugarSmarty->display('modules/ACLRoles/EditView.tpl');
