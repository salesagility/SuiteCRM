<?php

// created: 2014-06-24 15:48:56
$dictionary['project_contacts_1'] = [
    'true_relationship_type' => 'many-to-many',
    'from_studio' => true,
    'relationships' => [
        'project_contacts_1' => [
            'lhs_module' => 'Project',
            'lhs_table' => 'project',
            'lhs_key' => 'id',
            'rhs_module' => 'Contacts',
            'rhs_table' => 'contacts',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'project_contacts_1_c',
            'join_key_lhs' => 'project_contacts_1project_ida',
            'join_key_rhs' => 'project_contacts_1contacts_idb',
        ],
    ],
    'table' => 'project_contacts_1_c',
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
            'name' => 'project_contacts_1project_ida',
            'type' => 'varchar',
            'len' => 36,
        ],
        4 => [
            'name' => 'project_contacts_1contacts_idb',
            'type' => 'varchar',
            'len' => 36,
        ],
    ],
    'indices' => [
        0 => [
            'name' => 'project_contacts_1spk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        1 => [
            'name' => 'project_contacts_1_alt',
            'type' => 'alternate_key',
            'fields' => [
                0 => 'project_contacts_1project_ida',
                1 => 'project_contacts_1contacts_idb',
            ],
        ],
    ],
];
