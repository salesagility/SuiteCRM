<?php

// created: 2015-02-17 15:21:07
$searchFields['FP_events'] = [
    'name' => [
        'query_type' => 'default',
    ],
    'current_user_only' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'assigned_user_id',
        ],
        'my_items' => true,
        'vname' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
    ],
    'assigned_user_id' => [
        'query_type' => 'default',
    ],
    'range_date_entered' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'start_range_date_entered' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'end_range_date_entered' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'range_date_modified' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'start_range_date_modified' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'end_range_date_modified' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'range_date_start' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'start_range_date_start' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'end_range_date_start' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'range_date_end' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'start_range_date_end' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
    'end_range_date_end' => [
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ],
];
