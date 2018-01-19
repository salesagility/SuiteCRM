<?php
// created: 2010-11-12 15:50:54
$dictionary["jjwg_maps_jjwg_areas"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'jjwg_maps_jjwg_areas' => 
    array (
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
    ),
  ),
  'table' => 'jjwg_maps_jjwg_areas_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'jjwg_maps_5304wg_maps_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'jjwg_maps_41f2g_areas_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'jjwg_maps_jjwg_areasspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'jjwg_maps_jjwg_areas_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'jjwg_maps_5304wg_maps_ida',
        1 => 'jjwg_maps_41f2g_areas_idb',
      ),
    ),
  ),
);
