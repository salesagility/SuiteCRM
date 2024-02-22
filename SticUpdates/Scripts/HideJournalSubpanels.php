<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * It is important that all the code included in this file can be executed in different updates, 
 * incorporating new operations, such as making new modules available. 
 **/

 $GLOBALS['log']->debug(__METHOD__.'('.__LINE__.') Starting script remove subpanel form module xxx');

// HIDE MODULES FROM SUBPANELS IF MODULE IS NOT ENABLED ON THE MENU

// Set modules to hide
$modulesToHide = array(
    0 => 'stic_Journal',
);

require_once 'modules/MySettings/TabController.php';
$controller = new TabController();
$currentTabs = $controller->get_system_tabs();

$GLOBALS['log']->debug(__METHOD__.'('.__LINE__.') hide stic_Journal subpanel', $currentTabs);

$modulesToHideNotEnabled = array_diff($modulesToHide, $currentTabs);
$GLOBALS['log']->debug(__METHOD__.'('.__LINE__.') hide stic_Journal subpanel', $modulesToHideNotEnabled);
if (count($modulesToHideNotEnabled)> 0){
    // This function needs to be customized if the file is copied.
    function sticJournalPrepareElementToHide(&$item, $key)
    {
        $item = strtolower($item);
    }
    
    array_walk($modulesToHideNotEnabled, 'sticJournalPrepareElementToHide');
    
    $GLOBALS['log']->debug(__METHOD__.'('.__LINE__.') hide stic_Journal subpanel', $modulesToHideNotEnabled);
    
    $administration = new Administration();
    $currentSettings = $administration->retrieveSettings('MySettings');
    $unserialized = unserialize(base64_decode($currentSettings->settings['MySettings_hide_subpanels']));
    
    $GLOBALS['log']->debug(__METHOD__.'('.__LINE__.') hide stic_Journal subpanel', $unserialized);
    
    foreach($modulesToHideNotEnabled as $module) {
        $unserialized[$module] = $module;
    }
    
    $serialized = base64_encode(serialize($unserialized));
    $administration->saveSetting('MySettings', 'hide_subpanels', $serialized);

}



// Repairing and rebuilding
global $current_user;
$current_user = new User();
$current_user->getSystemUser();

// Reparación de roles para garantizar que los usuarios no administradores pueden acceder a los módulos
echo '<h3>Repairing roles</h3>';
require_once 'modules/ACL/install_actions.php';
$GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Repairing roles');

// Reparamos también relaciones e índices para evitar incidencias con los nuevos módulos
echo '<h3>Rebuilding relationships</h3>';
require_once 'modules/Administration/RebuildRelationship.php';
$GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Rebuilding relationships');

echo '<h3>Repairing indexes</h3>';
require_once "modules/Administration/RepairIndex.php";
$GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  Repairing indexes');

