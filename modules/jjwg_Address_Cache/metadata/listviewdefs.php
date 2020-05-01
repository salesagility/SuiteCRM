<?php

$module_name = 'jjwg_Address_Cache';
$listViewDefs[$module_name] =
[
    'NAME' => [
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ],
    'LAT' => [
        'type' => 'decimal',
        'label' => 'LBL_LAT',
        'width' => '10%',
        'default' => true,
    ],
    'LNG' => [
        'type' => 'decimal',
        'label' => 'LBL_LNG',
        'width' => '10%',
        'default' => true,
    ],
    'DATE_ENTERED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ],
    'MODIFIED_BY_NAME' => [
        'type' => 'relate',
        'link' => 'modified_user_link',
        'label' => 'LBL_MODIFIED_NAME',
        'width' => '10%',
        'default' => false,
    ],
    'DATE_MODIFIED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ],
    'CREATED_BY_NAME' => [
        'type' => 'relate',
        'link' => 'created_by_link',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => false,
    ],
];
