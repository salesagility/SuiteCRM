<?php
$root = dirname(dirname(__DIR__));
$sugar_config = array();
// get config
if (!defined('sugarEntry') || !sugarEntry) {
    define('sugarEntry', true);
}
// config|_override.php
if (is_file($root . '/config.php')) {
    require_once $root . '/config.php';
}

if (is_file($root . '/config_override.php')) {
    require_once $root . '/config_override.php';
}

$GLOBALS['sugar_config'] = $sugar_config;
require_once $root . '/include/SugarObjects/SugarConfig.php';