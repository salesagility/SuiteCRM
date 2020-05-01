<?php

$module_name = 'FP_events';
$searchdefs[$module_name] =
[
    'layout' => [
        'basic_search' => [
            0 => 'name',
            1 => [
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
            ],
        ],
        'advanced_search' => [
            'name' => [
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ],
            'date_start' => [
                'type' => 'datetimecombo',
                'label' => 'LBL_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'date_start',
            ],
            'date_end' => [
                'type' => 'datetimecombo',
                'label' => 'LBL_DATE_END',
                'width' => '10%',
                'default' => true,
                'name' => 'date_end',
            ],
            'fp_event_locations_fp_events_1_name' => [
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENT_LOCATIONS_TITLE',
                'id' => 'FP_EVENT_LOCATIONS_FP_EVENTS_1FP_EVENT_LOCATIONS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'fp_event_locations_fp_events_1_name',
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
