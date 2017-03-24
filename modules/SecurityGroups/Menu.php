<?php

if (!defined('sugarEntry') || !sugarEntry || !defined('SUGAR_ENTRY') || !SUGAR_ENTRY) {
    die('Not A Valid Entry Point');
}
if (defined('sugarEntry')) {
    $deprecatedMessage = 'sugarEntry is deprecated use SUGAR_ENTRY instead';
    if (isset($GLOBALS['log'])) {
        $GLOBALS['log']->deprecated($deprecatedMessage);
    } else {
        trigger_error($deprecatedMessage, E_USER_DEPRECATED);
    }
}


global $mod_strings;
$module_menu[] = Array("index.php?module=SecurityGroups&action=EditView&return_module=SecurityGroups&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"Create_Security_Group");

$module_menu[] = Array("index.php?module=SecurityGroups&action=ListView&return_module=SecurityGroups&return_action=ListView", $mod_strings['LBL_LIST_FORM_TITLE'],"Security_Groups");

//if admin http://localhost/sugar_52/index.php?module=SecurityGroups&action=config
global $current_user;
if(is_admin($current_user)) {
	global $current_language;
	$admin_mod_strings = return_module_language($current_language, 'Administration');
	$module_menu[] = Array("index.php?module=Users&action=index&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_MANAGE_USERS_TITLE'],"Create");
	$module_menu[] = Array("index.php?module=ACLRoles&action=index&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_MANAGE_ROLES_TITLE'],"Role_Management");
	$module_menu[] = Array("index.php?module=SecurityGroups&action=config&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_CONFIG_SECURITYGROUPS_TITLE'],"Security_Suite_Settings");
}
?>
