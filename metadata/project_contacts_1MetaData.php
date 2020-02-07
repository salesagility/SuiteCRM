<?php
// created: 2014-06-24 15:48:56
$dictionary["project_contacts_1"] = array(
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' =>
  array(
    'project_contacts_1' =>
    array(
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
    ),
  ),
  'table' => 'project_contacts_1_c',
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
      'name' => 'project_contacts_1project_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 =>
    array(
      'name' => 'project_contacts_1contacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' =>
  array(
    0 =>
    array(
      'name' => 'project_contacts_1spk',
      'type' => 'primary',
      'fields' =>
      array(
        0 => 'id',
      ),
    ),
    1 =>
    array(
      'name' => 'project_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' =>
      array(
        0 => 'project_contacts_1project_ida',
        1 => 'project_contacts_1contacts_idb',
      ),
    ),
  ),
);
