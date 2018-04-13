<?php

include_once __DIR__ . '/../vendor/autoload.php';


$stateChecker = new \SuiteCRM\StateChecker();
$hash = $stateChecker->getStateHash();
file_put_contents('state.hash', $hash);
exit(1);
