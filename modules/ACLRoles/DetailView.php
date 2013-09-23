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



//global $modInvisList;
$sugar_smarty = new Sugar_Smarty();
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);

//nsingh bug: 21669. Messes up localization
/*foreach($modInvisList as $modinvisname){
    if(empty($app_list_strings['moduleList'][$modinvisname])){
	   $app_list_strings['moduleList'][$modinvisname] = $modinvisname;
    }
}*/
$sugar_smarty->assign('APP_LIST', $app_list_strings);
/*foreach($modInvisList as $modinvisname){
	unset($app_list_strings['moduleList'][$modinvisname]);
}*/
$role = new ACLRole();
$role->retrieve($_REQUEST['record']);
$categories = ACLRole::getRoleActions($_REQUEST['record']);
$names = ACLAction::setupCategoriesMatrix($categories);
if(!empty($names))$tdwidth = 100 / sizeof($names);
$sugar_smarty->assign('ROLE', $role->toArray());
$sugar_smarty->assign('CATEGORIES', $categories);
$sugar_smarty->assign('TDWIDTH', $tdwidth);
$sugar_smarty->assign('ACTION_NAMES', $names);

$return= array('module'=>'ACLRoles', 'action'=>'DetailView', 'record'=>$role->id);
$sugar_smarty->assign('RETURN', $return);
$params = array();
$params[] = "<a href='index.php?module=ACLRoles&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>";
$params[] = $role->get_summary_text();
echo getClassicModuleTitle("ACLRoles", $params, true);
//$sugar_smarty->assign('TITLE', $title);
$hide_hide_supanels = true;

echo $sugar_smarty->fetch('modules/ACLRoles/DetailView.tpl');
//for subpanels the variable must be named focus;
$focus =& $role;
$_REQUEST['module'] = 'ACLRoles';
require_once('include/SubPanel/SubPanelTiles.php');

$subpanel = new SubPanelTiles($role, 'ACLRoles');

echo $subpanel->display();



?>