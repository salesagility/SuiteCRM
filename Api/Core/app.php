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
\Api\Core\Loader\RouteLoader::configureRoutes($app);

//$app = new \Slim\App(\SuiteCRM\Container\Container::getInstance());

//$slimLoader = new \Api\Core\Loader\SlimLoader();
//$slimLoader->getContainer();

//$app = new \Slim\App($container);



//$slimSettings = require __DIR__ . '/Config/slim.php';
//$container = new \Slim\Container($slimSettings);
//\Api\Core\Loader\ContainerLoader::configure($container);
//$app = new \Slim\App($container);
//
//$routeLoader = new \Api\Core\Loader\RouteLoader();
//$routeLoader->configureRoutes($app);

//$app
