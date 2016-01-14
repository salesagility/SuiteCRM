<?php

$dictionary['jjwg_Maps'] = array(
	'table'=>'jjwg_maps',
	'audited'=>true,
	'fields'=>array (
  'distance' => 
  array (
    'required' => true,
    'name' => 'distance',
    'vname' => 'LBL_DISTANCE',
    'type' => 'float',
    'massupdate' => 0,
    'comments' => '',
    'help' => 'Distance',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => '9',
    'size' => '20',
    'precision' => '4',
  ),
  'unit_type' => 
  array (
    'required' => true,
    'name' => 'unit_type',
    'vname' => 'LBL_UNIT_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'mi',
    'comments' => '',
    'help' => 'Unit Type (mi/km)',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => 100,
    'size' => '20',
    'options' => 'map_unit_type_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'module_type' => 
  array (
    'required' => true,
    'name' => 'module_type',
    'vname' => 'LBL_MODULE_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'Accounts',
    'comments' => '',
    'help' => 'Module Type to Display',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => 100,
    'size' => '20',
    'options' => 'map_module_type_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'parent_name' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'parent_name',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'parent',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => 25,
    'size' => '20',
    'options' => 'map_relate_type_list',
    'studio' => 'visible',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'parent_type' => 'record_type_display',
  ),
  'parent_type' => 
  array (
    'required' => false,
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'len' => 255,
    'size' => '20',
    'dbType' => 'varchar',
    'studio' => 'hidden',
  ),
  'parent_id' => 
  array (
    'required' => false,
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_ID',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'len' => 36,
    'size' => '20',
  ),
),
	'relationships'=>array (
),
	'optimistic_locking'=>true,
);



$dictionary['jjwg_Maps']['fields']['accounts'] = array(
    'name' => 'accounts',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_accounts',
    'module'=>'Accounts',
    'bean_name'=>'Account',
    'source'=>'non-db',
    'vname'=>'LBL_ACCOUNTS',
    );
 
$dictionary['jjwg_Maps']['fields']['contacts'] = array(
    'name' => 'contacts',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_contacts',
    'module'=>'Contacts',
    'bean_name'=>'Contact',
    'source'=>'non-db',
    'vname'=>'LBL_CONTACTS',
    );
 
$dictionary['jjwg_Maps']['fields']['leads'] = array(
    'name' => 'leads',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_leads',
    'module'=>'Leads',
    'bean_name'=>'Lead',
    'source'=>'non-db',
    'vname'=>'LBL_LEADS',
    );

$dictionary['jjwg_Maps']['fields']['opportunities'] = array(
    'name' => 'opportunities',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_opportunities',
    'module'=>'Leads',
    'bean_name'=>'Opportunity',
    'source'=>'non-db',
    'vname'=>'LBL_OPPORTUNITIES',
    );

$dictionary['jjwg_Maps']['fields']['cases'] = array(
    'name' => 'cases',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_cases',
    'module'=>'Cases',
    'bean_name'=>'Case',
    'source'=>'non-db',
    'vname'=>'LBL_CASES',
    );

$dictionary['jjwg_Maps']['fields']['projects'] = array(
    'name' => 'projects',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_projects',
    'module'=>'Project',
    'bean_name'=>'Project',
    'source'=>'non-db',
    'vname'=>'LBL_PROJECTS',
    );

$dictionary['jjwg_Maps']['fields']['meetings'] = array(
    'name' => 'meetings',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_meetings',
    'module'=>'Meetings',
    'bean_name'=>'Meeting',
    'source'=>'non-db',
    'vname'=>'LBL_MEETINGS',
    );

$dictionary['jjwg_Maps']['fields']['prospects'] = array(
    'name' => 'prospects',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_prospects',
    'module'=>'Prospects',
    'bean_name'=>'Prospect',
    'source'=>'non-db',
    'vname'=>'LBL_PROSPECTS',
    );

$dictionary['jjwg_Maps']['fields']['jjwp_partners'] = array(
    'name' => 'jjwp_partners',
    'type' => 'link',
    'relationship' => 'jjwg_Maps_jjwp_partners',
    'module'=>'jjwp_Partners',
    'bean_name'=>'jjwp_Partners',
    'source'=>'non-db',
    'vname'=>'LBL_JJWP_PARTNERS',
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_accounts'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Accounts',
    'rhs_table'			=> 'accounts',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Accounts'
    );
 
$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_contacts'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Contacts',
    'rhs_table'			=> 'contacts',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Contacts'
    );
 
$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_leads'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Leads',
    'rhs_table'			=> 'leads',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Leads'
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_opportunities'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Opportunities',
    'rhs_table'			=> 'opportunities',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Opportunities'
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_cases'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Cases',
    'rhs_table'			=> 'cases',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Cases'
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_projects'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Project',
    'rhs_table'			=> 'project',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Project'
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_meetings'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Meetings',
    'rhs_table'			=> 'meetings',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Meetings'
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_prospects'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'Prospects',
    'rhs_table'			=> 'prospects',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'Prospects'
    );

$dictionary['jjwg_Maps']['relationships']['jjwg_Maps_jjwp_partners'] = array(
    'lhs_module'		=> 'jjwg_Maps',
    'lhs_table'			=> 'jjwg_Maps',
    'lhs_key'			=> 'parent_id',
    'rhs_module'		=> 'jjwp_Partners',
    'rhs_table'			=> 'jjwp_partners',
    'rhs_key'			=> 'id',
    'relationship_type'	=> 'one-to-many',
    'relationship_role_column'=>'parent_type',
    'relationship_role_column_value'=>'jjwp_Partners'
    );


if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('jjwg_Maps','jjwg_Maps', array('basic','assignable'));
