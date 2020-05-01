<?php

$popupMeta = [
    'moduleMain' => 'AM_ProjectTemplates',
    'varName' => 'AM_ProjectTemplates',
    'orderBy' => 'am_projecttemplates.name',
    'whereClauses' => [
        'name' => 'am_projecttemplates.name',
        'status' => 'am_projecttemplates.status',
        'priority' => 'am_projecttemplates.priority',
        'assigned_user_name' => 'am_projecttemplates.assigned_user_name',
    ],
    'searchInputs' => [
        1 => 'name',
        2 => 'priority',
        3 => 'status',
        4 => 'assigned_user_name',
    ],
    'searchdefs' => [
        'name' => [
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ],
        'status' => [
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'width' => '10%',
            'name' => 'status',
        ],
        'priority' => [
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_PRIORITY',
            'width' => '10%',
            'name' => 'priority',
        ],
        'assigned_user_name' => [
            'link' => true,
            'type' => 'relate',
            'studio' => 'visible',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ],
    ],
    'listviewdefs' => [
        'NAME' => [
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'default' => true,
        ],
        'ASSIGNED_USER_NAME' => [
            'link' => true,
            'type' => 'relate',
            'studio' => 'visible',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'default' => true,
        ],
        'STATUS' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'width' => '10%',
        ],
        'PRIORITY' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_PRIORITY',
            'width' => '10%',
        ],
    ],
];
