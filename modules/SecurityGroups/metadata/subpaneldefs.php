<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $modules_exempt_from_availability_check;
$modules_exempt_from_availability_check['ACLRoles'] = 'ACLRoles';

$layout_defs['SecurityGroups'] = array(
	// list of what Subpanels to show in the DetailView 
	'subpanel_setup' => array(

        'users' => array(
			'top_buttons' => array(	array('widget_class' => 'SubPanelTopSelectButton', 'mode' => 'MultiSelect', 'popup_module' => 'Users'),),
			'order' => 10,
			'module' => 'Users',
			'sort_by' => 'user_name',
			'sort_order' => 'asc',
			'subpanel_name' => 'default',
			'override_subpanel_name' => 'ForSecurityGroups',
			'get_subpanel_data' => 'users',
			'add_subpanel_data' => 'user_id',
			'title_key' => 'LBL_USERS_SUBPANEL_TITLE',
		),

        'aclroles' => array(
			'top_buttons' => array(array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'ACLRoles'),),
			'order' => 20,
			'sort_by' => 'name',
			'sort_order' => 'asc',
			'module' => 'ACLRoles',
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'aclroles',
			'add_subpanel_data' => 'role_id',
			'refresh_page'=>1,
			'title_key' => 'LBL_ROLES_SUBPANEL_TITLE',
		),

	),	
	
);
$layout_defs['SecurityGroupRoles'] = array(
	// sets up which panels to show, in which order, and with what linked_fields
	'subpanel_setup' => array(
        'aclroles' => array(
			'top_buttons' => array(array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'ACLRoles', 'mode' => 'MultiSelect'),),
			'order' => 20,
			'sort_by' => 'name',
			'sort_order' => 'asc',
			'module' => 'ACLRoles',
			'refresh_page'=>1,
			'subpanel_name' => 'default',
			'get_subpanel_data' => 'aclroles',
			'add_subpanel_data' => 'role_id',
			'title_key' => 'LBL_ROLES_SUBPANEL_TITLE',
		),
	),
	);
global $current_user;
if(is_admin($current_user)){
	$layout_defs['SecurityGroups']['subpanel_setup']['aclroles']['subpanel_name'] = 'admin';
	$layout_defs['SecurityGroupRoles']['subpanel_setup']['aclroles']['subpanel_name'] = 'admin';
}else{
	
	$layout_defs['SecurityGroups']['subpanel_setup']['aclroles']['top_buttons'] = array();
	
	$layout_defs['SecurityGroupRoles']['subpanel_setup']['aclroles']['top_buttons'] = array();
}
