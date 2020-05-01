<?php

$module_name = 'jjwg_Maps';

$viewdefs[$module_name] =
[
    'QuickCreate' => [
        'templateMeta' => [
            'maxColumns' => '2',
            'widths' => [
                0 => [
                    'label' => '10',
                    'field' => '30',
                ],
                1 => [
                    'label' => '10',
                    'field' => '30',
                ],
            ],
            'useTabs' => false,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'parent_name',
                        'studio' => 'visible',
                        'label' => 'LBL_FLEX_RELATE',
                    ],
                    1 => [
                        'name' => 'unit_type',
                        'studio' => 'visible',
                        'label' => 'LBL_UNIT_TYPE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'module_type',
                        'studio' => 'visible',
                        'label' => 'LBL_MODULE_TYPE',
                    ],
                    1 => [
                        'name' => 'distance',
                        'label' => 'LBL_DISTANCE',
                    ],
                ],
            ],
        ],
    ],
];
