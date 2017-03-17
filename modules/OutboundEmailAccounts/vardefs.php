<?php
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

 $dictionary["OutboundEmailAccounts"]=array (
	 'table' => 'outbound_email',
	 'audited' => true,
	 'inline_edit' => true,
	 'duplicate_merge' => true,
	 'fields' =>
		 array (
			 'id' =>
				 array (
					 'name' => 'id',
					 'vname' => 'LBL_ID',
					 'type' => 'id',
					 'required' => true,
					 'reportable' => true,
					 'comment' => 'Unique identifier',
					 'inline_edit' => false,
				 ),
			 'name' =>
				 array (
					 'name' => 'name',
					 'vname' => 'LBL_NAME',
					 'type' => 'name',
					 'link' => true,
					 'dbType' => 'varchar',
					 'len' => 255,
					 'unified_search' => true,
					 'full_text_search' =>
						 array (
							 'boost' => 3,
						 ),
					 'required' => true,
					 'importable' => 'required',
					 'duplicate_merge' => 'enabled',
					 'merge_filter' => 'selected',
				 ),
			 'date_entered' =>
				 array (
					 'name' => 'date_entered',
					 'vname' => 'LBL_DATE_ENTERED',
					 'type' => 'datetime',
					 'group' => 'created_by_name',
					 'comment' => 'Date record created',
					 'enable_range_search' => true,
					 'options' => 'date_range_search_dom',
					 'inline_edit' => false,
				 ),
			 'date_modified' =>
				 array (
					 'name' => 'date_modified',
					 'vname' => 'LBL_DATE_MODIFIED',
					 'type' => 'datetime',
					 'group' => 'modified_by_name',
					 'comment' => 'Date record last modified',
					 'enable_range_search' => true,
					 'options' => 'date_range_search_dom',
					 'inline_edit' => false,
				 ),
			 'modified_user_id' =>
				 array (
					 'name' => 'modified_user_id',
					 'rname' => 'user_name',
					 'id_name' => 'modified_user_id',
					 'vname' => 'LBL_MODIFIED',
					 'type' => 'assigned_user_name',
					 'table' => 'users',
					 'isnull' => 'false',
					 'group' => 'modified_by_name',
					 'dbType' => 'id',
					 'reportable' => true,
					 'comment' => 'User who last modified record',
					 'massupdate' => false,
					 'inline_edit' => false,
				 ),
			 'modified_by_name' =>
				 array (
					 'name' => 'modified_by_name',
					 'vname' => 'LBL_MODIFIED_NAME',
					 'type' => 'relate',
					 'reportable' => false,
					 'source' => 'non-db',
					 'rname' => 'user_name',
					 'table' => 'users',
					 'id_name' => 'modified_user_id',
					 'module' => 'Users',
					 'link' => 'modified_user_link',
					 'duplicate_merge' => 'disabled',
					 'massupdate' => false,
					 'inline_edit' => false,
				 ),
			 'created_by' =>
				 array (
					 'name' => 'created_by',
					 'rname' => 'user_name',
					 'id_name' => 'modified_user_id',
					 'vname' => 'LBL_CREATED',
					 'type' => 'assigned_user_name',
					 'table' => 'users',
					 'isnull' => 'false',
					 'dbType' => 'id',
					 'group' => 'created_by_name',
					 'comment' => 'User who created record',
					 'massupdate' => false,
					 'inline_edit' => false,
				 ),
			 'created_by_name' =>
				 array (
					 'name' => 'created_by_name',
					 'vname' => 'LBL_CREATED',
					 'type' => 'relate',
					 'reportable' => false,
					 'link' => 'created_by_link',
					 'rname' => 'user_name',
					 'source' => 'non-db',
					 'table' => 'users',
					 'id_name' => 'created_by',
					 'module' => 'Users',
					 'duplicate_merge' => 'disabled',
					 'importable' => 'false',
					 'massupdate' => false,
					 'inline_edit' => false,
				 ),
//			 'description' =>
//				 array (
//					 'name' => 'description',
//					 'vname' => 'LBL_DESCRIPTION',
//					 'type' => 'text',
//					 'comment' => 'Full text of the note',
//					 'rows' => 6,
//					 'cols' => 80,
//				 ),
			 'deleted' =>
				 array (
					 'name' => 'deleted',
					 'vname' => 'LBL_DELETED',
					 'type' => 'bool',
					 'default' => '0',
					 'reportable' => false,
					 'comment' => 'Record deletion indicator',
				 ),
			 'created_by_link' =>
				 array (
					 'name' => 'created_by_link',
					 'type' => 'link',
					 'relationship' => 'outbound_email_created_by',
					 'vname' => 'LBL_CREATED_USER',
					 'link_type' => 'one',
					 'module' => 'Users',
					 'bean_name' => 'User',
					 'source' => 'non-db',
				 ),
			 'modified_user_link' =>
				 array (
					 'name' => 'modified_user_link',
					 'type' => 'link',
					 'relationship' => 'outbound_email_modified_user',
					 'vname' => 'LBL_MODIFIED_USER',
					 'link_type' => 'one',
					 'module' => 'Users',
					 'bean_name' => 'User',
					 'source' => 'non-db',
				 ),
			 'assigned_user_id' =>
				 array (
					 'name' => 'assigned_user_id',
					 'rname' => 'user_name',
					 'id_name' => 'assigned_user_id',
					 'vname' => 'LBL_ASSIGNED_TO_ID',
					 'group' => 'assigned_user_name',
					 'type' => 'relate',
					 'table' => 'users',
					 'module' => 'Users',
					 'reportable' => true,
					 'isnull' => 'false',
					 'dbType' => 'id',
					 'audited' => true,
					 'comment' => 'User ID assigned to record',
					 'duplicate_merge' => 'disabled',
				 ),
			 'assigned_user_name' =>
				 array (
					 'name' => 'assigned_user_name',
					 'link' => 'assigned_user_link',
					 'vname' => 'LBL_ASSIGNED_TO_NAME',
					 'rname' => 'user_name',
					 'type' => 'relate',
					 'reportable' => false,
					 'source' => 'non-db',
					 'table' => 'users',
					 'id_name' => 'assigned_user_id',
					 'module' => 'Users',
					 'duplicate_merge' => 'disabled',
				 ),
			 'assigned_user_link' =>
				 array (
					 'name' => 'assigned_user_link',
					 'type' => 'link',
					 'relationship' => 'outbound_email_assigned_user',
					 'vname' => 'LBL_ASSIGNED_TO_USER',
					 'link_type' => 'one',
					 'module' => 'Users',
					 'bean_name' => 'User',
					 'source' => 'non-db',
					 'duplicate_merge' => 'enabled',
					 'rname' => 'user_name',
					 'id_name' => 'assigned_user_id',
					 'table' => 'users',
				 ),
//			 'username' =>
//				 array (
//					 'required' => true,
//					 'name' => 'username',
//					 'vname' => 'LBL_USERNAME',
//					 'type' => 'varchar',
//					 'massupdate' => 0,
//					 'no_default' => false,
//					 'comments' => '',
//					 'help' => '',
//					 'importable' => 'true',
//					 'duplicate_merge' => 'disabled',
//					 'duplicate_merge_dom_value' => '0',
//					 'audited' => false,
//					 'inline_edit' => true,
//					 'reportable' => true,
//					 'unified_search' => false,
//					 'merge_filter' => 'disabled',
//					 'len' => '255',
//					 'size' => '20',
//				 ),
//			 'password' =>
//				 array (
//					 'required' => false,
//					 'name' => 'password',
//					 'vname' => 'LBL_PASSWORD',
//					 'type' => 'varchar',
//					 'massupdate' => 0,
//					 'no_default' => false,
//					 'comments' => '',
//					 'help' => '',
//					 'importable' => 'true',
//					 'duplicate_merge' => 'disabled',
//					 'duplicate_merge_dom_value' => '0',
//					 'audited' => false,
//					 'inline_edit' => true,
//					 'reportable' => true,
//					 'unified_search' => false,
//					 'merge_filter' => 'disabled',
//					 'len' => '255',
//					 'size' => '20',
//				 ),
			 'password_change' =>
				 array (
					 'required' => false,
					 'name' => 'password_change',
					 'vname' => 'LBL_PASSWORD',
					 'type' => 'function',
					 'source' => 'non-db',
					 'massupdate' => 0,
					 'no_default' => false,
					 'comments' => '',
					 'help' => '',
					 'importable' => 'true',
					 'duplicate_merge' => 'disabled',
					 'duplicate_merge_dom_value' => '0',
					 'audited' => false,
					 'inline_edit' => true,
					 'reportable' => true,
					 'unified_search' => false,
					 'merge_filter' => 'disabled',
					 'len' => '255',
					 'size' => '20',
					 'function' => array(
						 'name' => 'OutboundEmailAccounts::getPasswordChange',
						 'returns' => 'html',
						 'include' => 'modules/OutboundEmailAccounts/OutboundEmailAccounts.php'
					 ),
				 ),
			 'email_provider_chooser' => array (
				 'required' => false,
				 'name' => 'email_provider_chooser',
				 'vname' => 'LBL_CHOOSE_EMAIL_PROVIDER',
				 'type' => 'function',
				 'source' => 'non-db',
				 'massupdate' => 0,
				 'no_default' => false,
				 'comments' => '',
				 'help' => '',
				 'importable' => 'true',
				 'duplicate_merge' => 'disabled',
				 'duplicate_merge_dom_value' => '0',
				 'audited' => false,
				 'inline_edit' => true,
				 'reportable' => true,
				 'unified_search' => false,
				 'merge_filter' => 'disabled',
				 'len' => '255',
				 'size' => '20',
				 'function' => array(
					 'name' => 'OutboundEmailAccounts::getEmailProviderChooser',
					 'returns' => 'html',
					 'include' => 'modules/OutboundEmailAccounts/OutboundEmailAccounts.php'
				 ),
			 ),
			 'sent_test_email_btn' => array(
				 'required' => false,
				 'name' => 'sent_test_email_btn',
				 'vname' => 'LBL_SEND_TEST_EMAIL',
				 'type' => 'function',
				 'source' => 'non-db',
				 'massupdate' => 0,
				 'no_default' => false,
				 'comments' => '',
				 'help' => '',
				 'importable' => 'true',
				 'duplicate_merge' => 'disabled',
				 'duplicate_merge_dom_value' => '0',
				 'audited' => false,
				 'inline_edit' => true,
				 'reportable' => true,
				 'unified_search' => false,
				 'merge_filter' => 'disabled',
				 'len' => '255',
				 'size' => '20',
				 'function' => array(
					 'name' => 'OutboundEmailAccounts::getSendTestEmailBtn',
					 'returns' => 'html',
					 'include' => 'modules/OutboundEmailAccounts/OutboundEmailAccounts.php'
				 ),
			 ),
//			 'smtp_servername' =>
//				 array (
//					 'required' => true,
//					 'name' => 'smtp_servername',
//					 'vname' => 'LBL_SMTP_SERVERNAME',
//					 'type' => 'varchar',
//					 'massupdate' => 0,
//					 'no_default' => false,
//					 'comments' => '',
//					 'help' => '',
//					 'importable' => 'true',
//					 'duplicate_merge' => 'disabled',
//					 'duplicate_merge_dom_value' => '0',
//					 'audited' => false,
//					 'inline_edit' => true,
//					 'reportable' => true,
//					 'unified_search' => false,
//					 'merge_filter' => 'disabled',
//					 'len' => '255',
//					 'size' => '20',
//				 ),
//			 'smtp_auth' =>
//				 array (
//					 'required' => false,
//					 'name' => 'smtp_auth',
//					 'vname' => 'LBL_SMTP_AUTH',
//					 'type' => 'bool',
//					 'massupdate' => 0,
//					 'default' => '1',
//					 'no_default' => false,
//					 'comments' => '',
//					 'help' => '',
//					 'importable' => 'true',
//					 'duplicate_merge' => 'disabled',
//					 'duplicate_merge_dom_value' => '0',
//					 'audited' => false,
//					 'inline_edit' => true,
//					 'reportable' => true,
//					 'unified_search' => false,
//					 'merge_filter' => 'disabled',
//					 'len' => '255',
//					 'size' => '20',
//				 ),
//			 'smtp_port' =>
//				 array (
//					 'required' => true,
//					 'name' => 'smtp_port',
//					 'vname' => 'LBL_SMTP_PORT',
//					 'type' => 'int',
//					 'massupdate' => 0,
//					 'default' => '587',
//					 'no_default' => false,
//					 'comments' => '',
//					 'help' => '',
//					 'importable' => 'true',
//					 'duplicate_merge' => 'disabled',
//					 'duplicate_merge_dom_value' => '0',
//					 'audited' => false,
//					 'inline_edit' => true,
//					 'reportable' => true,
//					 'unified_search' => false,
//					 'merge_filter' => 'disabled',
//					 'len' => '11',
//					 'size' => '20',
//					 'enable_range_search' => false,
//					 'disable_num_format' => '1',
//					 'min' => false,
//					 'max' => false,
//				 ),
//			 'smtp_protocol' =>
//				 array (
//					 'required' => false,
//					 'name' => 'smtp_protocol',
//					 'vname' => 'LBL_SMTP_PROTOCOL',
//					 'type' => 'enum',
//					 'massupdate' => 0,
//					 'default' => '0',
//					 'no_default' => false,
//					 'comments' => '',
//					 'help' => '',
//					 'importable' => 'true',
//					 'duplicate_merge' => 'disabled',
//					 'duplicate_merge_dom_value' => '0',
//					 'audited' => false,
//					 'inline_edit' => true,
//					 'reportable' => true,
//					 'unified_search' => false,
//					 'merge_filter' => 'disabled',
//					 'len' => 100,
//					 'size' => '20',
//					 'options' => 'email_settings_for_ssl',
//					 'studio' => 'visible',
//					 'dependency' => false,
//				 ),
		 ),
	 'relationships' =>
		 array (
			 'outbound_email_modified_user' =>
				 array (
					 'lhs_module' => 'Users',
					 'lhs_table' => 'users',
					 'lhs_key' => 'id',
					 'rhs_module' => 'OutboundEmailAccounts',
					 'rhs_table' => 'outbound_email',
					 'rhs_key' => 'modified_user_id',
					 'relationship_type' => 'one-to-many',
				 ),
			 'outbound_email_created_by' =>
				 array (
					 'lhs_module' => 'Users',
					 'lhs_table' => 'users',
					 'lhs_key' => 'id',
					 'rhs_module' => 'OutboundEmailAccounts',
					 'rhs_table' => 'outbound_email',
					 'rhs_key' => 'created_by',
					 'relationship_type' => 'one-to-many',
				 ),
			 'outbound_email_assigned_user' =>
				 array (
					 'lhs_module' => 'Users',
					 'lhs_table' => 'users',
					 'lhs_key' => 'id',
					 'rhs_module' => 'OutboundEmailAccounts',
					 'rhs_table' => 'outbound_email',
					 'rhs_key' => 'assigned_user_id',
					 'relationship_type' => 'one-to-many',
				 ),
		 ),
	 'optimistic_locking' => true,
	 'unified_search' => true,
	 'indices' =>
		 array (
			 'id' =>
				 array (
					 'name' => 'outbound_email_pk',
					 'type' => 'primary',
					 'fields' =>
						 array (
							 0 => 'id',
						 ),
				 ),
		 ),
//	 'templates' =>
//		 array (
//			 'assignable' => 'assignable',
//			 'basic' => 'basic',
//		 ),
	 'custom_fields' => false,
 );

//if (!class_exists('VardefManager')){
//        require_once('include/SugarObjects/VardefManager.php');
//}
//VardefManager::createVardef('OutboundEmailAccounts','OutboundEmailAccounts', array('basic','assignable'));

include 'metadata/outboundEmailMetaData.php';

if(isset($dictionary['OutboundEmail']['fields'])) {
    $dictionary['OutboundEmailAccounts']['fields'] = array_merge($dictionary['OutboundEmailAccounts']['fields'], $dictionary['OutboundEmail']['fields']);
}
if(isset($dictionary['OutboundEmail']['indices'])) {
    $dictionary['OutboundEmailAccounts']['indices'] = array_merge($dictionary['OutboundEmailAccounts']['indices'], $dictionary['OutboundEmail']['indices']);
}

$dictionary['OutboundEmailAccounts']['fields']['mail_smtpssl']['type'] = 'enum';
$dictionary['OutboundEmailAccounts']['fields']['mail_smtpssl']['options'] = 'email_settings_for_ssl';
