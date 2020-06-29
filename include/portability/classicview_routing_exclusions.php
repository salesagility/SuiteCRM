<?php

$classicview_routing_exclusions = [
    'any' => [
        'ShowDuplicates'
    ],
    'Administration' => [
        'UpgradeWizard_prepare',
        'UpgradeWizard_commit'
    ]
];

if (file_exists('custom/application/Ext/ClassicViewRoutingExclusions/classicview_routing_exclusions.ext.php')) {
    /* @noinspection PhpIncludeInspection */
    include('custom/application/Ext/ClassicViewRoutingExclusions/classicview_routing_exclusions.ext.php');
}
