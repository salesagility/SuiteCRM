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

global $mod_strings, $app_strings, $sugar_config;
 
if(ACLController::checkAccess('stic_Payment_Commitments', 'edit', true)){
    $module_menu[]=array('index.php?module=stic_Payment_Commitments&action=EditView&return_module=stic_Payment_Commitments&return_action=DetailView', $mod_strings['LNK_NEW_RECORD'], 'Add', 'stic_Payment_Commitments');
}
if(ACLController::checkAccess('stic_Payment_Commitments', 'list', true)){
    $module_menu[]=array('index.php?module=stic_Payment_Commitments&action=index&return_module=stic_Payment_Commitments&return_action=DetailView', $mod_strings['LNK_LIST'],'View', 'stic_Payment_Commitments');
}
if(ACLController::checkAccess('stic_Payment_Commitments', 'import', true)){
    $module_menu[]=array('index.php?module=Import&action=Step1&import_module=stic_Payment_Commitments&return_module=stic_Payment_Commitments&return_action=index', $app_strings['LBL_IMPORT'], 'Import', 'stic_Payment_Commitments');
}