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

$dictionary['stic_Work_Calendar'] = array(
    'table' => 'stic_work_calendar',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array (
        'type' => array(
            'required' => 1,
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'enum',
            'massupdate' => '1',
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'popupHelp' => 'LBL_ALL_DAY_HELP',
            'importable' => 'required',
            'audited' => 1,
            'reportable' => 1,
            'unified_search' => 0,
            'len' => 100,
            'size' => '20',
            'options' => 'stic_work_calendar_types_list',
            'studio' => 'visible',
            'dependency' => 0,
            'inline_edit' => 0,
            'default' => '',
        ),        
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
            'display_default' => 'now&09:00am',
            'inline_edit' => 0,
        ),
        'end_date' => array(
            'required' => 1,
            'name' => 'end_date',
            'vname' => 'LBL_END_DATE',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'datetimecombo',
            'massupdate' => 0, // dangerous
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'popupHelp' => 'LBL_ALL_DAY_HELP',            
            'importable' => 'true',
            'audited' => 1,
            'reportable' => 1,
            'unified_search' => 0,
            'size' => '20',
            'enable_range_search' => 1,
            'options' => 'date_range_search_dom',
            'dbType' => 'datetime',
            'display_default' => 'now&06:00pm',
            'inline_edit' => 0,
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
            'importable' => 0,
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
        'weekday' => array(
            'required' => 0,
            'name' => 'weekday',
            'vname' => 'LBL_WEEKDAY',
            'duplicate_merge' => 'enabled',
            'merge_filter' => 'enabled',
            'type' => 'enum',
            'massupdate' => 0, // autocalc
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 0,
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'options' => 'stic_weekdays_list',
            'dependency' => 0,
            'inline_edit' => 0,
            'len' => 100,
            'size' => '20',
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
VardefManager::createVardef('stic_Work_Calendar', 'stic_Work_Calendar', array('basic','assignable','security_groups'));


// Set special values for SuiteCRM base fields
$dictionary['stic_Work_Calendar']['fields']['assigned_user_name']['required'] = 1; // Name is not required in this module
$dictionary['stic_Work_Calendar']['fields']['assigned_user_name']['inline_edit'] = 0; // Name is not required in this module
$dictionary['stic_Work_Calendar']['fields']['name']['required'] = 0; // Name is not required in this module
$dictionary['stic_Work_Calendar']['fields']['name']['importable'] = true; // Name is importable but not required in this module
$dictionary['stic_Work_Calendar']['fields']['name']['massupdate'] = 0;
$dictionary['stic_Work_Calendar']['fields']['name']['inline_edit'] = 0;
$dictionary['stic_Work_Calendar']['fields']['description']['rows'] = '2'; // Make textarea fields shorter