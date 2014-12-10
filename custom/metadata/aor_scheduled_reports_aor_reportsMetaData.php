<?php
// created: 2014-12-10 11:39:56
$dictionary["aor_scheduled_reports_aor_reports"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'aor_scheduled_reports_aor_reports' => 
    array (
      'lhs_module' => 'AOR_Reports',
      'lhs_table' => 'aor_reports',
      'lhs_key' => 'id',
      'rhs_module' => 'AOR_Scheduled_Reports',
      'rhs_table' => 'aor_scheduled_reports',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'aor_scheduled_reports_aor_reports_c',
      'join_key_lhs' => 'aor_scheduled_reports_aor_reportsaor_reports_ida',
      'join_key_rhs' => 'aor_scheduled_reports_aor_reportsaor_scheduled_reports_idb',
    ),
  ),
  'table' => 'aor_scheduled_reports_aor_reports_c',
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
      'name' => 'aor_scheduled_reports_aor_reportsaor_reports_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'aor_scheduled_reports_aor_reportsaor_scheduled_reports_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'aor_scheduled_reports_aor_reportsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'aor_scheduled_reports_aor_reports_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'aor_scheduled_reports_aor_reportsaor_reports_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'aor_scheduled_reports_aor_reports_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'aor_scheduled_reports_aor_reportsaor_scheduled_reports_idb',
      ),
    ),
  ),
);