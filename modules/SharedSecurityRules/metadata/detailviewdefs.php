<?php
$module_name = 'SharedSecurityRules';
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
                                        3 => 'FIND_DUPLICATES',
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
                                        1 =>
                                            array (
                                                'name' => 'status',
                                                'studio' => 'visible',
                                                'label' => 'LBL_STATUS',
                                            ),
                                    ),
                                2 =>
                                    array (
                                        0 => 'description',
                                    ),
                            ),
                        'lbl_editview_panel2' =>
                            array (
                                0 =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'condition_lines',
                                                'label' => 'LBL_CONDITION_LINES',
                                            ),
                                    ),
                            ),
                        'lbl_editview_panel1' =>
                            array (
                                0 =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'action_lines',
                                                'label' => 'LBL_ACTION_LINES',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
?>
