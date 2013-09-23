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





global $mod_strings;

// the initial settings for the template variables to fill
$config_check           = '';
$config_file_ready      = false;
$lbl_rebuild_config     = $mod_strings['LBL_REBUILD_CONFIG'];
$btn_rebuild_config     = $mod_strings['BTN_REBUILD_CONFIG'];
$disable_config_rebuild = 'disabled="disabled"';

// check the status of the config file
if( is_writable('config.php') ){
    $config_check = $mod_strings['MSG_CONFIG_FILE_READY_FOR_REBUILD'];
    $disable_config_rebuild = '';
    $config_file_ready = true;
}
else {
    $config_check = $mod_strings['MSG_MAKE_CONFIG_FILE_WRITABLE'];
}

// only do the rebuild if config file checks out and user has posted back
if( !empty($_POST['perform_rebuild']) && $config_file_ready ){

    // retrieve configuration from file so that contents of config_override.php
    // is not merged (bug #54403)
    $clean_config = loadCleanConfig();
    if ( rebuildConfigFile($clean_config, $sugar_version) ) {
    	$config_check = $mod_strings['MSG_CONFIG_FILE_REBUILD_SUCCESS'];
        $disable_config_rebuild = 'disabled="disabled"';
    }
    else {
        $config_check = $mod_strings['MSG_CONFIG_FILE_REBUILD_FAILED'];
    }	

}

/////////////////////////////////////////////////////////////////////
// TEMPLATE ASSIGNING
$xtpl = new XTemplate('modules/Administration/RebuildConfig.html');
$xtpl->assign('LBL_CONFIG_CHECK', $mod_strings['LBL_CONFIG_CHECK']);
$xtpl->assign('CONFIG_CHECK', $config_check);
$xtpl->assign('LBL_PERFORM_REBUILD', $lbl_rebuild_config);
$xtpl->assign('DISABLE_CONFIG_REBUILD', $disable_config_rebuild);
$xtpl->assign('BTN_PERFORM_REBUILD', $btn_rebuild_config);
$xtpl->parse('main');
$xtpl->out('main');
?>
