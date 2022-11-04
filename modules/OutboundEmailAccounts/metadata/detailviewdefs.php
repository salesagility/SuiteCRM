<?php
$viewdefs ['OutboundEmailAccounts'] = [
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    2 => 'DELETE',
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
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_EDITVIEW_PANEL1' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => true,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                ],
            ],
            'lbl_editview_panel1' => [
                [
                    0 => [
                        'name' => 'smtp_from_name',
                        'label' => 'LBL_SMTP_FROM_NAME',
                    ],
                ],
                [
                    0 => [
                        'name' => 'smtp_from_addr',
                        'label' => 'LBL_SMTP_FROM_ADDR',
                    ],
                ],
                [
                    0 => [
                        'name' => 'mail_smtpserver',
                        'label' => 'LBL_SMTP_SERVERNAME',
                    ],
                    1 => [
                        'name' => 'mail_smtpport',
                        'label' => 'LBL_SMTP_PORT',
                    ],
                ],
                [
                    0 => [
                        'name' => 'mail_smtpauth_req',
                        'label' => 'LBL_SMTP_AUTH',
                    ],
                    1 => [
                        'name' => 'mail_smtpssl',
                        'studio' => 'visible',
                        'label' => 'LBL_SMTP_PROTOCOL',
                    ],
                ],
                [
                    [
                        'name' => 'mail_smtpuser',
                        'label' => 'LBL_USERNAME',
                    ],
                ],
            ],
        ],
    ],
];
