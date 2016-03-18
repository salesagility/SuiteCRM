<?php

$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = 'install.php';
$_SERVER['SERVER_NAME'] = '';
$_SERVER['SERVER_PORT'] = '';

$_REQUEST = array(
    'goto' => 'SilentInstall',
    'cli' => true
);

require_once 'install.php';

