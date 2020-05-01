<?php

$viewdefs['ProjectTask'] =
[
    'EditView' => [
        'templateMeta' => [
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
            'includes' => [
                0 => [
                    'file' => 'modules/ProjectTask/ProjectTask.js',
                ],
            ],
            'useTabs' => false,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_TIMELINE' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => false,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'status',
                        'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'date_start',
                    ],
                    1 => [
                        'name' => 'date_finish',
                    ],
                ],
                2 => [
                    0 => 'priority',
                    1 => [
                        'name' => 'percent_complete',
                        'customCode' => '<input type="text" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" size="30" value="{$fields.percent_complete.value}" title="" tabindex="0" onChange="update_status(this.value);" /></tr>',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'project_name',
                        'label' => 'LBL_PROJECT_NAME',
                    ],
                    1 => 'task_number',
                ],
                4 => [
                    0 => 'assigned_user_name',
                ],
                5 => [
                    0 => [
                        'name' => 'description',
                    ],
                ],
            ],
            'LBL_PANEL_TIMELINE' => [
                0 => [
                    0 => 'estimated_effort',
                    1 => [
                        'name' => 'actual_effort',
                        'label' => 'LBL_ACTUAL_EFFORT',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'relationship_type',
                        'studio' => 'visible',
                        'label' => 'LBL_RELATIONSHIP_TYPE',
                    ],
                    1 => 'utilization',
                ],
                2 => [
                    0 => 'order_number',
                    1 => 'milestone_flag',
                ],
            ],
        ],
    ],
];
