<?php
// @codingStandardsIgnoreStart
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
// @codingStandardsIgnoreEnd

chdir(__DIR__. '/../../');
require_once __DIR__. '/../../include/entryPoint.php';

$settings = require __DIR__ . '/Config/slim.php';
$container = new \Slim\Container($settings);
\Api\Core\Configure\Container::configureRoutes($container);

$app = new \Slim\App($container);

\Api\Core\Configure\Route::configureRoutes($app);
\Api\Core\Configure\Middleware::configureMiddleware($app, __DIR__ . '/../V8/Config/middleware.php');
