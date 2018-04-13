<?php

include_once __DIR__ . '/../vendor/autoload.php';

echo "Saving State Hash before tests..\n";

$stateChecker = new \SuiteCRM\StateChecker();
$hash = $stateChecker->getStateHash();
file_put_contents('state.hash', $hash);
exit(1);
