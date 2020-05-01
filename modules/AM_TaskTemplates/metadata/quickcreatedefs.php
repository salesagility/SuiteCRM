<?php

$module_name = 'AM_TaskTemplates';
$viewdefs[$module_name] =
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
            'useTabs' => false,
            'tabDefs' => [
                'DEFAULT' => [
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ],
            ],
        ],
        'panels' => [
            'default' => [
                0 => [
                    0 => 'name',
                    1 => [
                        'name' => 'duration',
                        'label' => 'LBL_DURATION',
                    ],
                ],
                1 => [
                    0 => [
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ],
                    1 => [
                        'name' => 'priority',
                        'studio' => 'visible',
                        'label' => 'LBL_PRIORITY',
                    ],
                ],
                2 => [
                    0 => [
                        'name' => 'milestone_flag',
                        'label' => 'LBL_MILESTONE_FLAG',
                    ],
                    1 => [
                        'name' => 'order_number',
                        'label' => 'LBL_ORDER_NUMBER',
                    ],
                ],
                3 => [
                    0 => [
                        'name' => 'predecessors',
                        'label' => 'LBL_PREDECESSORS',
                    ],
                    1 => [
                        'name' => 'percent_complete',
                        'label' => 'LBL_PERCENT_COMPLETE',
                    ],
                ],
                4 => [
                    0 => [
                        'name' => 'task_number',
                        'label' => 'LBL_TASK_NUMBER',
                    ],
                    1 => [
                        'name' => 'relationship_type',
                        'studio' => 'visible',
                        'label' => 'LBL_RELATIONSHIP_TYPE',
                    ],
                ],
                5 => [
                    0 => [
                        'name' => 'estimated_effort',
                        'label' => 'LBL_ESTIMATED_EFFORT',
                    ],
                    1 => [
                        'name' => 'utilization',
                        'studio' => 'visible',
                        'label' => 'LBL_UTILIZATION',
                    ],
                ],
                6 => [
                    0 => 'assigned_user_name',
                    1 => [
                        'name' => 'am_tasktemplates_am_projecttemplates_name',
                        'label' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
                    ],
                ],
                7 => [
                    0 => [
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'label' => 'LBL_DESCRIPTION',
                    ],
                ],
            ],
        ],
    ],
];
