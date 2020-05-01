<?php

// created: 2014-05-30 00:06:35
$dictionary['am_tasktemplates_am_projecttemplates'] = [
    'true_relationship_type' => 'one-to-many',
    'relationships' => [
        'am_tasktemplates_am_projecttemplates' => [
            'lhs_module' => 'AM_ProjectTemplates',
            'lhs_table' => 'am_projecttemplates',
            'lhs_key' => 'id',
            'rhs_module' => 'AM_TaskTemplates',
            'rhs_table' => 'am_tasktemplates',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'am_tasktemplates_am_projecttemplates_c',
            'join_key_lhs' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
            'join_key_rhs' => 'am_tasktemplates_am_projecttemplatesam_tasktemplates_idb',
        ],
    ],
    'table' => 'am_tasktemplates_am_projecttemplates_c',
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
            'name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
            'type' => 'varchar',
            'len' => 36,
        ],
        4 => [
            'name' => 'am_tasktemplates_am_projecttemplatesam_tasktemplates_idb',
            'type' => 'varchar',
            'len' => 36,
        ],
    ],
    'indices' => [
        0 => [
            'name' => 'am_tasktemplates_am_projecttemplatesspk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        1 => [
            'name' => 'am_tasktemplates_am_projecttemplates_ida1',
            'type' => 'index',
            'fields' => [
                0 => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
            ],
        ],
        2 => [
            'name' => 'am_tasktemplates_am_projecttemplates_alt',
            'type' => 'alternate_key',
            'fields' => [
                0 => 'am_tasktemplates_am_projecttemplatesam_tasktemplates_idb',
            ],
        ],
    ],
];
