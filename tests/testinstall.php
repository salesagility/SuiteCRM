<?php

$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = 'install.php';
$_SERVER['SERVER_NAME'] = '';
$_SERVER['SERVER_PORT'] = '';

$_REQUEST = array(
    'goto' => 'SilentInstall',
    'cli' => TRUE
);


try {
    ob_start();
    require_once 'install.php';
    ob_end_clean();
    echo "\ndone.\n";
} catch(\Exception $e) {
    echo "\nINSTALLATION FAILED!"
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


