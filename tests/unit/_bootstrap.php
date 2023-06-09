<?php
// Here you can initialize variables that will be available to your test
//echo "CWD:" . getcwd() . "\n";
chdir(__DIR__.'/../../');
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
    define('SUITE_PHPUNIT_RUNNER', true);
}
/* bootstrap composer's autoloader */
require_once __DIR__.'/../../vendor/autoload.php';
global $sugar_config, $db;

require_once __DIR__ .'/../../include/database/DBManagerFactory.php';

require_once __DIR__ .'/../../include/utils.php';
require_once __DIR__ .'/../../include/modules.php';
require_once __DIR__ .'/../../include/entryPoint.php';
$db = DBManagerFactory::getInstance();

// Load up the config.test.php file. This is used to define configuration values for the test environment.
$testConfig = [];

if (is_file(__DIR__ . '/../tests/config.test.php')) {
    require_once __DIR__ . '/../tests/config.test.php';
}

foreach (array_keys($testConfig) as $key) {
    if (isset($sugar_config[$key])) {
        $sugar_config[$key] = $testConfig[$key];
    } else {
        $sugar_config[] = $testConfig[$key];
    }
}

//Oddly entry point loads app_strings but not app_list_strings, manually do this here.
$GLOBALS['current_language'] = 'en_us';
$GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);

/* VERY BAD :-( - but for now at least tests are running */
$GLOBALS['sugar_config']['resource_management']['default_limit'] = 999999;
