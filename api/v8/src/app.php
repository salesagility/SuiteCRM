<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
ini_set('display_errors', 1);
chdir('../../../');

require_once('include/vendor/autoload.php');
require_once('include/entryPoint.php');

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

/**
 * Location for custom Routes
 */

if(file_exists('custom/application/Ext/api/api.ext.php')){
    require 'custom/application/Ext/api/api.ext.php';
}

$routeFiles = (array)glob('api/v8/src/routing/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}


$app->run();