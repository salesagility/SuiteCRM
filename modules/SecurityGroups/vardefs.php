<?php

$dictionary['SecurityGroup'] = array(
    'table'=>'securitygroups',
    'audited'=>true,
    'fields'=>array (
    'noninheritable' => 
    array (
        'name' => 'noninheritable',
        'vname' => 'LBL_NONINHERITABLE',
        'type' => 'bool',
        'reportable'=>false,
        'comment' => 'Indicator for whether a group can be inherited by a record'
    ),
    
    'users' => array(
      'name' => 'users',
      'type' => 'link',
      'relationship' => 'securitygroups_users',
      'source' => 'non-db',
      'vname'=>'LBL_USERS',
    ),
    'aclroles' => array(
      'name' => 'aclroles',
      'type' => 'link',
      'relationship' => 'securitygroups_acl_roles',
      'source' => 'non-db',
      'vname'=>'LBL_ROLES',
    ),
    
    /** related editable fields with Users module */
    'securitygroup_noninher_fields' => array (
        'name' => 'securitygroup_noninher_fields',
        'rname' => 'id',
        'relationship_fields'=>array('id' => 'securitygroup_noninherit_id', 'noninheritable' => 'securitygroup_noninheritable', 'primary_group' => 'securitygroup_primary_group'),
        'vname' => 'LBL_USER_NAME',
        'type' => 'relate',
        'link' => 'users',         
        'link_type' => 'relationship_info',
        'source' => 'non-db',
        'Importable' => false,
        'duplicate_merge'=> 'disabled',
    ),
    'securitygroup_noninherit_id' => array (
        'name' => 'securitygroup_noninherit_id',
        'type' => 'varchar',
        'source' => 'non-db',
        'vname' => 'LBL_securitygroup_noninherit_id',
    ),
    'securitygroup_noninheritable' => array (
        'name' => 'securitygroup_noninheritable',
        'type' => 'bool',
        'source' => 'non-db',
        'vname' => 'LBL_SECURITYGROUP_NONINHERITABLE',
    ),
    'securitygroup_primary_group' => array (
        'name' => 'securitygroup_primary_group',
        'type' => 'bool',
        'source' => 'non-db',
        'vname' => 'LBL_PRIMARY_GROUP',
    ),

),
    'relationships'=>array (
),
    'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('SecurityGroups','SecurityGroup', array('basic','assignable'));
?>