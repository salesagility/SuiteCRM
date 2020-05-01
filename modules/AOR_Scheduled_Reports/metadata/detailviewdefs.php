<?php

$module_name = 'AOR_Scheduled_Reports';
$_object_name = 'aor_scheduled_reports';
$viewdefs[$module_name] =
    [
        'DetailView' => [
            'templateMeta' => [
                'form' => [
                    'buttons' => [
                        0 => 'EDIT',
                        1 => 'DUPLICATE',
                        2 => 'DELETE',
                        3 => 'FIND_DUPLICATES',
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
                'useTabs' => false,
                'tabDefs' => [
                    'LBL_SCHEDULED_REPORTS_INFORMATION' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                ],
                'syncDetailEditViews' => true,
            ],
            'panels' => [
                'lbl_scheduled_reports_information' => [
                    0 => [
                        0 => 'name',
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
                        1 => 'last_run',
                    ],
                    3 => [
                        0 => 'email_recipients',
                        1 => 'description',
                    ],
                ],
            ],
        ],
    ];
