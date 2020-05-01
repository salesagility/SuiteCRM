<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'SecurityGroups';
$searchFields[$module_name] =
    [
        'name' => ['query_type' => 'default'],
        'current_user_only' => ['query_type' => 'default', 'db_field' => ['assigned_user_id'], 'my_items' => true],
        'assigned_user_id' => ['query_type' => 'default'],
    ];
