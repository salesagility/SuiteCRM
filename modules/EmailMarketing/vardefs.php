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


$dictionary['EmailMarketing'] = array(
	'table' => 'email_marketing',
	'fields' => array (
 	'id' =>
  	array (
	    'name' => 'id',
	    'vname' => 'LBL_NAME',
	    'type' => 'id',
	    'required'=>true,
  	),
  	'deleted' => array (
		'name' => 'deleted',
		'vname' => 'LBL_CREATED_BY',
		'type' => 'bool',
		'required' => false,
		'reportable'=>false,
	),
	'date_entered' =>
  	array (
		'name' => 'date_entered',
    	'vname' => 'LBL_DATE_ENTERED',
    	'type' => 'datetime',
    	'required'=>true,
  	),
  	'date_modified' =>
  	array (
	    'name' => 'date_modified',
	    'vname' => 'LBL_DATE_MODIFIED',
	    'type' => 'datetime',
     	'required'=>true,
  	),
  	'modified_user_id' =>
  	array (
	    'name' => 'modified_user_id',
	    'rname' => 'user_name',
	    'id_name' => 'modified_user_id',
	    'vname' => 'LBL_MODIFIED_BY',
	    'type' => 'assigned_user_name',
	    'table' => 'users',
	    'isnull' => 'false',
	    'dbType' => 'id'
  	),
	'created_by' =>
  	array (
    	'name' => 'created_by',
    	'rname' => 'user_name',
    	'id_name' => 'modified_user_id',
    	'vname' => 'LBL_CREATED_BY',
    	'type' => 'assigned_user_name',
    	'table' => 'users',
    	'isnull' => 'false',
    	'dbType' => 'id'
  	),
  	'name' =>
  	array (
	    'name' => 'name',
	    'vname' => 'LBL_NAME',
	    'type' => 'varchar',
	    'len' => '255',
	    'importable' => 'required',
  		'required' => true
  	),
  	'from_name' =>  //starting from 4.0 from_name is obsolete..replaced with inbound_email_id
  	array (
	    'name' => 'from_name',
	    'vname' => 'LBL_FROM_NAME',
	    'type' => 'varchar',
	    'len' => '100',
	    'importable' => 'required',
  		'required' => true
  	),
  	'from_addr' =>
  	array (
	    'name' => 'from_addr',
    	'vname' => 'LBL_FROM_ADDR',
    	'type' => 'varchar',
    	'len' => '100',
    	'importable' => 'required',
  		'required' => true
  	),
  	'reply_to_name' =>
  	array (
	    'name' => 'reply_to_name',
	    'vname' => 'LBL_REPLY_NAME',
	    'type' => 'varchar',
	    'len' => '100',
  	),
  	'reply_to_addr' =>
  	array (
	    'name' => 'reply_to_addr',
    	'vname' => 'LBL_REPLY_ADDR',
    	'type' => 'varchar',
    	'len' => '100',
  	),
  	'inbound_email_id' =>
  	array (
	    'name' => 'inbound_email_id',
	    'vname' => 'LBL_FROM_MAILBOX',
	    'type' => 'varchar',
	    'len' => '36',
  	),
  	'date_start' =>
  	array (
	    'name' => 'date_start',
    	'vname' => 'LBL_DATE_START',
    	'type' => 'datetime',
    	'importable' => 'required',
  		'required' => true
    	),

  	'template_id' =>
  	array (
	    'name' => 'template_id',
	    'vname' => 'LBL_TEMPLATE',
	    'type' => 'id',
	    'required'=>true,
	    'importable' => 'required',
  	),
  	'status' =>
  	array (
	    'name' => 'status',
	    'vname' => 'LBL_STATUS',
	    'type' => 'enum',
	    'len' => 100,
		'required'=>true,
		'options' => 'email_marketing_status_dom',
		'importable' => 'required',
  	),
  	'campaign_id' =>
  	array (
	    'name' => 'campaign_id',
	    'vname' => 'LBL_CAMPAIGN_ID',
	    'type' => 'id',
	    'isnull' => true,
	    'required'=>false,
  	),

		'outbound_email_id'=> array (
			'name' => 'outbound_email_id',
			'vname' => 'LBL_OUTBOUND_EMAIL_ACOUNT_ID',
			'type' => 'id',
			'isnull' => true,
			'required'=>false,
		),

  	'all_prospect_lists' => array (
		'name' => 'all_prospect_lists',
		'vname' => 'LBL_ALL_PROSPECT_LISTS',
		'type' => 'bool',
		'default'=> 0,
	),
//no-db-fields.
	'template_name' =>
  	array (
	    'name' => 'template_name',
	    'rname' => 'name',
	    'id_name' => 'template_id',
	    'vname' => 'LBL_TEMPLATE_NAME',
	    'type' => 'relate',
	    'table' => 'email_templates',
	    'isnull' => 'true',
	    'module' => 'EmailTemplates',
	    'dbType' => 'varchar',
	    'link'=>'emailtemplate',
	    'len' => '255',
   	 	'source'=>'non-db',
  	),
  	'prospect_list_name' =>
  	array (
	    'name' => 'prospect_list_name',
	    'vname' => 'LBL_PROSPECT_LIST_NAME',
	    'type' => 'varchar',
	    'len'=>100,
	    'source'=>'non-db',
  	),

//related fields.
	'prospectlists'=> array (
		'name' => 'prospectlists',
		'vname' => 'LBL_PROSPECT_LISTS',
    	'type' => 'link',
    	'relationship' => 'email_marketing_prospect_lists',
    	'source'=>'non-db',
  	),
	'emailtemplate'=> array (
		'name' => 'emailtemplate',
		'vname' => 'LBL_EMAIL_TEMPLATE',
    	'type' => 'link',
    	'relationship' => 'email_template_email_marketings',
    	'source'=>'non-db',
  	),
  ),
  'indices' => array (
       array('name' =>'emmkpk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_emmkt_name', 'type'=>'index', 'fields'=>array('name')),
       array('name' =>'idx_emmkit_del', 'type'=>'index', 'fields'=>array('deleted')),
  ),
  'relationships' => array (
	'email_template_email_marketings' => array(
		'lhs_module'=> 'EmailTemplates',
		'lhs_table'=> 'email_templates',
		'lhs_key' => 'id',
		'rhs_module'=> 'EmailMarketing',
		'rhs_table'=> 'email_marketing',
		'rhs_key' => 'template_id',
		'relationship_type'=>'one-to-many'
	),
  ),
);

