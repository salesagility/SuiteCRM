<?php

$module_name = 'jjwg_Maps';

$searchdefs[$module_name] =
[
    'layout' => [
        'basic_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'module_type' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MODULE_TYPE',
                'sortable' => false,
                'width' => '10%',
                'name' => 'module_type',
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
            'unit_type' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_UNIT_TYPE',
                'sortable' => false,
                'width' => '10%',
                'name' => 'unit_type',
            ],
            'distance' => [
                'type' => 'float',
                'label' => 'LBL_DISTANCE',
                'width' => '10%',
                'default' => true,
                'name' => 'distance',
            ],
            'module_type' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_MODULE_TYPE',
                'sortable' => false,
                'width' => '10%',
                'name' => 'module_type',
            ],
            'description' => [
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
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
