<?php

$dashletData['ProjectDashlet']['searchFields'] = [
    'date_entered' => [
        'default' => '',
    ],
    'date_modified' => [
        'default' => '',
    ],
    'assigned_user_id' => [
        'type' => 'assigned_user_name',
        'default' => 'Administrator',
    ],
];
$dashletData['ProjectDashlet']['columns'] = [
    'name' => [
        'width' => '30%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'status' => [
        'type' => 'enum',
        'default' => true,
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'name' => 'status',
    ],
    'estimated_start_date' => [
        'type' => 'date',
        'label' => 'LBL_DATE_START',
        'width' => '10%',
        'default' => true,
        'name' => 'estimated_start_date',
    ],
    'assigned_user_name' => [
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ],
    'estimated_end_date' => [
        'type' => 'date',
        'label' => 'LBL_DATE_END',
        'width' => '10%',
        'default' => true,
        'name' => 'estimated_end_date',
    ],
    'date_modified' => [
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ],
    'date_entered' => [
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ],
    'created_by' => [
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ],
];
