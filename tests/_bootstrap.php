<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', TRUE);
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
        /*
         * Do some cleanup so we can relaunch installer over and over again (we can get rid of this)
         */
        if (is_file(__DIR__ ."/../config.php")) {
            unlink(__DIR__ ."/../config.php");
        }
        ob_start();
        require_once __DIR__ .'/../install.php';
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
// Set up autoloading and bootstrap SuiteCRM test suite

/* bootstrap composer's autoloader */
require_once __DIR__.'/../vendor/autoload.php';
global $sugar_config, $db;
require_once __DIR__ .'/../include/utils.php';
require_once __DIR__ .'/../include/modules.php';
require_once __DIR__ .'/../include/entryPoint.php';
//Oddly entry point loads app_strings but not app_list_strings, manually do this here.
$GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);

/* VERY BAD :-( - but for now at least tests are running */
$GLOBALS['sugar_config']['resource_management']['default_limit'] = 999999;



