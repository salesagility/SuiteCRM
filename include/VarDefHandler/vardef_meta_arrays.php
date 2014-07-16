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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

//holds various filter arrays for displaying vardef dropdowns
//You can add your own if you would like

$vardef_meta_array = array (

	'standard_display' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id'),
			'name' => array('parent_type', 'deleted'),
		//end exclusion
		),
		'inc_override' => array(
			'type' => array('team_list'),
		//end inc_override
		),
		'ex_override' => array(
		//end ex_override
		)
	//end standard_display
	),
//////////////////////////////////////////////////////////////////
	'normal_trigger' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id', 'link', 'datetime', 'date','datetimecombo'),
			'custom_type' => array('id', 'link', 'datetime', 'date','datetimecombo'),
			'name' => array('assigned_user_name', 'parent_type', 'deleted','filename', 'file_mime_type', 'file_url'),
			'source' => array('non-db'),
		//end exclusion
		),

		'inc_override' => array(
			'type' => array('team_list', 'assigned_user_name'),
			'name' => array('email1', 'email2', 'assigned_user_id'),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('team_name'),
		//end ex_override
		)

	//end normal_trigger
	),
	//////////////////////////////////////////////////////////////////
	'normal_date_trigger' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id', 'link'),
			'custom_type' => array('id', 'link'),
			'name' => array('assigned_user_name', 'parent_type', 'deleted','filename', 'file_mime_type', 'file_url'),
			'source' => array('non-db'),
		//end exclusion
		),

		'inc_override' => array(
			'type' => array('team_list', 'assigned_user_name'),
			'name' => array('email1', 'email2', 'assigned_user_id'),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('team_name', 'account_name'),
		//end ex_override
		)

	//end normal_trigger
	),
//////////////////////////////////////////////////////////////////
	'time_trigger' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id', 'link', 'team_list', 'time'),
			'custom_type' => array('id', 'link', 'team_list', 'time'),
			'name' => array('parent_type', 'team_name', 'assigned_user_name', 'parent_type', 'deleted' ,'filename', 'file_mime_type', 'file_url'),
			'source' => array('non-db'),
		//end exclusion
		),

		'inc_override' => array(
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('date_entered'),
		//end ex_override
		)

	//end time_trigger
	),
//////////////////////////////////////////////////////////////////
	'action_filter' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id', 'link', 'datetime', 'time'),
			'custom_type' => array('id', 'link', 'datetime', 'time'),
			'source' => array('non-db'),
			'name' => array('created_by', 'parent_type', 'deleted', 'assigned_user_name', 'deleted' ,'filename', 'file_mime_type', 'file_url', 'resource_id'),
			'auto_increment' => array(true),
		//end exclusion
		),

		'inc_override' => array(
			'type' => array('team_list'),
			'name' => array('assigned_user_id', 'time_start', 'date_start', 'email1', 'email2', 'date_due', 'is_optout'),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('team_name', 'account_name'),
		//end ex_override
		)

	//end action_filter
	),
//////////////////////////////////////////////////////////////////
	'rel_filter' => array(
		'inclusion' =>	array(
			'type' => array('link'),
		//end inclusion
		),
		'exclusion' =>	array(
		'name' => array('direct_reports', 'accept_status'),
		//end exclusion
		),

		'inc_override' => array(
			'name' => array('accounts', 'account', 'member_of'),
		//end inc_override
		),
		'ex_override' => array(
			//'link_type' => array('one'),
			'name' => array('users'),
		    'module' => array('Users'),
		//end ex_override
		)

	//end rel_filter
	),
///////////////////////////////////////////////////////////
	'trigger_rel_filter' => array(
		'inclusion' =>	array(
			'type' => array('link'),
		//end inclusion
		),
		'exclusion' =>	array(
		'name' => array('direct_reports', 'accept_status'),
		//end exclusion
		),

		'inc_override' => array(
			'name' => array(),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('users', 'emails', 'product_bundles', 'email_addresses', 'email_addresses_primary', 'emailmarketing', 'tracked_urls', 'queueitems', 'log_entries', 'contract_types'),
			'module' => array('Users', 'Teams',
			    'CampaignLog'
			    ),
		//end ex_override
		)

	//end trigger_rel_filter
	),
///////////////////////////////////////////////////////////
	'alert_rel_filter' => array(
		'inclusion' =>	array(
			'type' => array('link'),
		//end inclusion
		),
		'exclusion' =>	array(
		'name' => array('direct_reports', 'accept_status'),
		//end exclusion
		),

		'inc_override' => array(
			'name' => array(),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('users', 'emails', 'product_bundles', 'email_addresses', 'email_addresses_primary', 'emailmarketing', 'tracked_urls', 'queueitems', 'log_entries', 'contract_types', 'reports_to_link'),
			'module' => array('Users', 'Teams',
			    'CampaignLog',
			    'Releases'),
		//end ex_override
		)

	//end alert_rel_filter
	),
///////////////////////////////////////////////////////////
	'template_filter' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id', 'link'),
			'custom_type' => array('id', 'link'),
			'source' => array('non-db'),
			'name' => array('created_by', 'parent_type', 'deleted', 'assigned_user_name', 'filename', 'file_mime_type', 'file_url'),
		//end exclusion
		),

		'inc_override' => array(
			'name' => array('assigned_user_id', 'assigned_user_name', 'modified_user_id', 'modified_by_name', 'created_by', 'created_by_name', 'full_name', 'email1', 'email2', 'team_name', 'shipper_name'),
            'type' => array('relate'),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('team_id'),
		//end ex_override
		)

	//end template_filter
	),
//////////////////////////////////////////////////////////////
	'alert_trigger' => array(
		'inclusion' =>	array(
		//end inclusion
		),
		'exclusion' =>	array(
			'type' => array('id', 'link', 'datetime', 'date'),
			'custom_type' => array('id', 'link', 'datetime', 'date'),
			'name' => array('assigned_user_name', 'parent_type', 'deleted', 'filename', 'file_mime_type', 'file_url'),
			'source' => array('non-db'),
		//end exclusion
		),

		'inc_override' => array(
			'type' => array('team_list', 'assigned_user_name'),
			'name' => array('full_name'),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('team_name', 'account_name'),
		//end ex_override
		)

	//end alert_trigger
	),
//////////////////////////////////////////////////////////////////
	'template_rel_filter' => array(
		'inclusion' =>	array(
			'type' => array('link'),
		//end inclusion
		),
		'exclusion' =>	array(
		'name' => array('direct_reports', 'accept_status'),
		//end exclusion
		),

		'inc_override' => array(
			'name' => array(),
		//end inc_override
		),
		'ex_override' => array(
			'name' => array('users', 'email_addresses', 'email_addresses_primary', 'emailmarketing', 'tracked_urls', 'queueitems', 'log_entries', 'reports_to_link'),
			'module' => array('Users', 'Teams',
			    'CampaignLog'
			    ),
		//end ex_override
		)

	//end template_rel_filter
	),
);

?>
