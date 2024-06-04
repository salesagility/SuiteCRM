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

$dictionary['stic_Time_Tracker'] = array(
    'table' => 'stic_time_tracker',
    'audited' => 1,
    'inline_edit' => 1,
    'duplicate_merge' => 1,
    'fields' => array (
        'start_date' => array(
            'required' => 1,
            'name' => 'start_date',
            'vname' => 'LBL_START_DATE',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'datetimecombo',
            'massupdate' => 0, // dangerous
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'required',
            'audited' => 1,
            'reportable' => 1,
            'unified_search' => 0,
            'size' => '20',
            'enable_range_search' => 1,
            'options' => 'date_range_search_dom',
            'dbType' => 'datetime',
            'display_default' => 'now',
            'inline_edit' => 1,
        ),   
        'end_date' => array(
            'required' => 0,
            'name' => 'end_date',
            'vname' => 'LBL_END_DATE',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'datetimecombo',
            'massupdate' => 0, // dangerous
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'audited' => 1,
            'reportable' => 1,
            'unified_search' => 0,
            'size' => '20',
            'enable_range_search' => 1,
            'options' => 'date_range_search_dom',
            'dbType' => 'datetime',
            'display_default' => '',
            'inline_edit' => 1,
        ),
        'duration' => array(
            'required' => 0,
            'name' => 'duration',
            'vname' => 'LBL_DURATION',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'decimal',
            'massupdate' => 0, // autocalc
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'len' => '10',
            'importable' => false,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'dbType' => 'decimal(10,2)',
            'size' => '10',
            'precision' => '2',
            'options' => 'numeric_range_search_dom',
            'enable_range_search' => 1,
            'inline_edit' => 0,
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
        ),
    ),
    'relationships' => array (
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
    'unified_search_default_enabled' => false, 
);
if (!class_exists('VardefManager')) {
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('stic_Time_Tracker', 'stic_Time_Tracker', array('basic','assignable','security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Time_Tracker']['fields']['assigned_user_name']['required'] = '1'; // Name is not required in this module
$dictionary['stic_Time_Tracker']['fields']['name']['required'] = '0'; // Name is not required in this module
$dictionary['stic_Time_Tracker']['fields']['name']['importable'] = true; // Name is importable but not required in this module
$dictionary['stic_Time_Tracker']['fields']['name']['massupdate'] = '0';
$dictionary['stic_Time_Tracker']['fields']['name']['inline_edit'] = '0';
$dictionary['stic_Time_Tracker']['fields']['description']['rows'] = '2'; // Make textarea fields shorter