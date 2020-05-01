<?php

$module_name = 'TemplateSectionLine';
$viewdefs[$module_name] =
[
    'EditView' => [
        'templateMeta' => [
            'maxColumns' => '1',
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
            ],
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                ],
                1 => [
                    'name' => 'grp',
                    'label' => 'LBL_GRP',
                ],
                2 => [
                    'name' => 'ord',
                    'label' => 'LBL_ORD',
                ],
                3 => [
                    0 => 'description',
                ],
                4 => [
                    'name' => 'thumbnail',
                    'label' => 'LBL_THUMBNAIL',
                ],
            ],
        ],
    ],
];
