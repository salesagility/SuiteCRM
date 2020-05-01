<?php

$module_name = 'OutboundEmailAccounts';
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
                    //1 => 'assigned_user_name',
                ],
                //        1 =>
                //        array (
                //          0 => 'description',
                //        ),
            ],
            'lbl_editview_panel1' => [
                0 => [
                    0 => [
                        'name' => 'mail_smtpuser',
                        'label' => 'LBL_USERNAME',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'mail_smtpserver',
                        'label' => 'LBL_SMTP_SERVERNAME',
                    ],
                    1 => [
                        'name' => 'mail_smtpport',
                        'label' => 'LBL_SMTP_PORT',
                    ],
                ],
                2 => [
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
            ],
        ],
    ],
];
