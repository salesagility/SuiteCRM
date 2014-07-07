<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

$dictionary['Bug'] = array('table' => 'bugs',    'audited'=>true, 'comment' => 'Bugs are defects in products and services','duplicate_merge'=>true
                               ,'unified_search' => true,'fields' => array (
  'found_in_release'=>
  	array(
  	'name'=>'found_in_release',
  	'type' => 'enum',
  	'function'=>'getReleaseDropDown',
  	'vname' => 'LBL_FOUND_IN_RELEASE',
  	'reportable'=>false,
  	//'merge_filter' => 'enabled', //bug 22994, I think the former fixing is just avoiding the cross table query, it is not a good method.
    'comment' => 'The software or service release that manifested the bug',
    'duplicate_merge' => 'disabled',
    'audited' =>true,
    'studio' => array(
        'fields' => 'false',  // tyoung bug 16442 - don't show in studio fields list
        'listview' => false,
    ),
    'massupdate' => true,
  	),
'release_name'=>
  array (
    'name' => 'release_name',
    'rname' => 'name',
    'vname'=>'LBL_FOUND_IN_RELEASE',
    'type' => 'relate',
    'dbType'=>'varchar',
	'group'=>'found_in_release',
    'reportable'=>false,
    'source'=>'non-db',
    'table'=>'releases',
    'merge_filter' => 'enabled', //bug 22994, we should use the release name to search, I have write codes to operate the cross table query. 
    'id_name'=>'found_in_release',
    'module'=>'Releases',
    'link' => 'release_link',
    'massupdate' => false,
	'studio' => array(
       'editview' => false, 
       'detailview' => false,
       'quickcreate' => false, 
       'basic_search' => false, 
       'advanced_search' => false,
	   ),
  ),

    'fixed_in_release'=>
  	array(
  	'name'=>'fixed_in_release',
  	'type' => 'enum',
  	'function'=>'getReleaseDropDown',
  	'vname' => 'LBL_FIXED_IN_RELEASE',
  	'reportable'=>false,
    'comment' => 'The software or service release that corrected the bug',
    'duplicate_merge' => 'disabled',
    'audited' =>true,
    'studio' => array(
        'fields' => 'false', // tyoung bug 16442 - don't show in studio fields list
        'listview' => false,
    ),
  	'massupdate' => true,
  	),
   'fixed_in_release_name'=>
  array (
    'name' => 'fixed_in_release_name',
    'rname' => 'name',
    'group'=>'fixed_in_release',
    'id_name' => 'fixed_in_release',
    'vname' => 'LBL_FIXED_IN_RELEASE',
    'type' => 'relate',
    'table' => 'releases',
    'isnull' => 'false',
    'massupdate' => false,
    'module' => 'Releases',
    'dbType' => 'varchar',
    'len' => 36,
    'source'=>'non-db',
    'link' => 'fixed_in_release_link',
	'studio' => array(
       'editview' => false, 
       'detailview' => false,
       'quickcreate' => false, 
       'basic_search' => false, 
       'advanced_search' => false,
       ),
  ),
    'source' =>
  array (
    'name' => 'source',
    'vname' => 'LBL_SOURCE',
    'type' => 'enum',
    'options'=>'source_dom',
    'len' => 255,
    'comment' => 'An indicator of how the bug was entered (ex: via web, email, etc.)'
  ),
    'product_category' =>
  array (
    'name' => 'product_category',
    'vname' => 'LBL_PRODUCT_CATEGORY',
    'type' => 'enum',
    'options'=>'product_category_dom',
    'len' => 255,
    'comment' => 'Where the bug was discovered (ex: Accounts, Contacts, Leads)'
  ),


  'tasks' =>
  array (
  	'name' => 'tasks',
    'type' => 'link',
    'relationship' => 'bug_tasks',
    'source'=>'non-db',
		'vname'=>'LBL_TASKS'
  ),
  'notes' =>
  array (
  	'name' => 'notes',
    'type' => 'link',
    'relationship' => 'bug_notes',
    'source'=>'non-db',
		'vname'=>'LBL_NOTES'
  ),
  'meetings' =>
  array (
  	'name' => 'meetings',
    'type' => 'link',
    'relationship' => 'bug_meetings',
    'source'=>'non-db',
		'vname'=>'LBL_MEETINGS'
  ),
  'calls' =>
  array (
  	'name' => 'calls',
    'type' => 'link',
    'relationship' => 'bug_calls',
    'source'=>'non-db',
		'vname'=>'LBL_CALLS'
  ),
  'emails' =>
  array (
  	'name' => 'emails',
    'type' => 'link',
    'relationship' => 'emails_bugs_rel',/* reldef in emails */
    'source'=>'non-db',
		'vname'=>'LBL_EMAILS'
  ),
  'documents'=>
  array (
      'name' => 'documents',
      'type' => 'link',
      'relationship' => 'documents_bugs',
      'source' => 'non-db',
      'vname' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
  ),
  'contacts' =>
  array (
  	'name' => 'contacts',
    'type' => 'link',
    'relationship' => 'contacts_bugs',
    'source'=>'non-db',
		'vname'=>'LBL_CONTACTS'
  ),
  'accounts' =>
  array (
  	'name' => 'accounts',
    'type' => 'link',
    'relationship' => 'accounts_bugs',
    'source'=>'non-db',
		'vname'=>'LBL_ACCOUNTS'
  ),
  'cases' =>
  array (
  	'name' => 'cases',
    'type' => 'link',
    'relationship' => 'cases_bugs',
    'source'=>'non-db',
		'vname'=>'LBL_CASES'
  ),
  'project' =>
  array (
  	'name' => 'project',
        'type' => 'link',
        'relationship' => 'projects_bugs',
        'source'=>'non-db',
        'vname'=>'LBL_PROJECTS',
  ),
  'release_link' =>
  array (
        'name' => 'release_link',
    'type' => 'link',
    'relationship' => 'bugs_release',
    'vname' => 'LBL_FOUND_IN_RELEASE',
    'link_type' => 'one',
    'module'=>'Releases',
    'bean_name'=>'Release',
    'source'=>'non-db',
  ),
  'fixed_in_release_link' =>
  array (
        'name' => 'fixed_in_release_link',
    'type' => 'link',
    'relationship' => 'bugs_fixed_in_release',
    'vname' => 'LBL_FIXED_IN_RELEASE',
    'link_type' => 'one',
    'module'=>'Releases',
    'bean_name'=>'Release',
    'source'=>'non-db',
  ),

)
                                                      , 'indices' => array (
      array('name' =>'bug_number', 'type' =>'index', 'fields'=>array('bug_number')),

       array('name' =>'idx_bug_name', 'type' =>'index', 'fields'=>array('name')),

       array('name' => 'idx_bugs_assigned_user', 'type' => 'index', 'fields'=> array('assigned_user_id')),

                                                      )

, 'relationships' => array (
	'bug_tasks' => array('lhs_module'=> 'Bugs', 'lhs_table'=> 'bugs', 'lhs_key' => 'id',
							  'rhs_module'=> 'Tasks', 'rhs_table'=> 'tasks', 'rhs_key' => 'parent_id',
							  'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'Bugs')
	,'bug_meetings' => array('lhs_module'=> 'Bugs', 'lhs_table'=> 'bugs', 'lhs_key' => 'id',
							  'rhs_module'=> 'Meetings', 'rhs_table'=> 'meetings', 'rhs_key' => 'parent_id',
							  'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'Bugs')
	,'bug_calls' => array('lhs_module'=> 'Bugs', 'lhs_table'=> 'bugs', 'lhs_key' => 'id',
							  'rhs_module'=> 'Calls', 'rhs_table'=> 'calls', 'rhs_key' => 'parent_id',
							  'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'Bugs')
	,'bug_emails' => array('lhs_module'=> 'Bugs', 'lhs_table'=> 'bugs', 'lhs_key' => 'id',
							  'rhs_module'=> 'Emails', 'rhs_table'=> 'emails', 'rhs_key' => 'parent_id',
							  'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'Bugs')
	,'bug_notes' => array('lhs_module'=> 'Bugs', 'lhs_table'=> 'bugs', 'lhs_key' => 'id',
							  'rhs_module'=> 'Notes', 'rhs_table'=> 'notes', 'rhs_key' => 'parent_id',
							  'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
							  'relationship_role_column_value'=>'Bugs')

  ,'bugs_assigned_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'assigned_user_id',
   'relationship_type'=>'one-to-many')

   ,'bugs_modified_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'modified_user_id',
   'relationship_type'=>'one-to-many')

   ,'bugs_created_by' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'created_by',
   'relationship_type'=>'one-to-many')
   ,'bugs_release' =>
   array('lhs_module'=> 'Releases', 'lhs_table'=> 'releases', 'lhs_key' => 'id',
   'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'found_in_release',
   'relationship_type'=>'one-to-many')
   ,'bugs_fixed_in_release' =>
   array('lhs_module'=> 'Releases', 'lhs_table'=> 'releases', 'lhs_key' => 'id',
   'rhs_module'=> 'Bugs', 'rhs_table'=> 'bugs', 'rhs_key' => 'fixed_in_release',
   'relationship_type'=>'one-to-many')

),         //This enables optimistic locking for Saves From EditView
	'optimistic_locking'=>true,
                            );

VardefManager::createVardef('Bugs','Bug', array('default', 'assignable',
'issue',
));

//jc - adding for refactor for import to not use the required_fields array
//defined in the field_arrays.php file
$dictionary['Bug']['fields']['name']['importable'] = 'required';

?>
