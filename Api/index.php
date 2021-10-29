<?php

global $legacyRoute;

if (isset($legacyRoute['script-name'], $legacyRoute['request-uri'])) {
    $_SERVER['SCRIPT_NAME'] = $legacyRoute['script-name'];
    $_SERVER['REQUEST_URI'] = $legacyRoute['request-uri'];
}

chdir('../');
require_once __DIR__ . '/Core/app.php';
$app->run();
