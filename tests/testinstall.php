<?php
$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    die('testinstall.php is CLI only.');
}

/* DEFINE SOME VARIABLES FOR INSTALLER */
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = 'install.php';
$_SERVER['SERVER_SOFTWARE'] = 'Apache';
$_SERVER['SERVER_NAME'] = 'travis';
$_SERVER['SERVER_PORT'] = '8080';

$_REQUEST['goto'] = 'SilentInstall';
$_REQUEST['cli'] = true;

// this will fix warning in modules/Users/Save.php:295 during installation
$_POST['email_reminder_checked'] = false;


try {
    ob_start();
    require_once 'install.php';
    ob_end_clean();
} catch(\Exception $e) {
    echo "\nINSTALLATION FAILED! file: " . $e->getFile() . ' - line: ' . $e->getLine()
        . "\n" . $e->getMessage()
        . "\n" . str_repeat('-', 120)
        . "\n" . print_r($e->getTrace(), true)
        . "\n" . str_repeat('-', 120)
        . "\n";
}
