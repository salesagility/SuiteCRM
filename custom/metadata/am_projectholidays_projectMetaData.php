<?php
// created: 2014-06-25 23:55:39
$dictionary["am_projectholidays_project"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'am_projectholidays_project' => 
    array (
      'lhs_module' => 'Project',
      'lhs_table' => 'project',
      'lhs_key' => 'id',
      'rhs_module' => 'AM_ProjectHolidays',
      'rhs_table' => 'am_projectholidays',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'am_projectholidays_project_c',
      'join_key_lhs' => 'am_projectholidays_projectproject_ida',
      'join_key_rhs' => 'am_projectholidays_projectam_projectholidays_idb',
    ),
  ),
  'table' => 'am_projectholidays_project_c',
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
      'name' => 'am_projectholidays_projectproject_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'am_projectholidays_projectam_projectholidays_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'am_projectholidays_projectspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'am_projectholidays_project_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'am_projectholidays_projectproject_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'am_projectholidays_project_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'am_projectholidays_projectam_projectholidays_idb',
      ),
    ),
  ),
);