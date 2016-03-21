<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * This file is required from include/entryPoint.php at early stage
 * It's purpose is to require Devel core files and register the
 * shutdown function for statistics
 */
require_once('DevelTools.php');

if(DevelTools::checkIfEnabled()) {
    $GLOBALS['DevelTools'] = new DevelTools();
    register_shutdown_function([$GLOBALS['DevelTools'], 'shutdown']);
}
