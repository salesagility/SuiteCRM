<?php

$module_name = 'jjwg_Address_Cache';
$searchdefs[$module_name] =
[
    'layout' => [
        'basic_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'current_user_only' => [
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ],
        ],
        'advanced_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'lat' => [
                'type' => 'decimal',
                'label' => 'LBL_LAT',
                'width' => '10%',
                'default' => true,
                'name' => 'lat',
            ],
            'lng' => [
                'type' => 'decimal',
                'label' => 'LBL_LNG',
                'width' => '10%',
                'default' => true,
                'name' => 'lng',
            ],
            'assigned_user_id' => [
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => [
                    'name' => 'get_user_array',
                    'params' => [
                        0 => false,
                    ],
                ],
                'default' => true,
                'width' => '10%',
            ],
        ],
    ],
    'templateMeta' => [
        'maxColumns' => '3',
        'widths' => [
            'label' => '10',
            'field' => '30',
        ],
    ],
];
