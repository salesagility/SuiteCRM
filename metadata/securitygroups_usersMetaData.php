<?php

$dictionary["securitygroups_users"] = array (
  'table' => 'securitygroups_users',
  'fields' => 
  array (
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    array (
      'name' => 'securitygroup_id',
      'type' => 'varchar',
      'len' => 36,
    ),
    array (
      'name' => 'user_id',
      'type' => 'varchar',
      'len' => 36,
    ),  
    array (
        'name' => 'primary_group',
        'vname' => 'LBL_PRIMARY_GROUP',
        'type' => 'bool',
        'reportable'=>false,
        'comment' => 'Drives which custom layout to show if a user is a member of more than 1 group'
    ),
    array (
        'name' => 'noninheritable',
        'vname' => 'LBL_NONINHERITABLE',
        'type' => 'bool',
        'reportable'=>false,
        'default' => '0',
        'comment' => 'Indicator for whether a group can be inherited by a record'
    ),
  ),
  'indices' => 
  array (
    array (
      'name' => 'securitygroups_usersspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    array (
      'name' => 'securitygroups_users_idxa',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'securitygroup_id',
      ),
    ), 
    array (
      'name' => 'securitygroups_users_idxb',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'user_id',
      ),
    ),
    array (
      'name' => 'securitygroups_users_idxc',
      'type' => 'index',
      'fields' => 
      array ('user_id','deleted','securitygroup_id','id'),
    ),
    array (
      'name' => 'securitygroups_users_idxd',
      'type' => 'index',
      'fields' => 
      array ('user_id','deleted','securitygroup_id'),
    ),
  ),
  'relationships' => 
  array (
    'securitygroups_users' => 
    array (
      'lhs_module' => 'SecurityGroups',
      'lhs_table' => 'securitygroups',
      'lhs_key' => 'id',
      'rhs_module' => 'Users',
      'rhs_table' => 'users',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'securitygroups_users',
      'join_key_lhs' => 'securitygroup_id',
      'join_key_rhs' => 'user_id',
    ),
  ),
);
