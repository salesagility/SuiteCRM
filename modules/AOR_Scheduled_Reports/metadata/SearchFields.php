<?php

// created: 2014-12-10 12:48:04
$searchFields['AOR_Scheduled_Reports'] = [
    'name' => [
        'query_type' => 'default',
    ],
    'account_type' => [
        'query_type' => 'default',
        'options' => 'account_type_dom',
        'template_var' => 'ACCOUNT_TYPE_OPTIONS',
    ],
    'industry' => [
        'query_type' => 'default',
        'options' => 'industry_dom',
        'template_var' => 'INDUSTRY_OPTIONS',
    ],
    'annual_revenue' => [
        'query_type' => 'default',
    ],
    'address_street' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'billing_address_street',
            1 => 'shipping_address_street',
        ],
    ],
    'address_city' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'billing_address_city',
            1 => 'shipping_address_city',
        ],
    ],
    'address_state' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'billing_address_state',
            1 => 'shipping_address_state',
        ],
    ],
    'address_postalcode' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'billing_address_postalcode',
            1 => 'shipping_address_postalcode',
        ],
    ],
    'address_country' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'billing_address_country',
            1 => 'shipping_address_country',
        ],
    ],
    'rating' => [
        'query_type' => 'default',
    ],
    'phone' => [
        'query_type' => 'default',
        'db_field' => [
            0 => 'phone_office',
        ],
    ],
    'email' => [
        'query_type' => 'default',
        'operator' => 'subquery',
        'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
        'db_field' => [
            0 => 'id',
        ],
        'vname' => 'LBL_ANY_EMAIL',
    ],
    'website' => [
        'query_type' => 'default',
    ],
    'ownership' => [
        'query_type' => 'default',
    ],
    'employees' => [
        'query_type' => 'default',
    ],
    'ticker_symbol' => [
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
];
