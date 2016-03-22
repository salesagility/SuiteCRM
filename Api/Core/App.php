<?php

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
chdir('../../');
require_once 'include/vendor/autoload.php';
require_once 'include/entryPoint.php';

preg_match("/\/Api\/(.*?)\//", $_SERVER['REQUEST_URI'], $matches);

$GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);

$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];

$version = $matches[1];

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

$routeFiles = (array) glob('Api/'.$version.'/Route/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}

$container = $app->getContainer();
$container['jwt'] = function ($container) {
    return new StdClass();
};

if ($_SERVER['REQUEST_METHOD'] != 'OPTIONS') {
    $app->add(new \Slim\Middleware\JwtAuthentication([
        'secure' => false,
        'secret' => $sugar_config['unique_key'],
        'environment' => 'REDIRECT_HTTP_AUTHORIZATION',
        'rules' => [
            new Slim\Middleware\JwtAuthentication\RequestPathRule([
                'path' => '/'.$version,
                'passthrough' => ['/'.$version.'/login', '/'.$version.'/token'],
            ]),
        ],
        'callback' => function ($request, $response, $arguments) use ($container) {
            $container['jwt'] = $arguments['decoded'];
        },
        'error' => function ($request, $response, $arguments) use ($app) {
            return $response->write('Authentication Failed');
        },
    ]));
}

$app->run();
