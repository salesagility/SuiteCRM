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
 

if(ACLController::checkAccess('jjwg_Areas', 'edit', true)) $module_menu[]=Array("index.php?module=jjwg_Areas&action=EditView&return_module=jjwg_Areas&return_action=index", $GLOBALS['mod_strings']['LNK_NEW_RECORD'], "Create", 'jjwg_Areas');
if(ACLController::checkAccess('jjwg_Areas', 'list', true)) $module_menu[]=Array("index.php?module=jjwg_Areas&action=index&return_module=jjwg_Areas&return_action=DetailView", $GLOBALS['mod_strings']['LNK_LIST'], "List", 'jjwg_Areas');
if(ACLController::checkAccess('jjwg_Areas', 'import', true))$module_menu[]=Array("index.php?module=jjwg_Areas&action=Step1&import_module=jjwg_Areas&return_module=jjwg_Areas&return_action=index", $GLOBALS['app_strings']['LBL_IMPORT'],"Import", 'jjwg_Areas');
