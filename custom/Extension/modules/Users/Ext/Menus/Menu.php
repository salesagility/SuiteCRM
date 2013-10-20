<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $current_language, $app_strings, $current_user;
$sg_mod_strings = return_module_language($current_language, 'SecurityGroups');
$module_menu[] = Array("index.php?module=SecurityGroups&action=EditView&return_module=SecurityGroups&return_action=DetailView", $sg_mod_strings['LNK_NEW_RECORD'],"SecurityGroups");
$module_menu[] = Array("index.php?module=SecurityGroups&action=ListView&return_module=SecurityGroups&return_action=ListView", $sg_mod_strings['LBL_LIST_FORM_TITLE'],"SecurityGroups");

if(is_admin($current_user)) {
	global $current_language;
	$admin_mod_strings = return_module_language($current_language, 'Administration');
	//$module_menu[] = Array("index.php?module=Users&action=index&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_MANAGE_USERS_TITLE'],"Users");
	$module_menu[] = Array("index.php?module=ACLRoles&action=index&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_MANAGE_ROLES_TITLE'],"ACLRoles");
	$module_menu[] = Array("index.php?module=SecurityGroups&action=config&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_CONFIG_SECURITYGROUPS_TITLE'],"SecurityGroups");
	

}

?>