<?php

$popupMeta = [
    'moduleMain' => 'AOS_Contracts',
    'varName' => 'AOS_Contracts',
    'orderBy' => 'aos_contracts.name',
    'whereClauses' => [
        'name' => 'aos_contracts.name',
        'status' => 'aos_contracts.status',
        'total_contract_value' => 'aos_contracts.total_contract_value',
        'start_date' => 'aos_contracts.start_date',
        'end_date' => 'aos_contracts.end_date',
    ],
    'searchInputs' => [
        1 => 'name',
        3 => 'status',
        4 => 'total_contract_value',
        5 => 'start_date',
        6 => 'end_date',
    ],
    'searchdefs' => [
        'name' => [
            'type' => 'name',
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ],
        'status' => [
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
            'sortable' => false,
            'width' => '10%',
            'name' => 'status',
        ],
        'start_date' => [
            'type' => 'date',
            'label' => 'LBL_START_DATE',
            'width' => '10%',
            'name' => 'start_date',
        ],
        'end_date' => [
            'type' => 'date',
            'label' => 'LBL_END_DATE',
            'width' => '10%',
            'name' => 'end_date',
        ],
    ],
];
