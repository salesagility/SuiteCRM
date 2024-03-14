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

$dictionary['stic_Incorpora_Locations'] = array(
    'table' => 'stic_incorpora_locations',
    'audited' => true,
    'inline_edit' => 0,
    'duplicate_merge' => true,
    'fields' => array(
        'state' => array(
            'required' => true,
            'name' => 'state',
            'vname' => 'LBL_STATE',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'inline_edit' => 0,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => '255',
            'size' => '20',
        ),
        'state_code' => array(
            'required' => true,
            'name' => 'state_code',
            'vname' => 'LBL_STATE_CODE',
            'type' => 'int',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'inline_edit' => 0,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => '255',
            'size' => '20',
            'enable_range_search' => '1',
            'options' => 'numeric_range_search_dom',
            'disable_num_format' => '',
            'min' => false,
            'max' => false,
        ),
        'municipality' => array(
            'required' => true,
            'name' => 'municipality',
            'vname' => 'LBL_MUNICIPALITY',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'inline_edit' => 0,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => '255',
            'size' => '20',
        ),
        'municipality_code' => array(
            'required' => true,
            'name' => 'municipality_code',
            'vname' => 'LBL_MUNICIPALITY_CODE',
            'type' => 'int',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'inline_edit' => 0,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => '255',
            'size' => '20',
            'enable_range_search' => '1',
            'options' => 'numeric_range_search_dom',
            'disable_num_format' => '',
            'min' => false,
            'max' => false,
        ),
        'town' => array(
            'required' => true,
            'name' => 'town',
            'vname' => 'LBL_TOWN',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'inline_edit' => 0,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => '255',
            'size' => '20',
        ),
        'town_code' => array(
            'required' => true,
            'name' => 'town_code',
            'vname' => 'LBL_TOWN_CODE',
            'type' => 'int',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'inline_edit' => 0,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => '255',
            'size' => '20',
            'enable_range_search' => '1',
            'options' => 'numeric_range_search_dom',
            'disable_num_format' => '',
            'min' => false,
            'max' => false,
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
VardefManager::createVardef('stic_Incorpora_Locations', 'stic_Incorpora_Locations', array('basic', 'assignable', 'security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Incorpora_Locations']['fields']['name']['inline_edit'] = '0'; // Name can't be edited inline in this module
$dictionary['stic_Incorpora_Locations']['fields']['assigned_user_name']['inline_edit'] = '0'; // Name can't be edited inline in this module
$dictionary['stic_Incorpora_Locations']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
