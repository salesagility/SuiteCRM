<?php
// created: 2024-04-23 13:25:51
$dictionary["ut_sub_installation_ut_installation"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ut_sub_installation_ut_installation' => 
    array (
      'lhs_module' => 'UT_Installation',
      'lhs_table' => 'ut_installation',
      'lhs_key' => 'id',
      'rhs_module' => 'UT_Sub_Installation',
      'rhs_table' => 'ut_sub_installation',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ut_sub_installation_ut_installation_c',
      'join_key_lhs' => 'ut_sub_installation_ut_installationut_installation_ida',
      'join_key_rhs' => 'ut_sub_installation_ut_installationut_sub_installation_idb',
    ),
  ),
  'table' => 'ut_sub_installation_ut_installation_c',
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
      'name' => 'ut_sub_installation_ut_installationut_installation_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'ut_sub_installation_ut_installationut_sub_installation_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'ut_sub_installation_ut_installationspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'ut_sub_installation_ut_installation_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ut_sub_installation_ut_installationut_installation_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'ut_sub_installation_ut_installation_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ut_sub_installation_ut_installationut_sub_installation_idb',
      ),
    ),
  ),
);