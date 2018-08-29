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


$popupMeta = array (
    'moduleMain' => 'Lead',
    'varName' => 'LEAD',
    'orderBy' => 'last_name, first_name',
    'whereClauses' => array (
		'first_name' => 'leads.first_name',
		'last_name' => 'leads.last_name',
		'lead_source' => 'leads.lead_source',
		'status' => 'leads.status',
		'account_name' => 'leads.account_name',
		'assigned_user_id' => 'leads.assigned_user_id',
	),
    'searchInputs' => array (
	  0 => 'first_name',
	  1 => 'last_name',
	  2 => 'lead_source',
	  3 => 'status',
	  4 => 'account_name',
	  5 => 'assigned_user_id',
	),
    'searchdefs' => array (
	  'first_name' => 
	  array (
	    'name' => 'first_name',
	    'width' => '10%',
	  ),
	  'last_name' => 
	  array (
	    'name' => 'last_name',
	    'width' => '10%',
	  ),
	  'email',
	  'account_name' => 
	  array (
	    'type' => 'varchar',
	    'label' => 'LBL_ACCOUNT_NAME',
	    'width' => '10%',
	    'name' => 'account_name',
	  ),
	  'lead_source' => 
	  array (
	    'name' => 'lead_source',
	    'width' => '10%',
	  ),
	  'status' => 
	  array (
	    'name' => 'status',
	    'width' => '10%',
	  ),
	  'assigned_user_id' => 
	  array (
	    'name' => 'assigned_user_id',
	    'type' => 'enum',
	    'label' => 'LBL_ASSIGNED_TO',
	    'function' => 
	    array (
	      'name' => 'get_user_array',
	      'params' => 
	      array (
	        0 => false,
	      ),
	    ),
	    'width' => '10%',
	  ),
	),
    'listviewdefs' => array (
	  'NAME' => 
	  array (
	    'width' => '30%',
	    'label' => 'LBL_LIST_NAME',
	    'link' => true,
	    'default' => true,
	    'related_fields' => 
	    array (
	      0 => 'first_name',
	      1 => 'last_name',
	      2 => 'salutation',
	    ),
	    'name' => 'name',
	  ),
	  'ACCOUNT_NAME' => 
	  array (
	    'type' => 'varchar',
	    'label' => 'LBL_ACCOUNT_NAME',
	    'width' => '10%',
	    'default' => true,
	    'name' => 'account_name',
	  ),
	  'STATUS' => 
	  array (
	    'width' => '10%',
	    'label' => 'LBL_LIST_STATUS',
	    'default' => true,
	    'name' => 'status',
	  ),
	  'LEAD_SOURCE' => 
	  array (
	    'width' => '10%',
	    'label' => 'LBL_LEAD_SOURCE',
	    'default' => true,
	    'name' => 'lead_source',
	  ),
	  'ASSIGNED_USER_NAME' => 
	  array (
	    'width' => '10%',
	    'label' => 'LBL_LIST_ASSIGNED_USER',
	    'default' => true,
	    'name' => 'assigned_user_name',
	  ),
	),
);
