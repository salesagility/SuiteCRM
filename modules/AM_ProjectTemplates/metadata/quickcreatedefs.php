<?php

$module_name = 'AM_ProjectTemplates';
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
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => [
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ],
                ],
                1 => [
                    0 => '',
                    1 => [
                        'name' => 'priority',
                        'studio' => 'visible',
                        'label' => 'LBL_PRIORITY',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'studio' => 'visible',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                    1 => '',
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => 'assigned_user_name',
                ],
            ],
        ],
    ],
];
