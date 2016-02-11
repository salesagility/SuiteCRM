<?php
ini_set('display_errors', 1);
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
chdir('../../');
require_once('include/vendor/autoload.php');
require_once('include/entryPoint.php');

$_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"];
preg_match("#index.php\/([v,V]\d*)#", $_SERVER["PHP_SELF"], $matches);
$version = $matches[1];

//To get the jwt key
global $sugar_config;

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

$routeFiles = (array)glob('Api/' . $version . '/Route/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}

$container = $app->getContainer();
$container["jwt"] = function ($container) {
    return new StdClass;
};

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure" => false,
    "secret" => $sugar_config["JWT_SECRET"],
    "environment" => "REDIRECT_HTTP_AUTHORIZATION",
    "rules" => [
        new Slim\Middleware\JwtAuthentication\RequestPathRule([
            "path" => "/" . $version,
            "passthrough" => ["/" . $version . "/login", "/" . $version . "/token"]
        ]),
    ],
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    "error" => function ($request, $response, $arguments) use ($app) {
        return $response->write("Error");
    }
]));


$app->run();
