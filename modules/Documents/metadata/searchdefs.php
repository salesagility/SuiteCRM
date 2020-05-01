<?php

$searchdefs['Documents'] =
[
    'layout' => [
        'basic_search' => [
            0 => 'document_name',
            1 => ['name' => 'favorites_only', 'label' => 'LBL_FAVORITES_FILTER', 'type' => 'bool'],
        ],
        'advanced_search' => [
            'document_name' => [
                'name' => 'document_name',
                'default' => true,
                'width' => '10%',
            ],
            'status' => [
                'type' => 'varchar',
                'label' => 'LBL_DOC_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ],
            'template_type' => [
                'type' => 'enum',
                'label' => 'LBL_TEMPLATE_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'template_type',
            ],
            'category_id' => [
                'name' => 'category_id',
                'default' => true,
                'width' => '10%',
            ],
            'subcategory_id' => [
                'name' => 'subcategory_id',
                'default' => true,
                'width' => '10%',
            ],
            'assigned_user_id' => [
                'name' => 'assigned_user_id',
                'type' => 'enum',
                'label' => 'LBL_ASSIGNED_TO',
                'function' => [
                    'name' => 'get_user_array',
                    'params' => [
                        0 => false,
                    ],
                ],
                'default' => true,
                'width' => '10%',
            ],
            'active_date' => [
                'name' => 'active_date',
                'default' => true,
                'width' => '10%',
            ],
            'exp_date' => [
                'name' => 'exp_date',
                'default' => true,
                'width' => '10%',
            ],
        ],
    ],
    'templateMeta' => [
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => [
            'label' => '10',
            'field' => '30',
        ],
    ],
];
