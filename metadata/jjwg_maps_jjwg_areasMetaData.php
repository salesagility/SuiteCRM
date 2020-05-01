<?php

// created: 2010-11-12 15:50:54
$dictionary['jjwg_maps_jjwg_areas'] = [
    'true_relationship_type' => 'many-to-many',
    'relationships' => [
        'jjwg_maps_jjwg_areas' => [
            'lhs_module' => 'jjwg_Maps',
            'lhs_table' => 'jjwg_maps',
            'lhs_key' => 'id',
            'rhs_module' => 'jjwg_Areas',
            'rhs_table' => 'jjwg_areas',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'jjwg_maps_jjwg_areas_c',
            'join_key_lhs' => 'jjwg_maps_5304wg_maps_ida',
            'join_key_rhs' => 'jjwg_maps_41f2g_areas_idb',
        ],
    ],
    'table' => 'jjwg_maps_jjwg_areas_c',
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
            'name' => 'jjwg_maps_5304wg_maps_ida',
            'type' => 'varchar',
            'len' => 36,
        ],
        4 => [
            'name' => 'jjwg_maps_41f2g_areas_idb',
            'type' => 'varchar',
            'len' => 36,
        ],
    ],
    'indices' => [
        0 => [
            'name' => 'jjwg_maps_jjwg_areasspk',
            'type' => 'primary',
            'fields' => [
                0 => 'id',
            ],
        ],
        1 => [
            'name' => 'jjwg_maps_jjwg_areas_alt',
            'type' => 'alternate_key',
            'fields' => [
                0 => 'jjwg_maps_5304wg_maps_ida',
                1 => 'jjwg_maps_41f2g_areas_idb',
            ],
        ],
    ],
];
