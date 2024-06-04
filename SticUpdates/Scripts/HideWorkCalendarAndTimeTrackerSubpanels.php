<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

