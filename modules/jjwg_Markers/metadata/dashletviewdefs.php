<?php

$dashletData['jjwg_MarkersDashlet']['searchFields'] = [
    'name' => [
        'default' => '',
    ],
    'city' => [
        'default' => '',
    ],
    'state' => [
        'default' => '',
    ],
    'country' => [
        'default' => '',
    ],
    'assigned_user_name' => [
        'default' => '',
    ],
    'date_entered' => [
        'default' => '',
    ],
];
$dashletData['jjwg_MarkersDashlet']['columns'] = [
    'name' => [
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'city' => [
        'type' => 'varchar',
        'label' => 'LBL_CITY',
        'width' => '10%',
        'default' => true,
        'name' => 'city',
    ],
    'state' => [
        'type' => 'varchar',
        'label' => 'LBL_STATE',
        'width' => '10%',
        'default' => true,
        'name' => 'state',
    ],
    'country' => [
        'type' => 'varchar',
        'label' => 'LBL_COUNTRY',
        'width' => '10%',
        'default' => true,
        'name' => 'country',
    ],
    'marker_image' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MARKER_IMAGE',
        'sortable' => false,
        'width' => '10%',
        'name' => 'marker_image',
    ],
    'assigned_user_name' => [
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ],
    'jjwg_maps_lng' => [
        'type' => 'decimal',
        'default' => false,
        'label' => 'LBL_JJWG_MAPS_LNG',
        'width' => '10%',
        'name' => 'jjwg_maps_lng',
    ],
    'jjwg_maps_lat' => [
        'type' => 'decimal',
        'default' => false,
        'label' => 'LBL_JJWG_MAPS_LAT',
        'width' => '10%',
        'name' => 'jjwg_maps_lat',
    ],
    'date_entered' => [
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ],
    'created_by_name' => [
        'type' => 'relate',
        'link' => 'created_by_link',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => false,
        'name' => 'created_by_name',
    ],
    'modified_by_name' => [
        'type' => 'relate',
        'link' => 'modified_user_link',
        'label' => 'LBL_MODIFIED_NAME',
        'width' => '10%',
        'default' => false,
        'name' => 'modified_by_name',
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
    'description' => [
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'description',
    ],
];
