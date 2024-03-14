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

$dictionary['stic_Settings'] = array(
    'table' => 'stic_settings',
    'audited' => 1,
    'inline_edit' => 1,
    'duplicate_merge' => 1,
    'fields' => array(
        'type' => array(
            'required' => 1,
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'varchar',
            'massupdate' => 0,
            'importable' => 1,
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => 1,
            'unified_search' => 0,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
            'inline_edit' => true,
        ),
        'value' => array(
            'required' => 0,
            'name' => 'value',
            'vname' => 'LBL_VALUE',
            'type' => 'varchar',
            'massupdate' => 0,
            'importable' => 1,
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => 1,
            'unified_search' => 0,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
            'inline_edit' => true,
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => 1,
    'unified_search' => 1,
    'unified_search_default_enabled' => false,
);
if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('stic_Settings', 'stic_Settings', array('basic', 'assignable', 'security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Settings']['fields']['name']['audited'] = 1;