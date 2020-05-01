<?php

$popupMeta = [
    'moduleMain' => 'AOS_Products',
    'varName' => 'AOS_Products',
    'orderBy' => 'aos_products.name',
    'whereClauses' => [
        'name' => 'aos_products.name',
        'part_number' => 'aos_products.part_number',
        'cost' => 'aos_products.cost',
        'price' => 'aos_products.price',
        'created_by' => 'aos_products.created_by',
    ],
    'searchInputs' => [
        1 => 'name',
        4 => 'part_number',
        5 => 'cost',
        6 => 'price',
        7 => 'created_by',
    ],
    'searchdefs' => [
        'name' => [
            'name' => 'name',
            'width' => '10%',
        ],
        'part_number' => [
            'name' => 'part_number',
            'width' => '10%',
        ],
        'cost' => [
            'name' => 'cost',
            'width' => '10%',
        ],
        'price' => [
            'name' => 'price',
            'width' => '10%',
        ],
        'created_by' => [
            'name' => 'created_by',
            'label' => 'LBL_CREATED',
            'type' => 'enum',
            'function' => [
                'name' => 'get_user_array',
                'params' => [
                    0 => false,
                ],
            ],
            'width' => '10%',
        ],
    ],
    'listviewdefs' => [
        'NAME' => [
            'width' => '25%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'name' => 'name',
        ],
        'PART_NUMBER' => [
            'width' => '10%',
            'label' => 'LBL_PART_NUMBER',
            'default' => true,
            'name' => 'part_number',
        ],
        'COST' => [
            'width' => '10%',
            'label' => 'LBL_COST',
            'default' => true,
            'name' => 'cost',
        ],
        'PRICE' => [
            'width' => '10%',
            'label' => 'LBL_PRICE',
            'default' => true,
            'name' => 'price',
        ],
        'CURRENCY_ID' => [
            'type' => 'id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
            'width' => '10%',
            'default' => false,
            'name' => 'currency_id',
        ],
    ],
];
