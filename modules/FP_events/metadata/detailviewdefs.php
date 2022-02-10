<?php
$module_name = 'FP_events';
$viewdefs [$module_name] =
    array(
        'DetailView' =>
            array(
                'templateMeta' =>
                    array(
                        'form' =>
                            array(
                                'buttons' =>
                                    array(
                                        0 => 'EDIT',
                                        1 => 'DUPLICATE',
                                        2 => 'DELETE',
                                        3 => 'FIND_DUPLICATES',
                                    ),
                                'hidden' =>
                                    array(
                                        0 => '<input id="custom_hidden_1" type="hidden" name="custom_hidden_1" value=""/>',
                                        1 => '<input id="custom_hidden_2" type="hidden" name="custom_hidden_2" value=""/>',
                                    ),
                            ),
                        'maxColumns' => '2',
                        'includes' =>
                            array(
                                0 =>
                                    array(
                                        'file' => 'include/javascript/checkbox.js',
                                    ),
                                1 =>
                                    array(
                                        'file' => 'cache/include/javascript/sugar_grp_yui_widgets.js',
                                    ),
                            ),
                        'widths' =>
                            array(
                                0 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                                1 =>
                                    array(
                                        'label' => '10',
                                        'field' => '30',
                                    ),
                            ),
                        'useTabs' => true,
                        'tabDefs' =>
                            array(
                                'LBL_PANEL_OVERVIEW' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_EMAIL_INVITE' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_PANEL_ASSIGNMENT' =>
                                    array(
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                        'syncDetailEditViews' => true,
                    ),
                'panels' =>
                    array(
                        'LBL_PANEL_OVERVIEW' =>
                            array(
                                0 =>
                                    array(
                                        0 => 'name',
                                        1 =>
                                            array(
                                                'name' => 'fp_event_locations_fp_events_1_name',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_start',
                                                'comment' => 'Date of start of meeting',
                                                'label' => 'LBL_DATE',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_end',
                                                'comment' => 'Date meeting ends',
                                                'label' => 'LBL_DATE_END',
                                            ),
                                    ),
                                2 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'duration',
                                                'customCode' => '{$fields.duration_hours.value}{$MOD.LBL_HOURS_ABBREV} {$fields.duration_minutes.value}{$MOD.LBL_MINSS_ABBREV} ',
                                                'label' => 'LBL_DURATION',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'budget',
                                                'label' => 'LBL_BUDGET',
                                            ),
                                    ),
                                3 =>
                                    array(
                                        0 => 'description',
                                    ),
                                4 =>
                                    array(
                                        0 => 'assigned_user_name',
                                    ),
                            ),
                        'LBL_EMAIL_INVITE' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'invite_templates',
                                                'studio' => 'visible',
                                                'label' => 'LBL_INVITE_TEMPLATES',
                                            ),
                                    ),
                                1 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'accept_redirect',
                                                'label' => 'LBL_ACCEPT_REDIRECT',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'decline_redirect',
                                                'label' => 'LBL_DECLINE_REDIRECT',
                                            ),
                                    ),
                            ),
                        'LBL_PANEL_ASSIGNMENT' =>
                            array(
                                0 =>
                                    array(
                                        0 =>
                                            array(
                                                'name' => 'date_entered',
                                                'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                                                'label' => 'LBL_DATE_ENTERED',
                                            ),
                                        1 =>
                                            array(
                                                'name' => 'date_modified',
                                                'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                                                'label' => 'LBL_DATE_MODIFIED',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
