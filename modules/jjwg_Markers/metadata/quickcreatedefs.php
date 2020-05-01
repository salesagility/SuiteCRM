<?php

$module_name = 'jjwg_Markers';
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
                        'name' => 'jjwg_maps_lat',
                        'label' => 'LBL_JJWG_MAPS_LAT',
                    ],
                    1 => [
                        'name' => 'jjwg_maps_lng',
                        'label' => 'LBL_JJWG_MAPS_LNG',
                    ],
                ],
                2 => [
                    0 => '',
                    1 => [
                        'name' => 'marker_image',
                        'studio' => 'visible',
                        'label' => 'LBL_MARKER_IMAGE',
                    ],
                ],
            ],
        ],
    ],
];
