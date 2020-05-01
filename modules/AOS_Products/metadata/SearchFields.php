<?php

$searchFields['AOS_Products'] = [
    'name' => [
        'query_type' => 'default',
    ],
    'current_user_only' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'created_by',
        ],
        'my_items' => true,
        'vname' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
    ],
    'range_price' => [
        'query_type' => 'default',
        'enable_range_search' => true,
    ],
    'start_range_price' => [
        'query_type' => 'default',
        'enable_range_search' => true,
    ],
    'end_range_price' => [
        'query_type' => 'default',
        'enable_range_search' => true,
    ],
    'range_cost' => [
        'query_type' => 'default',
        'enable_range_search' => true,
    ],
    'start_range_cost' => [
        'query_type' => 'default',
        'enable_range_search' => true,
    ],
    'end_range_cost' => [
        'query_type' => 'default',
        'enable_range_search' => true,
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
    'favorites_only' => [
        'query_type' => 'format',
        'operator' => 'subquery',
        'checked_only' => true,
        'subquery' => "SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = 'AOS_Products'
			                        and favorites.assigned_user_id = '{1}'",
        'db_field' => ['id']],
];
