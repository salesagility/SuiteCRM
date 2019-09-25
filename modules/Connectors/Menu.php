<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


global $mod_strings;
global $current_user;
$actions = array('ModifyProperties', 'ModifyDisplay',
'ModifyMapping', 'ConnectorSettings');
if (in_array($GLOBALS['action'], $actions)) {
    $module_menu[]=array("index.php?module=Connectors&action=ConnectorSettings", $mod_strings['LBL_ADMINISTRATION_MAIN'],"icon_Connectors");
    $module_menu[]=array("index.php?module=Connectors&action=ModifyProperties", $mod_strings['LBL_MODIFY_PROPERTIES_TITLE'],"icon_ConnectorConfig_16");
    $module_menu[]=array("index.php?module=Connectors&action=ModifyDisplay", $mod_strings['LBL_MODIFY_DISPLAY_TITLE'],"icon_ConnectorEnable_16");
    $module_menu[]=array("index.php?module=Connectors&action=ModifyMapping", $mod_strings['LBL_MODIFY_MAPPING_TITLE'],"icon_ConnectorMap_16");
}

if (!empty($_REQUEST['merge_module']) && ($GLOBALS['action'] == 'Step1' || $GLOBALS['action'] == 'Step2')) {
    $merge_module = $_REQUEST['merge_module'];
    $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $merge_module);
    if (file_exists("custom/modules/{$merge_module}/Menu.php")) {
        require("custom/modules/{$merge_module}/Menu.php");
    } else {
        if (file_exists("modules/{$merge_module}/Menu.php")) {
            require("modules/{$merge_module}/Menu.php");
        }
    }
    $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $GLOBALS['module']);
}
