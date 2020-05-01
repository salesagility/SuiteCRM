<?php

$popupMeta = [
    'moduleMain' => 'jjwg_Maps',
    'varName' => 'jjwg_Maps',
    'orderBy' => 'jjwg_maps.name',
    'whereClauses' => [
        'name' => 'jjwg_maps.name',
        'module_type' => 'jjwg_maps.module_type',
    ],
    'searchInputs' => [
        1 => 'name',
        4 => 'module_type',
    ],
    'searchdefs' => [
        'name' => [
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ],
        'module_type' => [
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_MODULE_TYPE',
            'sortable' => false,
            'width' => '10%',
            'name' => 'module_type',
        ],
    ],
    'listviewdefs' => [
        'NAME' => [
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => '10%',
            'default' => true,
        ],
        'MODULE_TYPE' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_MODULE_TYPE',
            'sortable' => false,
            'width' => '10%',
        ],
    ],
];
