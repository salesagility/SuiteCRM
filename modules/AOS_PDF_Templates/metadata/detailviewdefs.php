<?php

$module_name = 'AOS_PDF_Templates';
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
                'useTabs' => false,
                'tabDefs' => [
                    'DEFAULT' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                    'LBL_DETAILVIEW_PANEL1' => [
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
                        ],
                        1 => [
                            'name' => 'active',
                            'studio' => 'visible',
                            'label' => 'LBL_ACTIVE',
                        ],
                    ],
                    2 => [
                        0 => [
                            'name' => 'page_size',
                            'label' => 'LBL_PAGE_SIZE',
                        ],
                        1 => [
                            'name' => 'orientation',
                            'label' => 'LBL_ORIENTATION',
                        ],
                    ],
                    3 => [
                        0 => [
                            'name' => 'pdfheader',
                            'label' => 'LBL_HEADER',
                            'customCode' => '{$fields.pdfheader.value}',
                        ],
                    ],
                    4 => [
                        0 => [
                            'name' => 'description',
                            'label' => 'LBL_DESCRIPTION',
                            'customCode' => '{$fields.description.value}',
                        ],
                    ],
                    5 => [
                        0 => [
                            'name' => 'pdffooter',
                            'label' => 'LBL_FOOTER',
                            'customCode' => '{$fields.pdffooter.value}',
                        ],
                    ],
                ],
                'lbl_detailview_panel1' => [
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
