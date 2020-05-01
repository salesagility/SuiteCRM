<?php

$module_name = 'AOS_Product_Categories';
$viewdefs[$module_name] =
    [
        'EditView' => [
            'templateMeta' => [
                'maxColumns' => '2',
                'widths' => [
                    0 => [
                        'label' => '10',
                        'field' => '30',
                    ],
                    1 => [
                        'label' => '10',
                        'field' => '30',
                    ],
                ],
                'useTabs' => false,
                'tabDefs' => [
                    'DEFAULT' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                ],
            ],
            'panels' => [
                'default' => [
                    0 => [
                        0 => 'name',
                        1 => 'assigned_user_name',
                    ],
                    1 => [
                        0 => 'description',
                        1 => [
                            'name' => 'parent_category_name',
                            'label' => 'LBL_PRODUCT_CATEGORYS_NAME',
                        ],
                    ],
                    2 => [
                        0 => [
                            'name' => 'is_parent',
                            'label' => 'LBL_IS_PARENT',
                        ],
                        1 => '',
                    ],
                ],
            ],
        ],
    ];
