<?php

$dashletData['TemplateSectionLineDashlet']['searchFields'] = [
    'date_entered' => [
        'default' => '',
    ],
    'date_modified' => [
        'default' => '',
    ],
    'assigned_user_id' => [
        'type' => 'assigned_user_name',
        'default' => 'Administrator',
    ],
];
$dashletData['TemplateSectionLineDashlet']['columns'] = [
    'name' => [
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'grp' => [
        'type' => 'varchar',
        'label' => 'LBL_GRP',
        'width' => '10%',
        'default' => true,
    ],
    'description' => [
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
    ],
];
