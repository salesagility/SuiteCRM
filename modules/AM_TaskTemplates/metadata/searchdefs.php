<?php

$module_name = 'AM_TaskTemplates';
$searchdefs[$module_name] =
[
    'layout' => [
        'basic_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'status' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'name' => 'status',
            ],
            'priority' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_PRIORITY',
                'width' => '10%',
                'name' => 'priority',
            ],
            'current_user_only' => [
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ],
        ],
        'advanced_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'status' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'name' => 'status',
            ],
            'priority' => [
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_PRIORITY',
                'width' => '10%',
                'name' => 'priority',
            ],
            'duration' => [
                'type' => 'int',
                'label' => 'LBL_DURATION',
                'width' => '10%',
                'default' => true,
                'name' => 'duration',
            ],
            'am_tasktemplates_am_projecttemplates_name' => [
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
                'id' => 'AM_TASKTEMPLATES_AM_PROJECTTEMPLATESAM_PROJECTTEMPLATES_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'am_tasktemplates_am_projecttemplates_name',
            ],
            'assigned_user_id' => [
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => [
                    'name' => 'get_user_array',
                    'params' => [
                        0 => false,
                    ],
                ],
                'default' => true,
                'width' => '10%',
            ],
        ],
    ],
    'templateMeta' => [
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => [
            'label' => '10',
            'field' => '30',
        ],
    ],
];
