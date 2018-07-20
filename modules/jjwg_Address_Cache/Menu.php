<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
 
if (ACLController::checkAccess('jjwg_Address_Cache', 'edit', true)) {
    $module_menu[]=array("index.php?module=jjwg_Address_Cache&action=EditView&return_module=jjwg_Address_Cache&return_action=DetailView", $GLOBALS['mod_strings']['LNK_NEW_RECORD'],"Createjjwg_Address_Cache", 'jjwg_Address_Cache');
}
if (ACLController::checkAccess('jjwg_Address_Cache', 'list', true)) {
    $module_menu[]=array("index.php?module=jjwg_Address_Cache&action=index&return_module=jjwg_Address_Cache&return_action=DetailView", $GLOBALS['mod_strings']['LNK_LIST'],"jjwg_Address_Cache", 'jjwg_Address_Cache');
}
if (ACLController::checkAccess('jjwg_Address_Cache', 'import', true)) {
    $module_menu[]=array("index.php?module=Import&action=Step1&import_module=jjwg_Address_Cache&return_module=jjwg_Address_Cache&return_action=index", $GLOBALS['app_strings']['LBL_IMPORT'],"Import", 'jjwg_Address_Cache');
}
