<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$dashletData['jjwg_Adress_CacheDashlet']['searchFields'] = ['date_entered' => ['default' => ''],
    'date_modified' => ['default' => ''],
    'assigned_user_id' => ['type' => 'assigned_user_name',
        'default' => $GLOBALS['current_user']->name]];
$dashletData['jjwg_Adress_CacheDashlet']['columns'] = ['name' => ['width' => '40',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true],
    'date_entered' => ['width' => '15',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true],
    'date_modified' => ['width' => '15',
        'label' => 'LBL_DATE_MODIFIED'],
    'created_by' => ['width' => '8',
        'label' => 'LBL_CREATED'],
    'assigned_user_name' => ['width' => '8',
        'label' => 'LBL_LIST_ASSIGNED_USER'],
];
