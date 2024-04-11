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

$dictionary['stic_Custom_View_Conditions'] = array(
    'table' => 'stic_custom_view_conditions',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'condition_order' => array(
            'required' => false,
            'name' => 'condition_order',
            'vname' => 'LBL_CONDITION_ORDER',
            'type' => 'int',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => true,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
            'enable_range_search' => false,
            'disable_num_format' => '',
            'min' => false,
            'max' => false,
        ),
        'field' => array(
            'required' => false,
            'name' => 'field',
            'vname' => 'LBL_FIELD',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => '',
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'dynamic_field_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'operator' => array(
            'required' => false,
            'name' => 'operator',
            'vname' => 'LBL_OPERATOR',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => '',
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_custom_views_operator_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'condition_type' => array(
            'required' => false,
            'name' => 'condition_type',
            'vname' => 'LBL_CONDITION_TYPE',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => '',
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_custom_views_condition_type_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'value' => array(
            'required' => false,
            'name' => 'value',
            'vname' => 'LBL_VALUE',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => '',
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
        ),
        'value_type' => array(
            'required' => false,
            'name' => 'value_type',
            'vname' => 'LBL_VALUE_TYPE',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'inline_edit' => '',
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);

$dictionary["stic_Custom_View_Conditions"]["fields"]["stic_custom_view_customizations_stic_custom_view_conditions"] = array(
    'name' => 'stic_custom_view_customizations_stic_custom_view_conditions',
    'type' => 'link',
    'relationship' => 'stic_custom_view_customizations_stic_custom_view_conditions',
    'source' => 'non-db',
    'module' => 'stic_Custom_View_Customizations',
    'bean_name' => false,
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CONDITIONS_FROM_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_TITLE',
    'id_name' => 'stic_custo233dzations_ida',
);
$dictionary["stic_Custom_View_Conditions"]["fields"]["stic_custom_view_customizations_stic_custom_view_conditions_name"] = array(
    'name' => 'stic_custom_view_customizations_stic_custom_view_conditions_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CONDITIONS_FROM_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_TITLE',
    'save' => true,
    'id_name' => 'stic_custo233dzations_ida',
    'link' => 'stic_custom_view_customizations_stic_custom_view_conditions',
    'table' => 'stic_custom_view_customizations',
    'module' => 'stic_Custom_View_Customizations',
    'rname' => 'name',
);
$dictionary["stic_Custom_View_Conditions"]["fields"]["stic_custo233dzations_ida"] = array(
    'name' => 'stic_custo233dzations_ida',
    'type' => 'link',
    'relationship' => 'stic_custom_view_customizations_stic_custom_view_conditions',
    'source' => 'non-db',
    'reportable' => false,
    'side' => 'right',
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_FROM_STIC_CUSTOM_VIEW_CONDITIONS_TITLE',
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}

VardefManager::createVardef('stic_Custom_View_Conditions', 'stic_Custom_View_Conditions', array('basic'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Custom_View_Conditions']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
