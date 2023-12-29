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

if (ACLController::checkAccess('stic_Payments', 'edit', true)) {
    $module_menu[] = array('index.php?module=stic_Payments&action=EditView&return_module=stic_Payments&return_action=DetailView', $mod_strings['LNK_NEW_RECORD'], 'Add', 'stic_Payments');
}
if (ACLController::checkAccess('stic_Payments', 'list', true)) {
    $module_menu[] = array('index.php?module=stic_Payments&action=index&return_module=stic_Payments&return_action=DetailView', $mod_strings['LNK_LIST'], 'View', 'stic_Payments');
}
if (ACLController::checkAccess('stic_Payments', 'import', true)) {
    $module_menu[] = array('index.php?module=Import&action=Step1&import_module=stic_Payments&return_module=stic_Payments&return_action=index', $app_strings['LBL_IMPORT'], 'Import', 'stic_Payments');
}

// Add custom menu item for M182
if (ACLController::checkAccess('stic_Payments', 'list', true)) {
    $module_menu[] = array('index.php?module=stic_Payments&action=model182Wizard', $mod_strings['LBL_M182_TITLE'], 'm182', 'stic_Payments');
}

// Add custom menu item for Aggegated payments
if (ACLController::checkAccess('stic_Payments', 'list', true)) {
    $module_menu[] = array('index.php?module=stic_Payments&action=aggregatePayments', $mod_strings['LBL_AGGREGATED_PAYMENTS_MENU'], 'payments-aggregated', 'stic_Payments');
}
