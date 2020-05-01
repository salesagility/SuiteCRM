<?php

$dashletData['jjwg_MapsDashlet']['searchFields'] = [
    'name' => [
        'default' => '',
    ],
    'module_type' => [
        'default' => '',
    ],
    'date_entered' => [
        'default' => '',
    ],
    'date_modified' => [
        'default' => '',
    ],
];
$dashletData['jjwg_MapsDashlet']['columns'] = [
    'name' => [
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'module_type' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MODULE_TYPE',
        'sortable' => false,
        'width' => '10%',
    ],
    'distance' => [
        'type' => 'float',
        'label' => 'LBL_DISTANCE',
        'width' => '10%',
        'default' => true,
    ],
    'unit_type' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_UNIT_TYPE',
        'sortable' => false,
        'width' => '10%',
    ],
    'date_entered' => [
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
        'name' => 'date_entered',
    ],
    'parent_name' => [
        'type' => 'parent',
        'studio' => 'visible',
        'label' => 'LBL_FLEX_RELATE',
        'width' => '10%',
        'default' => false,
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
    'assigned_user_name' => [
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => false,
    ],
    'description' => [
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ],
];
