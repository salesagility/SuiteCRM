<?php

function install_ss() {
	//eggsurplus: set up default config options

    require_once('sugar_version.php');
	require_once('modules/Administration/Administration.php');
	global $sugar_config;

	/** If this is the first install set some default settings */
	if(!array_key_exists('securitysuite_additive',$sugar_config) ) {
		// save securitysuite_additive setting
		$sugar_config['securitysuite_additive'] = true;
		// save securitysuite_user_role_precedence setting
		$sugar_config['securitysuite_user_role_precedence'] = true;
		// save securitysuite_user_popup setting
		$sugar_config['securitysuite_user_popup'] = true;
		// save securitysuite_popup_select setting
		$sugar_config['securitysuite_popup_select'] = false;
		// save securitysuite_inherit_creator setting
		$sugar_config['securitysuite_inherit_creator'] = true;
		// save securitysuite_inherit_parent setting
		$sugar_config['securitysuite_inherit_parent'] = true;
		// save securitysuite_inherit_assigned setting
		$sugar_config['securitysuite_inherit_assigned'] = true;
		// save securitysuite_strict_rights setting
		$sugar_config['securitysuite_strict_rights'] = false;

		//ksort($sugar_config);
		//write_array_to_file('sugar_config', $sugar_config, 'config.php');
	}

	if(!array_key_exists('securitysuite_strict_rights',$sugar_config) ) {
		// save securitysuite_strict_rights setting
		$sugar_config['securitysuite_strict_rights'] = true;

		//ksort($sugar_config);
		//write_array_to_file('sugar_config', $sugar_config, 'config.php');
	}

	if(!array_key_exists('securitysuite_filter_user_list',$sugar_config) ) {
		// save securitysuite_filter_user_list setting
		$sugar_config['securitysuite_filter_user_list'] = false;

		//ksort($sugar_config);
		//write_array_to_file('sugar_config', $sugar_config, 'config.php');
	}
	
	if(!isset($GLOBALS['sugar_config']['addAjaxBannedModules'])) {
		$GLOBALS['sugar_config']['addAjaxBannedModules'] = array();
	}
	$GLOBALS['sugar_config']['addAjaxBannedModules'][] = 'SecurityGroups';

	$sugar_config['securitysuite_version'] = '6.5.17';
	ksort($sugar_config);
	write_array_to_file('sugar_config', $sugar_config, 'config.php');
}
?>