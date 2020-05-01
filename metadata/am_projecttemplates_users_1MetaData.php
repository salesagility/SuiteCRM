<?php

// created: 2014-06-20 12:06:29
$dictionary['am_projecttemplates_users_1'] = [
    'true_relationship_type' => 'many-to-many',
    'from_studio' => true,
    'relationships' => [
        'am_projecttemplates_users_1' => [
            'lhs_module' => 'AM_ProjectTemplates',
            'lhs_table' => 'am_projecttemplates',
            'lhs_key' => 'id',
            'rhs_module' => 'Users',
            'rhs_table' => 'users',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'am_projecttemplates_users_1_c',
            'join_key_lhs' => 'am_projecttemplates_ida',
            'join_key_rhs' => 'users_idb',
        ],
    ],
    'table' => 'am_projecttemplates_users_1_c',
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
            'name' => 'am_projecttemplates_ida',
            'type' => 'varchar',
            'len' => 36,
        ],
        4 => [
            'name' => 'users_idb',
            'type' => 'varchar',
            'len' => 36,
        ],
    ],
    'indices' => [
        0 => [
            'name' => 'am_projecttemplates_users_1spk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        1 => [
            'name' => 'am_projecttemplates_users_1_alt',
            'type' => 'alternate_key',
            'fields' => [
                0 => 'am_projecttemplates_ida',
                1 => 'users_idb',
            ],
        ],
    ],
];
