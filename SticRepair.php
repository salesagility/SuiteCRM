<?php
/*
 * Copyright 2013
 * Jeff Bickart
 * @bickart
 * jeff @ neposystems.com
 */

/* STIC info: this file is used in the context of repairing instances on CRM updating processes
 * When the script repair_instances is executed, the following actions are taken:
 * 1) This SticRepair.php file is copied in every instance
 * 2) The file is called through wget
 * 3) When the execution is finished, the file is deleted
 *
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

require_once 'include/entryPoint.php';
require_once 'modules/Administration/QuickRepairAndRebuild.php';

//Bug 27991 . Redirect to index.php if the request is not come from CLI.
// $sapi_type = php_sapi_name();
// if (substr($sapi_type, 0, 3) != 'cgi') {
//     global $sugar_config;
//     if (!empty($sugar_config['site_url'])) {
//         header("Location: " . $sugar_config['site_url'] . "/index.php");
//     } else {
//         sugar_die("Didn't find site url in your sugarcrm config file");
//     }
// }
//End of #27991

global $sugar_config, $current_user;

// For easier management, repair actions will be held in English
$sugar_config['default_language'] = 'en_US';
$current_language = 'en_US';

// Keep Administration module strings for later use in the repair and rebuild process
$mod_strings = return_module_language($current_language, 'Administration');

// Set a user with admin capabilities in order to exec the repair and rebuild process
$current_user = new User();
$current_user->getSystemUser();

$GLOBALS['log']->info('Remote repair by SinergiaCRM script');
$repair = new RepairAndClear();

// By default, SticRepair runs the detected SQLs and will display the output of the repair.
$autoExecute = isset($_REQUEST['autoExecute']) ? filter_var($_REQUEST['autoExecute'], FILTER_VALIDATE_BOOLEAN) : true;
$showOutput = isset($_REQUEST['showOutput']) ? filter_var($_REQUEST['showOutput'], FILTER_VALIDATE_BOOLEAN) : true;

// Execute more or less repair functions depending on the scope parameter. If no parameter is received, the clearAll option will be executed.
switch ($_REQUEST['scope']) {
    case 'updateInstances':
        $repair->repairAndClearAll(array('rebuildExtensions', 'rebuildAuditTables'), array(translate('LBL_ALL_MODULES')), $autoExecute, $showOutput);
        break;

    case 'onlyDatabase':
        $repair->repairAndClearAll(array(''), array(translate('LBL_ALL_MODULES')), $autoExecute, $showOutput);
        break;

    default:
        $repair->repairAndClearAll(array('clearAll'), array(translate('LBL_ALL_MODULES')), $autoExecute, $showOutput);
        break;
}

$exit_on_cleanup = true; 
sugar_cleanup(false);

// some jobs have annoying habit of calling sugar_cleanup(), and it can be called only once
// but job results can be written to DB after job is finished, so we have to disconnect here again
// just in case we couldn't call cleanup
if (class_exists('DBManagerFactory')) {
    $db = DBManagerFactory::getInstance();
    $db->disconnect();
}
if ($exit_on_cleanup) {
    exit;
}
