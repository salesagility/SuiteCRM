<?php

// created: 2014-06-04 23:46:40
$dictionary['am_projecttemplates_project_1'] = [
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' => [
        'am_projecttemplates_project_1' => [
            'lhs_module' => 'AM_ProjectTemplates',
            'lhs_table' => 'am_projecttemplates',
            'lhs_key' => 'id',
            'rhs_module' => 'Project',
            'rhs_table' => 'project',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'am_projecttemplates_project_1_c',
            'join_key_lhs' => 'am_projecttemplates_project_1am_projecttemplates_ida',
            'join_key_rhs' => 'am_projecttemplates_project_1project_idb',
        ],
    ],
    'table' => 'am_projecttemplates_project_1_c',
    'fields' => [
        0 => [
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36,
        ],
        1 => [
            'name' => 'date_modified',
            'type' => 'datetime',
        ],
        2 => [
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ],
        3 => [
            'name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
            'type' => 'varchar',
            'len' => 36,
        ],
        4 => [
            'name' => 'am_projecttemplates_project_1project_idb',
            'type' => 'varchar',
            'len' => 36,
        ],
    ],
    'indices' => [
        0 => [
            'name' => 'am_projecttemplates_project_1spk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        1 => [
            'name' => 'am_projecttemplates_project_1_ida1',
            'type' => 'index',
            'fields' => [
                0 => 'am_projecttemplates_project_1am_projecttemplates_ida',
            ],
        ],
        2 => [
            'name' => 'am_projecttemplates_project_1_alt',
            'type' => 'alternate_key',
            'fields' => [
                0 => 'am_projecttemplates_project_1project_idb',
            ],
        ],
    ],
];
