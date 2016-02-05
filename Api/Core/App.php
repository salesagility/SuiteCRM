<?php
ini_set('display_errors',1);
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}
chdir('../../');
require_once('include/vendor/autoload.php');
require_once('include/entryPoint.php');

$_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"];

//TODO REMOVE THIS ONCE AUTHENTICATION IS DECIDED
$userId =1;

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

$routeFiles = (array)glob('Api/V*/Route/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}

$app->run();