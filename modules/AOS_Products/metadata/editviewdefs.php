<?php

$module_name = 'AOS_Products';
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
            'form' => [
                'enctype' => 'multipart/form-data',
                'headerTpl' => 'modules/AOS_Products/tpls/EditViewHeader.tpl',
            ],
            'includes' => [
                0 => [
                    'file' => 'modules/AOS_Products/js/products.js',
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
                    0 => [
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'part_number',
                        'label' => 'LBL_PART_NUMBER',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'aos_product_category_name',
                        'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
                    ],
                    1 => [
                        'name' => 'type',
                        'label' => 'LBL_TYPE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'currency_id',
                        'studio' => 'visible',
                        'label' => 'LBL_CURRENCY',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'cost',
                        'label' => 'LBL_COST',
                    ],
                    1 => [
                        'name' => 'price',
                        'label' => 'LBL_PRICE',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'contact',
                        'label' => 'LBL_CONTACT',
                    ],
                    1 => [
                        'name' => 'url',
                        'label' => 'LBL_URL',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
                6 => [
                    0 => [
                        'name' => 'product_image',
                        'customCode' => '{$PRODUCT_IMAGE}',
                    ],
                ],
            ],
        ],
    ],
];
