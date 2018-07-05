<?php
$module_name = 'SharedSecurityRules';
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
                                'LBL_EDITVIEW_PANEL2' =>
                                    array (
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_EDITVIEW_PANEL1' =>
                                    array (
                                        'newTab' => false,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                   //     'includes' =>
                   //         array (
                  //              0 =>
                  //                  array (
                  //                      'file' => 'custom/modules/AOR_Reports/preview.js',
                  //                  ),
                  //          ),
                        'form' =>
                            array (
                                'headerTpl' => 'modules/SharedSecurityRules/tpls/EditViewHeader.tpl',
                                'footerTpl' => 'modules/SharedSecurityRules/tpls/EditViewFooter.tpl',
                                'buttons' =>
                                    array (
                                        0 => 'SAVE',
                                        1 => 'CANCEL',
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
                                        0 =>
                                            array (
                                                'name' => 'flow_module',
                                                'studio' => 'visible',
                                                'label' => 'LBL_FLOW_MODULE',
                                            ),
                                        1 => 'status',
                                    ),
                                2 => array(
                                   0 => 'run'
                                ),
                                3 =>
                                    array (
                                        0 => 'description',
                                    ),
                            ),
                        'lbl_editview_panel2' =>
                            array (
                                0 =>
                                    array (
                                        0 => 'condition_lines',
                                    ),
                            ),
                        'lbl_editview_panel1' =>
                            array (
                                0 =>
                                    array (
                                        0 => 'action_lines',
                                    ),
                            ),
                    ),
            ),
    );
?>
