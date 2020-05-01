<?php

$dashletData['AM_ProjectTemplatesDashlet']['searchFields'] = [
    'name' => [
        'default' => '',
    ],
    'assigned_user_name' => [
        'default' => '',
    ],
    'status' => [
        'default' => '',
    ],
    'priority' => [
        'default' => '',
    ],
    'date_entered' => [
        'default' => '',
    ],
    'date_modified' => [
        'default' => '',
    ],
    'assigned_user_id' => [
        'default' => '',
    ],
];
$dashletData['AM_ProjectTemplatesDashlet']['columns'] = [
    'name' => [
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'status' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'name' => 'status',
    ],
    'priority' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_PRIORITY',
        'width' => '10%',
        'name' => 'priority',
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
    'assigned_user_name' => [
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => false,
    ],
    'created_by' => [
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ],
];
