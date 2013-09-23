<?php
$module_name = 'AOS_PDF_Templates';
$viewdefs [$module_name] =
    array (
        'DetailView' =>
        array (
            'templateMeta' =>
            array (
                'form' =>
                array (
                    'buttons' =>
                    array (
                        0 => 'EDIT',
                        1 => 'DUPLICATE',
                        2 => 'DELETE',
                    ),
                ),
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
                    'LBL_DETAILVIEW_PANEL1' =>
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
                        0 =>
                        array (
                            'name' => 'name',
                            'label' => 'LBL_NAME',
                        ),
                        1 => 'assigned_user_name',
                    ),
                    1 =>
                    array (
                        0 =>
                        array (
                            'name' => 'type',
                            'label' => 'LBL_TYPE',
                        ),
                        1 =>
                        array (
                            'name' => 'active',
                            'studio' => 'visible',
                            'label' => 'LBL_ACTIVE',
                        ),
                    ),
                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'pdfheader',
                            'label' => 'LBL_HEADER',
                            'customCode' => '{$fields.pdfheader.value}',
                        ),
                    ),
                    3 =>
                    array (
                        0 =>
                        array (
                            'name' => 'description',
                            'label' => 'LBL_DESCRIPTION',
                            'customCode' => '{$fields.description.value}',
                        ),
                    ),
                    4 =>
                    array (
                        0 =>
                        array (
                            'name' => 'pdffooter',
                            'label' => 'LBL_FOOTER',
                            'customCode' => '{$fields.pdffooter.value}',
                        ),
                    ),
                ),
                'lbl_detailview_panel1' =>
                array (
                    0 =>
                    array (
                        0 =>
                        array (
                            'name' => 'margin_left',
                            'label' => 'LBL_MARGIN_LEFT',
                        ),
                        1 =>
                        array (
                            'name' => 'margin_right',
                            'label' => 'LBL_MARGIN_RIGHT',
                        ),
                    ),
                    1 =>
                    array (
                        0 =>
                        array (
                            'name' => 'margin_top',
                            'label' => 'LBL_MARGIN_TOP',
                        ),
                        1 =>
                        array (
                            'name' => 'margin_bottom',
                            'label' => 'LBL_MARGIN_BOTTOM',
                        ),
                    ),
                    2 =>
                    array (
                        0 =>
                        array (
                            'name' => 'margin_header',
                            'label' => 'LBL_MARGIN_HEADER',
                        ),
                        1 =>
                        array (
                            'name' => 'margin_footer',
                            'label' => 'LBL_MARGIN_FOOTER',
                        ),
                    ),
                ),
            ),
        ),
    );
?>
