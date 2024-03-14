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

$dictionary['stic_Sepe_Files'] = array(
    'table' => 'stic_sepe_files',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'status' =>
        array(
            'required' => true,
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'massupdate' => '1',
            'no_default' => false,
            'importable' => 'true',
            'duplicate_merge' => 'enabled', 
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_sepe_file_status_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'type' =>
        array(
            'required' => true,
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'importable' => 'true',
            'duplicate_merge' => 'enabled', 
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_sepe_file_types_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'reported_month' =>
        array(
            'required' => true,
            'name' => 'reported_month',
            'vname' => 'LBL_REPORTED_MONTH',
            'type' => 'date',
            'massupdate' => 0,
            'no_default' => false,
            'importable' => 'true',
            'duplicate_merge' => 'enabled', 
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'size' => '20',
            'enable_range_search' => '1',
            'options' => 'date_range_search_dom',
            'popupHelp' => 'LBL_REPORTED_MONTH_HELP',
        ),
        'log' =>
        array(
            'required' => false,
            'name' => 'log',
            'vname' => 'LBL_LOG',
            'type' => 'html',
            'massupdate' => 0,
            'inline_edit' => 0,
            'rows' => 40,
            'cols' => 90,
            'studio' => array(
                'no_duplicate' => true,
                'editview' => false,
                'quickcreate' => false,
            ),
        ),
        'agreement' =>
        array(
            'required' => false,
            'name' => 'agreement',
            'vname' => 'LBL_AGREEMENT',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'importable' => 'true',
            'duplicate_merge' => 'enabled', 
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_sepe_agreement_list',
            'studio' => 'visible',
            'dependency' => false,
            'popupHelp' => 'LBL_AGREEMENT_HELP',
        ),
    ),
    'relationships' => array(),
    'optimistic_locking' => true,
    'unified_search' => true,
    'unified_search_default_enabled' => false,
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('stic_Sepe_Files', 'stic_Sepe_Files', array('basic', 'assignable', 'security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Sepe_Files']['fields']['name']['required'] = '0'; // Name is not required in this module
$dictionary['stic_Sepe_Files']['fields']['name']['importable'] = true; // Name is importable but not required in this module
$dictionary['stic_Sepe_Files']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
