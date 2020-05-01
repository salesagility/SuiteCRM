<?php

$popupMeta = [
    'moduleMain' => 'AM_TaskTemplates',
    'varName' => 'AM_TaskTemplates',
    'orderBy' => 'am_tasktemplates.name',
    'whereClauses' => [
        'name' => 'am_tasktemplates.name',
    ],
    'searchInputs' => [
        0 => 'am_tasktemplates_number',
        1 => 'name',
        2 => 'priority',
        3 => 'status',
    ],
    'listviewdefs' => [
        'NAME' => [
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'default' => true,
        ],
        'STATUS' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'width' => '10%',
        ],
        'PRIORITY' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_PRIORITY',
            'width' => '10%',
        ],
        'MILESTONE_FLAG' => [
            'type' => 'bool',
            'default' => true,
            'label' => 'LBL_MILESTONE_FLAG',
            'width' => '10%',
        ],
        'ORDER_NUMBER' => [
            'type' => 'int',
            'label' => 'LBL_ORDER_NUMBER',
            'width' => '10%',
            'default' => true,
        ],
        'RELATIONSHIP_TYPE' => [
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_RELATIONSHIP_TYPE',
            'width' => '10%',
        ],
        'DURATION' => [
            'type' => 'int',
            'label' => 'LBL_DURATION',
            'width' => '10%',
            'default' => true,
        ],
    ],
];
