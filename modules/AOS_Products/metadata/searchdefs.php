<?php

$module_name = 'AOS_Products';
$searchdefs[$module_name] =
[
    'layout' => [
        'basic_search' => [
            0 => 'name',
            1 => [
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
            ],
            'favorites_only' => ['name' => 'favorites_only', 'label' => 'LBL_FAVORITES_FILTER', 'type' => 'bool'],
        ],
        'advanced_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'part_number' => [
                'name' => 'part_number',
                'default' => true,
                'width' => '10%',
            ],
            'cost' => [
                'name' => 'cost',
                'default' => true,
                'width' => '10%',
            ],
            'price' => [
                'name' => 'price',
                'default' => true,
                'width' => '10%',
            ],
            'created_by' => [
                'name' => 'created_by',
                'label' => 'LBL_CREATED',
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
