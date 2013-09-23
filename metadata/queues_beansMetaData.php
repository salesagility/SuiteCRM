<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


$dictionary['queues_beans'] = array('table' => 'queues_beans', 
	'fields' => array (
		'id' => array (
			'name' => 'id',
			'vname' => 'LBL_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
		'deleted' => array (
			'name' => 'deleted',
			'vname' => 'LBL_DELETED',
			'type' => 'bool',
			'required' => true,
			'default' => '0',
			'reportable'=>false,
		),
		'date_entered' => array (
			'name' => 'date_entered',
			'vname' => 'LBL_DATE_ENTERED',
			'type' => 'datetime',
			'required' => true,
		),
		'date_modified' => array (
			'name' => 'date_modified',
			'vname' => 'LBL_DATE_MODIFIED',
			'type' => 'datetime',
			'required' => true,
		),
		'queue_id' => array (
			'name' => 'queue_id',
			'vname' => 'LBL_QUEUE_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
		'module_dir' => array (
			'name' => 'module_dir',
			'vname' => 'LBL_MODULE_DIR',
			'type' => 'varchar',
			'len'	=> '30',
			'required' => true,
			'reportable'=>false,
		),
		'object_id' => array (
			'name' => 'object_id',
			'vname' => 'LBL_OBJECT_ID',
			'type' => 'id',
			'required' => true,
			'reportable'=>false,
		),
	),
	'relationships' => array (
		'queues_emails_rel' => array(
			'lhs_module'					=> 'Queues',
			'lhs_table'						=> 'queues',
			'lhs_key' 						=> 'id',
			'rhs_module'					=> 'Emails',
			'rhs_table'						=> 'emails',
			'rhs_key' 						=> 'id',
			'relationship_type' 			=> 'many-to-many',
			'join_table'					=> 'queues_beans', 
			'join_key_rhs'					=> 'object_id', 
			'join_key_lhs'					=> 'queue_id',
			'relationship_role_column'		=> 'module_dir',
			'relationship_role_column_value'=> 'Emails'		
		),
	), /* end relationship definitions */
	'indices' => array (
		array(
			'name' => 'queues_itemspk',
			'type' =>'primary',
			'fields' => array(
				'id'
			)
		),
		array(
		'name' =>'idx_queue_id',
		'type'=>'index',
		'fields' => array(
			'queue_id'
			)
		),
		array(
		'name' =>'idx_object_id',
		'type'=>'index',
		'fields' => array(
			'object_id'
			)
		),
	), /* end indices */
);

?>
