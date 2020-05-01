<?php

$viewdefs['ProjectTask'] =
[
    'DetailView' => [
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
            'form' => [
                'buttons' => [
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                ],
                'hideAudit' => true,
            ],
            'useTabs' => true,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
                'LBL_PANEL_TIMELINE' => [
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ],
            ],
            'syncDetailEditViews' => true,
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => 'status',
                ],
                1 => [
                    0 => 'date_start',
                    1 => 'date_finish',
                ],
                2 => [
                    0 => 'priority',
                    1 => 'percent_complete',
                ],
                3 => [
                    0 => [
                        'name' => 'project_name',
                        'customCode' => '<a href="index.php?module=Project&action=DetailView&record={$fields.project_id.value}">{$fields.project_name.value}&nbsp;</a>',
                        'label' => 'LBL_PARENT_ID',
                    ],
                    1 => 'task_number',
                ],
                4 => [
                    0 => [
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_USER_ID',
                    ],
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
                        'name' => 'predecessors',
                        'label' => 'LBL_PREDECESSORS',
                    ],
                    1 => [
                        'name' => 'relationship_type',
                        'studio' => 'visible',
                        'label' => 'LBL_RELATIONSHIP_TYPE',
                    ],
                ],
                2 => [
                    0 => 'order_number',
                    1 => [
                        'name' => 'milestone_flag',
                        'label' => 'LBL_MILESTONE_FLAG',
                    ],
                ],
                3 => [
                    0 => 'utilization',
                    1 => '',
                ],
                4 => [
                    0 => [
                        'name' => 'duration',
                        'label' => 'LBL_DURATION',
                    ],
                    1 => [
                        'name' => 'duration_unit',
                        'label' => 'LBL_DURATION_UNIT',
                    ],
                ],
            ],
        ],
    ],
];
