<?php

$module_name = 'Favorites';
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
                'hidden' => [
                    0 => '<input id="custom_hidden_1" type="hidden" name="custom_hidden_1" value=""/>',
                    1 => '<input id="custom_hidden_2" type="hidden" name="custom_hidden_2" value=""/>',
                ],
            ],
            'maxColumns' => '2',
            'includes' => [
                0 => [
                    'file' => 'include/javascript/checkbox.js',
                ],
                1 => [
                    'file' => 'cache/include/javascript/sugar_grp_yui_widgets.js',
                ],
            ],
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
                'LBL_PANEL_OVERVIEW' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_EMAIL_INVITE' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_ASSIGNMENT' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => true,
        ],
        'panels' => [
            'LBL_PANEL_OVERVIEW' => [
                0 => [
                    0 => 'name',
                    1 => [
                        'name' => 'fp_event_locations_fp_events_1_name',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'date_start',
                        'comment' => 'Date of start of meeting',
                        'label' => 'LBL_DATE',
                    ],
                    1 => [
                        'name' => 'date_end',
                        'comment' => 'Date meeting ends',
                        'label' => 'LBL_DATE_END',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'duration',
                        'customCode' => '{$fields.duration_hours.value}{$MOD.LBL_HOURS_ABBREV} {$fields.duration_minutes.value}{$MOD.LBL_MINSS_ABBREV} ',
                        'label' => 'LBL_DURATION',
                    ],
                    1 => [
                        'name' => 'budget',
                        'label' => 'LBL_BUDGET',
                    ],
                ],
                3 => [
                    0 => 'description',
                ],
                4 => [
                    0 => 'assigned_user_name',
                ],
            ],
            'LBL_EMAIL_INVITE' => [
                0 => [
                    0 => [
                        'name' => 'invite_templates',
                        'studio' => 'visible',
                        'label' => 'LBL_INVITE_TEMPLATES',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'accept_redirect',
                        'label' => 'LBL_ACCEPT_REDIRECT',
                    ],
                    1 => [
                        'name' => 'decline_redirect',
                        'label' => 'LBL_DECLINE_REDIRECT',
                    ],
                ],
            ],
            'LBL_PANEL_ASSIGNMENT' => [
                0 => [
                    0 => [
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                        'label' => 'LBL_DATE_ENTERED',
                    ],
                    1 => [
                        'name' => 'date_modified',
                        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                        'label' => 'LBL_DATE_MODIFIED',
                    ],
                ],
            ],
        ],
    ],
];
