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

$dictionary['stic_Custom_View_Customizations'] = array(
    'table' => 'stic_custom_view_customizations',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'customization_order' => array(
            'required' => true,
            'name' => 'customization_order',
            'vname' => 'LBL_CUSTOMIZATION_ORDER',
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
        'conditions' => array(
            'name' => 'conditions',
            'vname' => 'LBL_CONDITIONS',
            'type' => 'text',
            'rows' => 2,
            'cols' => 80,
        ),
        'actions' => array(
            'name' => 'actions',
            'vname' => 'LBL_ACTIONS',
            'type' => 'text',
            'rows' => 2,
            'cols' => 80,
        ),
        'condition_lines' => array(
            'required' => false,
            'name' => 'condition_lines',
            'vname' => 'LBL_CONDITION_LINES',
            'type' => 'function',
            'source' => 'non-db',
            'massupdate' => 0,
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => false,
            'inline_edit' => false,
            'function' => array(
                'name' => 'displayConditionLines',
                'returns' => 'html',
                'include' => 'modules/stic_Custom_View_Customizations/Utils.php',
            ),
        ),
        'action_lines' => array(
            'required' => false,
            'name' => 'action_lines',
            'vname' => 'LBL_ACTION_LINES',
            'type' => 'function',
            'source' => 'non-db',
            'massupdate' => 0,
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => false,
            'inline_edit' => false,
            'function' => array(
                'name' => 'displayActionLines',
                'returns' => 'html',
                'include' => 'modules/stic_Custom_View_Customizations/Utils.php',
            ),
        ),
        'status' => array(
            'required' => false,
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'massupdate' => 1,
            'default' => 'active',
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_custom_views_status_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);

$dictionary["stic_Custom_View_Customizations"]["fields"]["stic_custom_view_customizations_stic_custom_view_actions"] = array(
    'name' => 'stic_custom_view_customizations_stic_custom_view_actions',
    'type' => 'link',
    'relationship' => 'stic_custom_view_customizations_stic_custom_view_actions',
    'source' => 'non-db',
    'module' => 'stic_Custom_View_Actions',
    'bean_name' => false,
    'side' => 'right',
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_FROM_STIC_CUSTOM_VIEW_ACTIONS_TITLE',
);
$dictionary["stic_Custom_View_Customizations"]["fields"]["stic_custom_view_customizations_stic_custom_view_conditions"] = array(
    'name' => 'stic_custom_view_customizations_stic_custom_view_conditions',
    'type' => 'link',
    'relationship' => 'stic_custom_view_customizations_stic_custom_view_conditions',
    'source' => 'non-db',
    'module' => 'stic_Custom_View_Conditions',
    'bean_name' => false,
    'side' => 'right',
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_FROM_STIC_CUSTOM_VIEW_CONDITIONS_TITLE',
);
$dictionary["stic_Custom_View_Customizations"]["fields"]["stic_custom_views_stic_custom_view_customizations"] = array(
    'name' => 'stic_custom_views_stic_custom_view_customizations',
    'type' => 'link',
    'relationship' => 'stic_custom_views_stic_custom_view_customizations',
    'source' => 'non-db',
    'module' => 'stic_Custom_Views',
    'bean_name' => false,
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_FROM_STIC_CUSTOM_VIEWS_TITLE',
    'id_name' => 'stic_custo45d1m_views_ida',
);
$dictionary["stic_Custom_View_Customizations"]["fields"]["stic_custom_views_stic_custom_view_customizations_name"] = array(
    'name' => 'stic_custom_views_stic_custom_view_customizations_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_FROM_STIC_CUSTOM_VIEWS_TITLE',
    'save' => true,
    'id_name' => 'stic_custo45d1m_views_ida',
    'link' => 'stic_custom_views_stic_custom_view_customizations',
    'table' => 'stic_custom_views',
    'module' => 'stic_Custom_Views',
    'rname' => 'name',
);
$dictionary["stic_Custom_View_Customizations"]["fields"]["stic_custo45d1m_views_ida"] = array(
    'name' => 'stic_custo45d1m_views_ida',
    'type' => 'link',
    'relationship' => 'stic_custom_views_stic_custom_view_customizations',
    'source' => 'non-db',
    'reportable' => false,
    'side' => 'right',
    'vname' => 'LBL_STIC_CUSTOM_VIEW_CUSTOMIZATIONS_TITLE',
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('stic_Custom_View_Customizations', 'stic_Custom_View_Customizations', array('basic'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Custom_View_Customizations']['fields']['name']['link'] = false; // Not link for name
$dictionary['stic_Custom_View_Customizations']['fields']['description']['rows'] = '1'; // Make textarea fields shorter
