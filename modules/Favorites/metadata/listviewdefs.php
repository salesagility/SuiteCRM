<?php

$module_name = 'Favorites';
$listViewDefs[$module_name] =
[
    'NAME' => [
        'width' => '20%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ],
    'DATE_START' => [
        'type' => 'datetimecombo',
        'label' => 'LBL_DATE',
        'width' => '15%',
        'default' => true,
    ],
    'DATE_END' => [
        'type' => 'datetimecombo',
        'label' => 'LBL_DATE_END',
        'width' => '15%',
        'default' => true,
    ],
    'FP_EVENT_LOCATIONS_FP_EVENTS_1_NAME' => [
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENT_LOCATIONS_TITLE',
        'id' => 'FP_EVENT_LOCATIONS_FP_EVENTS_1FP_EVENT_LOCATIONS_IDA',
        'width' => '15%',
        'default' => true,
    ],
    'BUDGET' => [
        'type' => 'currency',
        'label' => 'LBL_BUDGET',
        'currency_format' => true,
        'width' => '15%',
        'default' => true,
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ],
];
