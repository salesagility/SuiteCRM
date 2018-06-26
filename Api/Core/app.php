<?php
// Swagger needs this, but should remove - CORS
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// @codingStandardsIgnoreStart
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
// @codingStandardsIgnoreEnd

chdir(__DIR__ . '/../../');
require_once __DIR__ . '/../../include/entryPoint.php';

$app = new \Slim\App(\Api\Core\Loader\ContainerLoader::configure());
// closure shouldn't be created in static context under PHP7
$routeLoader = new \Api\Core\Loader\RouteLoader();
$routeLoader->configureRoutes($app);
