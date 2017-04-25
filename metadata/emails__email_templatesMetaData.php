<?php
// created: 2017-04-25 11:21:31
$dictionary["emails__email_templates"] = array (
  'true_relationship_type' => 'one-to-one',
  'from_studio' => true,
  'relationships' => 
  array (
    'emails__email_templates' =>
    array (
      'lhs_module' => 'Emails',
      'lhs_table' => 'emails',
      'lhs_key' => 'id',
      'rhs_module' => 'EmailTemplates',
      'rhs_table' => 'email_templates',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'emails__email_templates',
      'join_key_lhs' => 'emails__email_templates_ida',
      'join_key_rhs' => 'emails__email_templates_idb',
    ),
  ),
  'table' => 'emails__email_templates',
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
      'name' => 'emails__email_templates_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'emails__email_templates_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'emails__email_templatesspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'emails__email_templates_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'emails__email_templates_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'emails__email_templates_idb2',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'emails__email_templates_idb',
      ),
    ),
  ),
);