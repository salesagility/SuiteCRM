<?php

$module_name = 'AOS_Products_Quotes';
$viewdefs[$module_name] =
[
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                ],
            ],
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
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'product_qty',
                        'label' => 'LBL_PRODUCT_QTY',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'product_cost_price',
                        'label' => 'LBL_PRODUCT_COST_PRICE',
                    ],
                    1 => [
                        'name' => 'product_list_price',
                        'label' => 'LBL_PRODUCT_LIST_PRICE',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'product_unit_price',
                        'label' => 'LBL_PRODUCT_UNIT_PRICE',
                    ],
                    1 => [
                        'name' => 'vat',
                        'label' => 'LBL_VAT',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'vat_amt',
                        'label' => 'LBL_VAT_AMT',
                    ],
                    1 => [
                        'name' => 'product_total_price',
                        'label' => 'LBL_PRODUCT_TOTAL_PRICE',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'product',
                        'label' => 'LBL_PRODUCT',
                    ],
                    1 => [
                        'name' => 'parent_name',
                        'label' => 'LBL_FLEX_RELATE',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'description',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
            ],
        ],
    ],
];
