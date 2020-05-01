<?php

$popupMeta = [
    'moduleMain' => 'jjwg_Adress_Cache',
    'varName' => 'jjwg_Adress_Cache',
    'orderBy' => 'jjwg_adress_cache.name',
    'whereClauses' => [
        'name' => 'jjwg_adress_cache.name',
        'lat' => 'jjwg_adress_cache.lat',
        'lng' => 'jjwg_adress_cache.lng',
        'date_entered' => 'jjwg_adress_cache.date_entered',
        'assigned_user_name' => 'jjwg_adress_cache.assigned_user_name',
    ],
    'searchInputs' => [
        1 => 'name',
        4 => 'lat',
        5 => 'lng',
        6 => 'date_entered',
        7 => 'assigned_user_name',
    ],
    'searchdefs' => [
        'name' => [
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ],
        'lat' => [
            'type' => 'decimal',
            'label' => 'LBL_LAT',
            'width' => '10%',
            'name' => 'lat',
        ],
        'lng' => [
            'type' => 'decimal',
            'label' => 'LBL_LNG',
            'width' => '10%',
            'name' => 'lng',
        ],
        'date_entered' => [
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'name' => 'date_entered',
        ],
        'assigned_user_name' => [
            'link' => 'assigned_user_link',
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ],
    ],
    'listviewdefs' => [
        'NAME' => [
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => '10%',
            'default' => true,
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
            'link' => 'assigned_user_link',
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'width' => '10%',
            'default' => true,
        ],
    ],
];
