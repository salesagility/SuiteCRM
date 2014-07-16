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

$moduleFilters = array(
	'Accounts' => array(
		'display_default' => false,
		'fields' => array(
			'account_type' => array(
				'display_name' => 'Account Type',
				'name' => 'account_type',
				'vname' => 'LBL_TYPE',
				'dbname' => 'account_type',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '4',
				'dropdown' => $app_list_strings['account_type_dom'],
			),
		),
	),
	'Bugs' => array(
		'display_default' => false,
		'fields' => array(
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '5',
				'dropdown' => $app_list_strings['bug_status_dom'],
			),
		),
	),
	'Calls' => array(
		'display_default' => false,
		'fields' => array(
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '3',
				'dropdown' => $app_list_strings['call_status_dom'],
			),
		),
	),
	
	'Cases' => array(
		'display_default' => false,
		'fields' => array(
			'priority' => array(
				'display_name' => 'Priority',
				'name' => 'priority',
				'vname' => 'LBL_PRIORITY',
				'dbname' => 'priority',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '3',
				'dropdown' => $app_list_strings['case_priority_dom'],
			),
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '3',
				'dropdown' => $app_list_strings['case_status_dom'],
			),
		),
	),
	
	'Opportunities' => array(
		'display_default' => false,
		'fields' => array(
			'sales_stage' => array(
				'display_name' => 'Sales Stage',
				'name' => 'sales_stage',
				'vname' => 'LBL_SALES_STAGE',
				'dbname' => 'sales_stage',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '4',
				'dropdown' => $app_list_strings['sales_stage_dom'],
			),
			'opportunity_type' => array(
				'display_name' => 'Opportunity Type',
				'name' => 'opportunity_type',
				'vname' => 'LBL_TYPE',
				'dbname' => 'opportunity_type',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '4',
				'dropdown' => $app_list_strings['opportunity_type_dom'],
			),
		),
	),
	'Tasks' => array(
		'display_default' => false,
		'fields' => array(
			'status' => array(
				'display_name' => 'Status',
				'name' => 'status',
				'vname' => 'LBL_STATUS',
				'dbname' => 'status',
				'custom_table' => false,
				'type' => 'multiselect',
				'size' => '5',
				'dropdown' => $app_list_strings['task_status_dom'],
			),
		),
	),
);

?>
