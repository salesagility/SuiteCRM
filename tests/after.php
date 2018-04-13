<?php

include_once __DIR__ . '/../vendor/autoload.php';

echo "Checkin State Hash after tests..\n";

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$stateChecker = new \SuiteCRM\StateChecker();
$afterhash = $stateChecker->getStateHash();
$beforeHash = file_get_contents('state.hash');

if($afterhash != $beforeHash) {
    echo 'Error: STATE DOESNT MATCH!';
    exit(1);
}

exit(1);
