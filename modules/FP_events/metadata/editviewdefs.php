<?php
$module_name = 'FP_events';
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
                        'useTabs' => true,
                        'tabDefs' =>
                            array (
                                'LBL_PANEL_OVERVIEW' =>
                                    array (
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                                'LBL_EMAIL_INVITE' =>
                                    array (
                                        'newTab' => true,
                                        'panelDefault' => 'expanded',
                                    ),
                            ),
                        'syncDetailEditViews' => false,
                    ),
                'panels' =>
                    array (
                        'LBL_PANEL_OVERVIEW' =>
                            array (
                                0 =>
                                    array (
                                        0 => 'name',
                                        1 =>
                                            array (
                                                'name' => 'fp_event_locations_fp_events_1_name',
                                            ),
                                    ),
                                1 =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'date_start',
                                                'type' => 'datetimecombo',
                                                'displayParams' =>
                                                    array (
                                                        'required' => true,
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'name' => 'date_end',
                                                'type' => 'datetimecombo',
                                                'displayParams' =>
                                                    array (
                                                        'required' => true,
                                                    ),
                                            ),
                                    ),
                                2 =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'duration',
                                                'customCode' => '
                @@FIELD@@
                <input id="duration_hours" name="duration_hours" type="hidden" value="{$fields.duration_hours.value}">
                <input id="duration_minutes" name="duration_minutes" type="hidden" value="{$fields.duration_minutes.value}">
                {sugar_getscript file="modules/FP_events/duration_dependency.js"}
                <script type="text/javascript">
                    var date_time_format = "{$CALENDAR_FORMAT}";
                    {literal}
                    SUGAR.util.doWhen(function(){return typeof DurationDependency != "undefined" && typeof document.getElementById("duration") != "undefined"}, function(){
                        var duration_dependency = new DurationDependency("date_start","date_end","duration",date_time_format);
                        initEditView(YAHOO.util.Selector.query(\'select#duration\')[0].form);
                    });
                    {/literal}
                </script>            
            ',
                                                'customCodeReadOnly' => '{$fields.duration_hours.value}{$MOD.LBL_HOURS_ABBREV} {$fields.duration_minutes.value}{$MOD.LBL_MINSS_ABBREV} ',
                                            ),
                                        1 =>
                                            array (
                                                'name' => 'budget',
                                                'label' => 'LBL_BUDGET',
                                            ),
                                    ),
                                3 =>
                                    array (
                                        0 => 'description',
                                    ),
                                4 =>
                                    array (
                                        0 => 'assigned_user_name',
                                    ),
                            ),
                        'LBL_EMAIL_INVITE' =>
                            array (
                                0 =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'invite_templates',
                                                'studio' => 'visible',
                                                'label' => 'LBL_INVITE_TEMPLATES',
                                            ),
                                    ),
                                1 =>
                                    array (
                                        0 =>
                                            array (
                                                'name' => 'accept_redirect',
                                                'label' => 'LBL_ACCEPT_REDIRECT',
                                            ),
                                        1 =>
                                            array (
                                                'name' => 'decline_redirect',
                                                'label' => 'LBL_DECLINE_REDIRECT',
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
