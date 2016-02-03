<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
chdir('../../../');

require_once('include/vendor/autoload.php');
require_once('include/entryPoint.php');

$_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"];

//TODO REMOVE THIS ONCE AUTHENTICATION IS DECIDED
$userId =1;

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
$app->get('/{module_name}', 'SuiteCRM\Controller\ModuleController:getModuleRecords');

$app->run();