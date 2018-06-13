<?php
// @codingStandardsIgnoreStart
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
// @codingStandardsIgnoreEnd

chdir(__DIR__ . '/../../');
require_once __DIR__ . '/../../include/entryPoint.php';

$slimSettings = require __DIR__ . '/Config/slim.php';
$container = new \Slim\Container($slimSettings);
\Api\Core\Loader\ContainerLoader::configure($container);
$app = new \Slim\App($container);

$loader = new \Api\Core\Loader\RouteLoader();
$loader->configureRoutes($app);
