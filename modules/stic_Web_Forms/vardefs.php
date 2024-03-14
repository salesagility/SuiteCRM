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

$dictionary['stic_Web_Forms'] = array(
    'table' => 'stic_web_forms',
    'audited' => 1,
    'inline_edit' => 1,
    'duplicate_merge' => 1,
    'fields' => array(
        'web_module' => array(
            'required' => 1,
            'name' => 'web_module',
            'vname' => 'LBL_WEB_MODULE',
            'type' => 'enum',
            'massupdate' => 0,
            'default' => 'Leads',
            'no_default' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 0,
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => 0,
            'reportable' => 1,
            'unified_search' => 0,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'moduleList',
            'studio' => 'visible',
            'dependency' => 0,
        ),
    ),
    'relationships' => array(),
    'optimistic_locking' => 1,
    'unified_search' => true,
    'unified_search_default_enabled' => false,
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}

VardefManager::createVardef('stic_Web_Forms', 'stic_Web_Forms', array('basic', 'assignable', 'security_groups'));
