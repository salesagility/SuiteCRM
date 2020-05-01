<?php

$dashletData['OutboundEmailAccountsDashlet']['searchFields'] = [
    'date_entered' => [
        'default' => '',
    ],
    'date_modified' => [
        'default' => '',
    ],
    'assigned_user_id' => [
        'default' => '',
    ],
    'mail_smtpuser' => [
        'default' => '',
    ],
    'mail_smtpserver' => [
        'default' => '',
    ],
];
$dashletData['OutboundEmailAccountsDashlet']['columns'] = [
    'name' => [
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'date_entered' => [
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
        'name' => 'date_entered',
    ],
    'date_modified' => [
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ],
    'created_by' => [
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ],
    //  'assigned_user_name' =>
    //  array (
    //    'width' => '8%',
    //    'label' => 'LBL_LIST_ASSIGNED_USER',
    //    'name' => 'assigned_user_name',
    //    'default' => false,
    //  ),
    'mail_smtpuser' => [
        'type' => 'varchar',
        'label' => 'LBL_USERNAME',
        'width' => '10%',
        'default' => false,
    ],
    'mail_smtpserver' => [
        'type' => 'varchar',
        'label' => 'LBL_SMTP_SERVERNAME',
        'width' => '10%',
        'default' => false,
    ],
];
