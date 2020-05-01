<?php

$module_name = 'jjwg_Address_Cache';
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
                        'name' => 'lat',
                        'label' => 'LBL_LAT',
                    ],
                    1 => [
                        'name' => 'lng',
                        'label' => 'LBL_LNG',
                    ],
                ],
            ],
        ],
    ],
];
