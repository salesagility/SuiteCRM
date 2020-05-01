<?php

$module_name = 'AOS_PDF_Templates';
$viewdefs[$module_name] =
    [
        'EditView' => [
            'templateMeta' => [
                'maxColumns' => '2',
                'widths' => [
                    0 => [
                        'label' => '10',
                        'field' => '60',
                    ],
                    1 => [
                        'label' => '10',
                        'field' => '30',
                    ],
                ],
                'includes' => [
                    0 => [
                        'file' => 'include/javascript/tiny_mce/tiny_mce.js',
                    ],
                    1 => [
                        'file' => 'modules/AOS_PDF_Templates/AOS_PDF_Templates.js',
                    ],
                ],
                'useTabs' => false,
                'tabDefs' => [
                    'DEFAULT' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                    'LBL_EDITVIEW_PANEL1' => [
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
                        1 => 'assigned_user_name',
                    ],
                    1 => [
                        0 => [
                            'name' => 'type',
                            'label' => 'LBL_TYPE',
                            'displayParams' => [
                                'field' => [
                                    'onchange' => 'populateModuleVariables(this.options[this.selectedIndex].value)',
                                ],
                            ],
                        ],
                        1 => [
                            'name' => 'sample',
                            'label' => 'LBL_SAMPLE',
                            'customCode' => '{$CUSTOM_SAMPLE}',
                        ],
                    ],
                    2 => [
                        0 => [
                            'name' => 'active',
                            'studio' => 'visible',
                            'label' => 'LBL_ACTIVE',
                        ],
                        1 => '',
                    ],
                    3 => [
                        0 => [
                            'name' => 'page_size',
                            'label' => 'LBL_PAGE_SIZE',
                        ],
                        1 => [
                            'name' => 'orientation',
                            'label' => 'LBL_ORIENTATION',
                        ],
                    ],
                    4 => [
                        0 => [
                            'name' => 'insert_fields',
                            'label' => 'LBL_INSERT_FIELDS',
                            'customCode' => '{$INSERT_FIELDS}',
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
                            'name' => 'pdfheader',
                            'label' => 'LBL_HEADER',
                        ],
                    ],
                    7 => [
                        0 => [
                            'name' => 'pdffooter',
                            'label' => 'LBL_FOOTER',
                        ],
                    ],
                ],
                'lbl_editview_panel1' => [
                    0 => [
                        0 => [
                            'name' => 'margin_left',
                            'label' => 'LBL_MARGIN_LEFT',
                        ],
                        1 => [
                            'name' => 'margin_right',
                            'label' => 'LBL_MARGIN_RIGHT',
                        ],
                    ],
                    1 => [
                        0 => [
                            'name' => 'margin_top',
                            'label' => 'LBL_MARGIN_TOP',
                        ],
                        1 => [
                            'name' => 'margin_bottom',
                            'label' => 'LBL_MARGIN_BOTTOM',
                        ],
                    ],
                    2 => [
                        0 => [
                            'name' => 'margin_header',
                            'label' => 'LBL_MARGIN_HEADER',
                        ],
                        1 => [
                            'name' => 'margin_footer',
                            'label' => 'LBL_MARGIN_FOOTER',
                        ],
                    ],
                ],
            ],
        ],
    ];
