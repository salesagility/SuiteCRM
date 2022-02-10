<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

if (ACLController::checkAccess('jjwg_Maps', 'edit', true)) {
    $module_menu[]=array("index.php?module=jjwg_Maps&action=EditView&return_module=jjwg_Maps&return_action=index", $GLOBALS['mod_strings']['LNK_NEW_MAP'], "Create", 'jjwg_Maps');
}
if (ACLController::checkAccess('jjwg_Maps', 'list', true)) {
    $module_menu[]=array("index.php?module=jjwg_Maps&action=index&return_module=jjwg_Maps&return_action=DetailView", $GLOBALS['mod_strings']['LNK_MAP_LIST'], "List_Maps", 'jjwg_Maps');
}
if (ACLController::checkAccess('jjwg_Maps', 'list', true)) {
    $module_menu[]=array("index.php?module=jjwg_Maps&action=quick_radius&return_module=jjwg_Maps&return_action=index", $GLOBALS['mod_strings']['LBL_MAP_QUICK_RADIUS'], "Quick_Radius_Map", 'jjwg_Maps');
}
if (ACLController::checkAccess('jjwg_Maps', 'import', true)) {
    $module_menu[]=array("index.php?module=Import&action=Step1&import_module=jjwg_Maps&return_module=jjwg_Maps&return_action=index", $GLOBALS['app_strings']['LBL_IMPORT'],"Import", 'jjwg_Maps');
}
