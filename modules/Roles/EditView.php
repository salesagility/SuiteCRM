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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




require_once('modules/Roles/Forms.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;

$focus = new Role();

if(isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == '1') {
	$focus->id = "";
	unset($_REQUEST['record']);
}
global $theme;



$GLOBALS['log']->info("Role Edit View");
echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'],$focus->name), true);
$xtpl=new XTemplate ('modules/Roles/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
// handle Create $module then Cancel
if (empty($_REQUEST['return_id'])) {
	$xtpl->assign("RETURN_ACTION", 'index');
}
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("JAVASCRIPT", get_set_focus_js() . get_chooser_js() . get_validate_record_js());
$xtpl->assign("ID", $focus->id);
$xtpl->assign("NAME", $focus->name);
$xtpl->assign("DESCRIPTION", $focus->description);

require_once("include/templates/TemplateGroupChooser.php");
require_once("modules/MySettings/TabController.php");

$chooser = new TemplateGroupChooser();
$controller = new TabController();
$chooser->args['id'] = 'edit_tabs';

if(isset($_REQUEST['record']))
{
	$chooser->args['values_array'][0] = $focus->query_modules(1);
	$chooser->args['values_array'][1] = $focus->query_modules(0);

	foreach ($chooser->args['values_array'][0] as $key=>$value)
	{
		$chooser->args['values_array'][0][$value] = $app_list_strings['moduleList'][$value];
		unset($chooser->args['values_array'][0][$key]);
	}

	foreach ($chooser->args['values_array'][1] as $key=>$value)
	{
		$chooser->args['values_array'][1][$value] = $app_list_strings['moduleList'][$value];
		unset($chooser->args['values_array'][1][$key]);

	}
}
else
{
	$chooser->args['values_array'] = $controller->get_tabs_system();
	foreach ($chooser->args['values_array'][0] as $key=>$value)
	{
		$chooser->args['values_array'][0][$key] = $app_list_strings['moduleList'][$key];
	}
	foreach ($chooser->args['values_array'][1] as $key=>$value)
	{
	$chooser->args['values_array'][1][$key] = $app_list_strings['moduleList'][$key];
	}

}
	
$chooser->args['left_name'] = 'display_tabs';
$chooser->args['right_name'] = 'hide_tabs';
$chooser->args['left_label'] =  $mod_strings['LBL_ALLOWED_MODULES'];
$chooser->args['right_label'] =  $mod_strings['LBL_DISALLOWED_MODULES'];
$chooser->args['title'] =  $mod_strings['LBL_ASSIGN_MODULES'];

$xtpl->assign("TAB_CHOOSER", $chooser->display());

$xtpl->parse("main");
$xtpl->out("main");

$javascript = new javascript();
$javascript->setFormName('EditView');
$javascript->setSugarBean($focus);
$javascript->addAllFields('');
echo $javascript->getScript();


?>
