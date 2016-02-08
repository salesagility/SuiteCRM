<?php
ini_set('display_errors',1);
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
chdir('../../');
require_once('include/vendor/autoload.php');
require_once('include/entryPoint.php');

$_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"];
echo $_SERVER["PHP_SELF"];
echo $_SERVER["REQUEST_URI"];

///SuiteCRM/Api/Public/index.php/V8/server_info
//echo($_SERVER["REQUEST_URI"]);

//preg_match("#/V#", $_SERVER["REQUEST_URI"], $matches);
preg_match("#index.php\/([v,V]\d*)#", $_SERVER["PHP_SELF"], $matches);

$version = $matches[1];
//echo $matches[1];
//echo count($matches);


//die();




//TODO REMOVE THIS ONCE AUTHENTICATION IS DECIDED
$userId =1;

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

$routeFiles = (array)glob('Api/V*/Route/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}


$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure"=>false,
    "secret" => "supersecretkeyyoushouldnotcommittogithub",
    "environment" => "REDIRECT_HTTP_AUTHORIZATION",
    "rules" => [
        new Slim\Middleware\JwtAuthentication\RequestPathRule([
            "path" => "/" . $version,
            "passthrough" => ["/" . $version ."/login"]
        ]),

    ]
]));

$app->run();
