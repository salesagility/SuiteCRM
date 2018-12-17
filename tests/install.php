<?php
$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    die("install.php is CLI only.");
}


if (!defined('sugarEntry')) {
    define('sugarEntry', true);
    define('SUITE_PHPUNIT_RUNNER', true);
    // This is global bootstrap for autoloading
    // get silent config
    $file_config = file_get_contents(__DIR__ . '/travis_config_si.php');
    $write_config = file_put_contents(__DIR__ . '/../config_si.php', $file_config);

    if ($write_config === false) {
        throw new Exception('Unable to copy silent config file');
    }

    // Install db
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
        ob_start();
        require_once __DIR__ . '/../install.php';
        ob_end_clean();
    } catch (\Exception $e) {
        echo "\nINSTALLATION FAILED! file: " . $e->getFile() . " - line: " . $e->getLine()
            . "\n" . $e->getMessage()
            . "\n" . str_repeat("-", 120)
            . "\n" . print_r($e->getTrace(), true)
            . "\n" . str_repeat("-", 120)
            . "\n";
    }
}
