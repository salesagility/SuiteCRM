<?php

$module_name = 'jjwg_Areas';
$viewdefs[$module_name] =
[
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                ],
                // Csutom
                'footerTpl' => 'modules/jjwg_Areas/tpls/DetailViewFooter.tpl',
            ],
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
                        'name' => 'city',
                        'label' => 'LBL_CITY',
                    ],
                    1 => [
                        'name' => 'state',
                        'label' => 'LBL_STATE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'country',
                        'label' => 'LBL_COUNTRY',
                    ],
                    1 => '',
                ],
                3 => [
                    0 => [
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                        'label' => 'LBL_DATE_ENTERED',
                    ],
                    1 => [
                        'name' => 'date_modified',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                        'label' => 'LBL_DATE_MODIFIED',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'coordinates',
                        'studio' => 'visible',
                        'label' => 'LBL_COORDINATES',
                    ],
                ],
            ],
        ],
    ],
];
