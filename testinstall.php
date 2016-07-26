<?php
/* DEFINE SOME VARIABLES FOR INSTALLER */
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = 'install.php';
$_SERVER["SERVER_SOFTWARE"] = 'Apache';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';
$_REQUEST['goto'] = 'SilentInstall';
$_REQUEST['cli'] = true;
// this will fix warning in modules/Users/Save.php:295 during installation
$_POST['email_reminder_checked'] = false;
try {
    /*
     * Do some cleanup so we can relaunch installer over and over again (we can get rid of this)
     */
    if(is_file("config.php")) {
        unlink("config.php");
    }
    ob_start();
    require_once 'install.php';
    ob_end_clean();
} catch(\Exception $e) {
    echo "\nINSTALLATION FAILED! file: " . $e->getFile() . " - line: " . $e->getLine()
        . "\n" . $e->getMessage()
        . "\n" . str_repeat("-", 120)
        . "\n" . print_r($e->getTrace(), true)
        . "\n" . str_repeat("-", 120)
        . "\n";
}
