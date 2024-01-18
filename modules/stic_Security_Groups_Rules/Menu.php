<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings, $app_strings, $sugar_config, $current_user, $current_language;

if (is_admin($current_user)) {
    $admin_mod_strings = return_module_language($current_language, 'Administration');
    $module_menu[] = array("index.php?module=SecurityGroups&action=EditView&return_module=SecurityGroups&return_action=DetailView", translate('LNK_NEW_RECORD','SecurityGroups'), "Create_Security_Group");
    $module_menu[] = array("index.php?module=SecurityGroups&action=ListView&return_module=SecurityGroups&return_action=ListView",  translate('LNK_LIST','SecurityGroups'), "Security_Groups");
    $module_menu[] = array("index.php?module=Users&action=index&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_MANAGE_USERS_TITLE'], "Create");
    $module_menu[] = array("index.php?module=ACLRoles&action=index&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_MANAGE_ROLES_TITLE'], "Role_Management");
    $module_menu[] = array("index.php?module=SecurityGroups&action=config&return_module=SecurityGroups&return_action=ListView", $admin_mod_strings['LBL_CONFIG_SECURITYGROUPS_TITLE'], "Security_Suite_Settings");
    $module_menu[] = array("index.php?module=stic_Security_Groups_Rules&action=index&return_module=stic_Security_Groups_Rules&return_action=DetailView", $mod_strings['LBL_MODULE_NAME'], "stic_Security_Groups_Rules", 'stic_Security_Groups_Rules');
}
