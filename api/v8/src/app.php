<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
chdir('../../../');

require_once('include/vendor/autoload.php');
require_once('include/entryPoint.php');

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

/**
 * Location for custom Routes
 */

if(file_exists('custom/application/Ext/Api/custom_routes.ext.php')){
    require 'custom/application/Ext/Api/custom_routes.ext.php';
}

$routeFiles = (array)glob('api/v8/src/Routing/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}

$app->run();