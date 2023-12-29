<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * It is important that all the code included in this file can be executed in different updates, 
 * incorporating new operations, such as making new modules available. 
 **/

$GLOBALS['log']->info(__FILE__ . '(' . __LINE__ . ') >> Running FixPersonalEnvironmentModuleDisplay script');

// MAKE NEW MODULES AVAILABLE IN MAIN MENU

// Set modules to make available
$EPmodule = 'stic_Personal_Environment';

$ADmodules = array (
    0 => 'stic_Assessments',
    1 => 'stic_FollowUps',
    3 => 'stic_Goals',
);

include_once 'modules/MySettings/TabController.php';
$controller = new TabController();
$currentTabs = $controller->get_system_tabs();
$toAdd = true;
if (!in_array($EPmodule, $currentTabs)) {
    foreach ($ADmodules as $ADmodule) {
        if (!in_array($ADmodule, $currentTabs)) {
            $toAdd = false;
        }
    }
    if ($toAdd) {
        $currentTabs[$EPmodule] = $EPmodule;
    }
}
$controller->set_system_tabs($currentTabs);

// REPAIRING AND REBUILDING STUFF 

global $current_user;
$current_user = new User();
$current_user->getSystemUser();

echo '<h3>Repairing roles</h3>';
include('modules/ACL/install_actions.php');
$GLOBALS['log']->info(__FILE__ . '(' . __LINE__ . ') >> Repairing roles');

echo '<h3>Rebuilding relationships</h3>';
include('modules/Administration/RebuildRelationship.php');
$GLOBALS['log']->info(__FILE__ . '(' . __LINE__ . ') >> Rebuilding relationships');

echo '<h3>Repairing indexes</h3>';
include("modules/Administration/RepairIndex.php");
$GLOBALS['log']->info(__FILE__ . '(' . __LINE__ . ') >> Repairing indexes');
