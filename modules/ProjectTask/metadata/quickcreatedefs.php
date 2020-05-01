<?php

$viewdefs['ProjectTask'] =
[
    'QuickCreate' => [
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
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => [
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ],
                    1 => [
                        'name' => 'project_task_id',
                        'label' => 'LBL_TASK_ID',
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
                    'name' => 'assigned_user_name',
                ],
                3 => [
                    0 => [
                        'name' => 'status',
                        'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
                    ],
                    1 => 'priority',
                ],
                4 => [
                    0 => [
                        'name' => 'percent_complete',
                        'customCode' => '<input type="text" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" size="30" value="{$fields.percent_complete.value}" title="" tabindex="0" onChange="update_status(this.value);" /></tr>',
                    ],
                ],
                5 => [
                    0 => 'milestone_flag',
                ],
                6 => [
                    0 => [
                        'name' => 'project_name',
                        'label' => 'LBL_PROJECT_NAME',
                    ],
                ],
                7 => [
                    0 => 'task_number',
                    1 => 'order_number',
                ],
                8 => [
                    0 => 'estimated_effort',
                    1 => 'utilization',
                ],
                9 => [
                    0 => [
                        'name' => 'description',
                    ],
                ],
                10 => [
                    0 => [
                        'name' => 'duration',
                        'hideLabel' => true,
                        'customCode' => '<input type="hidden" name="duration" id="projectTask_duration" value="0" />',
                    ],
                ],
                11 => [
                    0 => [
                        'name' => 'duration_unit',
                        'hideLabel' => true,
                        'customCode' => '<input type="hidden" name="duration_unit" id="projectTask_durationUnit" value="Days" />',
                    ],
                ],
            ],
        ],
    ],
];
