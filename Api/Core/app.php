<?php
// @codingStandardsIgnoreStart
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
// @codingStandardsIgnoreEnd

chdir(__DIR__. '/../../');
require_once __DIR__. '/../../include/entryPoint.php';

$app = new \Slim\App(\Api\Core\Loader\ContainerLoader::getInstance());

\Api\Core\Loader\RouteLoader::configureRoutes($app);
\Api\Core\Loader\MiddlewareLoader::configureMiddleware($app, __DIR__ . '/../V8/Config/middleware.php');
