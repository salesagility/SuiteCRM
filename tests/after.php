<?php

include_once __DIR__ . '/../vendor/autoload.php';

$stateChecker = new \SuiteCRM\StateChecker();
$afterhash = $stateChecker->getStateHash();
$beforeHash = file_get_contents('state.hash');

if($afterhash != $beforeHash) {
    echo 'wrong!';
    exit(1);
}

exit(1);
