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





global $app_strings;
global $app_list_strings;
global $mod_strings;
global $theme;


$focus = new Group();

if (!is_admin($current_user) && $_REQUEST['record'] != $current_user->id) {
    sugar_die("Unauthorized access to administration.");
}
if (isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
    //TODO figure out why i have to hard-code this data load?
    $focus->default_team = $focus->fetched_row['default_team'];
}
if (isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
    $focus->id = "";
    $focus->user_name = "";
}

echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->last_name." (".$focus->user_name.")"), true);

$GLOBALS['log']->info("Groups edit view");
$xtpl= new XTemplate('modules/Groups/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("USER_NAME", $focus->user_name);
$xtpl->assign("DESCRIPTION", $focus->description);

if (isset($_REQUEST['return_module'])) {
    $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
}
if (isset($_REQUEST['return_action'])) {
    $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
}
if (isset($_REQUEST['return_id'])) {
    $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
}
// handle Create $module then Cancel
if (empty($_REQUEST['return_id'])) {
    $xtpl->assign("RETURN_ACTION", 'index');
}
$xtpl->parse("main");
$xtpl->out("main");
