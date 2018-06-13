<?php

use Api\Core\Loader\ContainerLoader;
use Api\Core\Loader\RouteLoader;
use Slim\App;
use Slim\Container;

// @codingStandardsIgnoreStart
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
// @codingStandardsIgnoreEnd

chdir(__DIR__ . '/../../');
require_once __DIR__ . '/../../include/entryPoint.php';

$slimSettings = require __DIR__ . '/Config/slim.php';
$container = new Container($slimSettings);
ContainerLoader::configure($container);
$app = new App($container);

$loader = new RouteLoader();
$loader->configureRoutes($app);
