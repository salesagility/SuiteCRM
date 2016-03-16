<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings, $app_strings, $sugar_config;

$module_menu[] = Array(
    "index.php?module=Devel&action=index",
    $mod_strings['LNK_DEVEL'],
    "Requests",
    'Devel'
);
/*
$module_menu[] = Array(
    "index.php?module=Devel&action=configure",
    $mod_strings['LNK_DEVEL_CONFIG'],
    "Configure",
    'Devel'
);
*/
