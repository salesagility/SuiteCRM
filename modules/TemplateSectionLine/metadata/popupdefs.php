<?php

$popupMeta = [
    'moduleMain' => 'TemplateSectionLine',
    'varName' => 'TemplateSectionLine',
    'orderBy' => 'templatesectionline.name',
    'whereClauses' => [
        'name' => 'templatesectionline.name',
        'grp' => 'templatesectionline.grp',
        'description' => 'templatesectionline.description',
    ],
    'searchInputs' => [
        1 => 'name',
        4 => 'grp',
        5 => 'description',
    ],
    'searchdefs' => [
        'name' => [
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'name' => 'name',
        ],
        'grp' => [
            'type' => 'varchar',
            'label' => 'LBL_GRP',
            'width' => '10%',
            'name' => 'grp',
        ],
        'description' => [
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'name' => 'description',
        ],
    ],
    'listviewdefs' => [
        'NAME' => [
            'type' => 'name',
            'link' => true,
            'label' => 'LBL_NAME',
            'width' => '10%',
            'default' => true,
        ],
        'GRP' => [
            'type' => 'varchar',
            'label' => 'LBL_GRP',
            'width' => '10%',
            'default' => true,
        ],
        'DESCRIPTION' => [
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'default' => true,
        ],
    ],
];
