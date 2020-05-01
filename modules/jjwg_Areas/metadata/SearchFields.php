<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = 'jjwg_Areas';
$searchFields[$module_name] = [
    'name' => ['query_type' => 'default'],
    'current_user_only' => ['query_type' => 'default', 'db_field' => ['assigned_user_id'], 'my_items' => true, 'vname' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'],
    'assigned_user_id' => ['query_type' => 'default'],
];
