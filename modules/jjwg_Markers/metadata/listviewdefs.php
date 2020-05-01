<?php

$module_name = 'jjwg_Markers';
$listViewDefs[$module_name] =
[
    'NAME' => [
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ],
    'CITY' => [
        'type' => 'varchar',
        'label' => 'LBL_CITY',
        'width' => '10%',
        'default' => true,
    ],
    'STATE' => [
        'type' => 'varchar',
        'label' => 'LBL_STATE',
        'width' => '10%',
        'default' => true,
    ],
    'COUNTRY' => [
        'type' => 'varchar',
        'label' => 'LBL_COUNTRY',
        'width' => '10%',
        'default' => true,
    ],
    'JJWG_MAPS_LAT' => [
        'type' => 'decimal',
        'default' => true,
        'label' => 'LBL_JJWG_MAPS_LAT',
        'width' => '10%',
    ],
    'JJWG_MAPS_LNG' => [
        'type' => 'decimal',
        'default' => true,
        'label' => 'LBL_JJWG_MAPS_LNG',
        'width' => '10%',
    ],
    'MARKER_IMAGE' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MARKER_IMAGE',
        'sortable' => false,
        'width' => '10%',
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ],
    'DESCRIPTION' => [
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
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
    'DATE_ENTERED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ],
];
