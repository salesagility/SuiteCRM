<?php

$module_name = 'AOS_Product_Categories';
$viewdefs[$module_name] =
[
    'DetailView' => [
        'templateMeta' => [
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
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
            'useTabs' => true,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => true,
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
                    0 => 'date_entered',
                    1 => 'date_modified',
                ],
                2 => [
                    0 => 'description',
                    1 => [
                        'name' => 'parent_category_name',
                        'label' => 'LBL_PRODUCT_CATEGORYS_NAME',
                    ],
                ],
                3 => [
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
