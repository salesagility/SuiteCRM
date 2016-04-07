<?php
/* DEFINE SOME VARIABLES FOR INSTALLER */
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = 'install.php';
$_SERVER["SERVER_SOFTWARE"] = 'Apache';
$_SERVER['SERVER_NAME'] = 'travis';
$_SERVER['SERVER_PORT'] = '80';

$_REQUEST['goto'] = 'SilentInstall';
$_REQUEST['cli'] = true;



try {
    ob_start();
    require_once 'install.php';
    ob_end_clean();
    echo "\ndone.\n";
} catch(\Exception $e) {
    echo "\nINSTALLATION FAILED! file: " . $e->getFile() . " - line: " . $e->getLine()
         . "\n" . $e->getMessage()
         . "\n" . str_repeat("-", 120)
         . "\n" . print_r($e->getTrace(), true)
         . "\n" . str_repeat("-", 120)
         . "\n";
    /*
     * Do some cleanup so we can relaunch
     */
    unlink("config.php");

}


