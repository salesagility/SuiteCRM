<?php

$module_name = 'OutboundEmailAccounts';
$searchdefs[$module_name] =
[
    'layout' => [
        'basic_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'mail_smtpuser' => [
                'type' => 'varchar',
                'label' => 'LBL_USERNAME',
                'width' => '10%',
                'default' => true,
                'name' => 'mail_smtpuser',
            ],
            'mail_smtpserver' => [
                'type' => 'varchar',
                'label' => 'LBL_SMTP_SERVERNAME',
                'width' => '10%',
                'default' => true,
                'name' => 'mail_smtpserver',
            ],
            'current_user_only' => [
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ],
        ],
        'advanced_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'mail_smtpuser' => [
                'type' => 'varchar',
                'label' => 'LBL_USERNAME',
                'width' => '10%',
                'default' => true,
                'name' => 'mail_smtpuser',
            ],
            'mail_smtpserver' => [
                'type' => 'varchar',
                'label' => 'LBL_SMTP_SERVERNAME',
                'width' => '10%',
                'default' => true,
                'name' => 'mail_smtpserver',
            ],
            //      'description' =>
            //      array (
            //        'type' => 'text',
            //        'label' => 'LBL_DESCRIPTION',
            //        'sortable' => false,
            //        'width' => '10%',
            //        'default' => true,
            //        'name' => 'description',
            //      ),
            'assigned_user_id' => [
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => [
                    'name' => 'get_user_array',
                    'params' => [
                        0 => false,
                    ],
                ],
                'default' => true,
                'width' => '10%',
            ],
        ],
    ],
    'templateMeta' => [
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => [
            'label' => '10',
            'field' => '30',
        ],
    ],
];
