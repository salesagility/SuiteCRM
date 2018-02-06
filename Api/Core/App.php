<?php
// @codingStandardsIgnoreStart
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
// @codingStandardsIgnoreEnd

chdir(__DIR__. '/../../');
require_once __DIR__. '/../../include/entryPoint.php';

$slimSettings = require __DIR__ . '/Config/slim.php';
$container = new \Slim\Container($slimSettings);
\Api\Core\Loaders\ContainerLoader::configureInstances($container);

$app = new \Slim\App($container);

\Api\Core\Loaders\RouteLoader::configureRoutes($app);
\Api\Core\Loaders\MiddlewareLoader::configureMiddleware($app, __DIR__ . '/../V8/Config/middleware.php');
