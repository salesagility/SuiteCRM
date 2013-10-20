<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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
?>
