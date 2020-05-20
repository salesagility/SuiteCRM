<?php

$classicview_routing_exclusions = [
    'any' => [
        'ShowDuplicates'
    ]
];

if (file_exists('custom/application/Ext/ClassicViewRoutingExclusions/classicview_routing_exclusions.ext.php')) {
    /* @noinspection PhpIncludeInspection */
    include('custom/application/Ext/ClassicViewRoutingExclusions/classicview_routing_exclusions.ext.php');
}
