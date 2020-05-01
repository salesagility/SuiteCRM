<?php

// created: 2013-04-30 14:52:24
$dictionary['fp_events_leads_1'] = [
    'true_relationship_type' => 'many-to-many',
    'from_studio' => true,
    'relationships' => [
        'fp_events_leads_1' => [
            'lhs_module' => 'FP_events',
            'lhs_table' => 'fp_events',
            'lhs_key' => 'id',
            'rhs_module' => 'Leads',
            'rhs_table' => 'leads',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'fp_events_leads_1_c',
            'join_key_lhs' => 'fp_events_leads_1fp_events_ida',
            'join_key_rhs' => 'fp_events_leads_1leads_idb',
        ],
    ],
    'table' => 'fp_events_leads_1_c',
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
            'name' => 'fp_events_leads_1fp_events_ida',
            'type' => 'varchar',
            'len' => 36,
        ],
        4 => [
            'name' => 'fp_events_leads_1leads_idb',
            'type' => 'varchar',
            'len' => 36,
        ],
        5 => [
            'name' => 'invite_status',
            'type' => 'varchar',
            'len' => '25',
            'default' => 'Not Invited',
        ],
        6 => [
            'name' => 'accept_status',
            'type' => 'varchar',
            'len' => '25',
            'default' => 'No Response',
        ],
        7 => [
            'name' => 'email_responded',
            'type' => 'int',
            'len' => '2',
            'default' => '0',
        ],
    ],
    'indices' => [
        0 => [
            'name' => 'fp_events_leads_1spk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        1 => [
            'name' => 'fp_events_leads_1_alt',
            'type' => 'alternate_key',
            'fields' => [
                0 => 'fp_events_leads_1fp_events_ida',
                1 => 'fp_events_leads_1leads_idb',
            ],
        ],
    ],
];
