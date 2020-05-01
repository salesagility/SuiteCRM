<?php

$listViewDefs['AOW_Processed'] =
[
    'AOW_WORKFLOW' => [
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_AOW_WORKFLOW',
        'id' => 'AOW_WORKFLOW_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
    ],
    'PARENT_TYPE' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_MODULE',
        'width' => '10%',
    ],
    'PARENT_NAME' => [
        'width' => '10%',
        'label' => 'LBL_BEAN',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' => [
            0 => 'parent_id',
            1 => 'parent_module',
        ],
    ],
    'STATUS' => [
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
    ],
    'DATE_ENTERED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
    ],
    'DATE_MODIFIED' => [
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => true,
    ],
];
