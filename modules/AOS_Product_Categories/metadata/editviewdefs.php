<?php
$module_name = 'AOS_Product_Categories';
$viewdefs [$module_name] =
    array (
        'EditView' =>
        array (
            'templateMeta' =>
            array (
                'maxColumns' => '2',
                'widths' =>
                array (
                    0 =>
                    array (
                        'label' => '10',
                        'field' => '30',
                    ),
                    1 =>
                    array (
                        'label' => '10',
                        'field' => '30',
                    ),
                ),
                'useTabs' => false,
                'tabDefs' =>
                array (
                    'DEFAULT' =>
                    array (
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ),
                ),
            ),
            'panels' =>
            array (
                'default' =>
                array (
                    0 =>
                    array (
                        0 => 'name',
                        1 => 'assigned_user_name',
                    ),
                    1 =>
                    array (
                        0 => 'description',
                        1 =>
                        array (
                            'name' => 'parent_category_name',
                            'label' => 'LBL_PRODUCT_CATEGORYS_NAME',
                        ),
                    ),
                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'is_parent',
                            'label' => 'LBL_IS_PARENT',
                        ),
                        1 => '',
                    ),
                ),
            ),
        ),
    );
