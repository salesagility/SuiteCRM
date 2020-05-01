<?php

$module_name = 'AOR_Scheduled_Reports';
$_object_name = 'aor_scheduled_reports';
$viewdefs[$module_name] =
[
    'QuickCreate' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'SAVE',
                    1 => 'CANCEL',
                ],
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
            'includes' => [
            ],
            'useTabs' => false,
            'tabDefs' => [
                'LBL_SCHEDULED_REPORTS_INFORMATION' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'lbl_scheduled_reports_information' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'displayParams' => [
                            'required' => true,
                        ],
                    ],
                    1 => 'status',
                ],
                1 => [
                    0 => [
                        'name' => 'aor_report_name',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'schedule',
                        'label' => 'LBL_SCHEDULE',
                    ],
                ],
                3 => [
                    0 => 'email1',
                ],
            ],
        ],
    ],
];
