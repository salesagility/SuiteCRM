<?php
// created: 2013-04-25 10:18:48
$dictionary["fp_event_locations_fp_events_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'fp_event_locations_fp_events_1' => 
    array (
      'lhs_module' => 'FP_Event_Locations',
      'lhs_table' => 'fp_event_locations',
      'lhs_key' => 'id',
      'rhs_module' => 'FP_events',
      'rhs_table' => 'fp_events',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'fp_event_locations_fp_events_1_c',
      'join_key_lhs' => 'fp_event_locations_fp_events_1fp_event_locations_ida',
      'join_key_rhs' => 'fp_event_locations_fp_events_1fp_events_idb',
    ),
  ),
  'table' => 'fp_event_locations_fp_events_1_c',
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
      'name' => 'fp_event_locations_fp_events_1fp_event_locations_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'fp_event_locations_fp_events_1fp_events_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'fp_event_locations_fp_events_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'fp_event_locations_fp_events_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'fp_event_locations_fp_events_1fp_event_locations_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'fp_event_locations_fp_events_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'fp_event_locations_fp_events_1fp_events_idb',
      ),
    ),
  ),
);