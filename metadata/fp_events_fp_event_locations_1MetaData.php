<?php
// created: 2013-04-24 10:38:41
$dictionary["fp_events_fp_event_locations_1"] = array(
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' =>
  array(
    'fp_events_fp_event_locations_1' =>
    array(
      'lhs_module' => 'FP_events',
      'lhs_table' => 'fp_events',
      'lhs_key' => 'id',
      'rhs_module' => 'FP_Event_Locations',
      'rhs_table' => 'fp_event_locations',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'fp_events_fp_event_locations_1_c',
      'join_key_lhs' => 'fp_events_fp_event_locations_1fp_events_ida',
      'join_key_rhs' => 'fp_events_fp_event_locations_1fp_event_locations_idb',
    ),
  ),
  'table' => 'fp_events_fp_event_locations_1_c',
  'fields' =>
  array(
    0 =>
    array(
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 =>
    array(
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 =>
    array(
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 =>
    array(
      'name' => 'fp_events_fp_event_locations_1fp_events_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 =>
    array(
      'name' => 'fp_events_fp_event_locations_1fp_event_locations_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' =>
  array(
    0 =>
    array(
      'name' => 'fp_events_fp_event_locations_1spk',
      'type' => 'primary',
      'fields' =>
      array(
        0 => 'id',
      ),
    ),
    1 =>
    array(
      'name' => 'fp_events_fp_event_locations_1_alt',
      'type' => 'alternate_key',
      'fields' =>
      array(
        0 => 'fp_events_fp_event_locations_1fp_events_ida',
        1 => 'fp_events_fp_event_locations_1fp_event_locations_idb',
      ),
    ),
  ),
);
