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

$dictionary['Opportunity']['fields']['stic_presentation_date_c'] = array (
      'id' => 'Opportunitiesstic_presentation_date_c',
      'name' => 'stic_presentation_date_c',
      'vname' => 'LBL_STIC_PRESENTATION_DATE',
      'custom_module' => 'Opportunities',
      'source' => 'custom_fields',
      'comments' => '',
      'help' => '',
      'type' => 'date',
      'size' => '20',
      'required' => 0,
      'audited' => 0,
      'reportable' => 1,
      'unified_search' => 0,
      'merge_filter' => 'disabled',
      'options' => 'date_range_search_dom',
      'enable_range_search' => 1,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'inline_edit' => 1,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
);
$dictionary['Opportunity']['fields']['stic_amount_received_c'] = array (
      'id' => 'Opportunitiesstic_amount_received_c',
      'name' => 'stic_amount_received_c',
      'vname' => 'LBL_STIC_AMOUNT_RECEIVED',
      'custom_module' => 'Opportunities',
      'source' => 'custom_fields',
      'comments' => '',
      'help' => '',
      'type' => 'decimal',
      'len' => '26',
      'size' => '20',
      'required' => 0,
      'audited' => 1,
      'unified_search' => 0,
      'default' => '',
      'options' => 'numeric_range_search_dom',
      'enable_range_search' => 1,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'inline_edit' => 1,
      'massupdate' => 0,
      'no_default' => 0,
      'importable' => 1,
      'reportable' => 1,
      'precision' => 2,
);
$dictionary['Opportunity']['fields']['stic_resolution_date_c'] = array (
      'id' => 'Opportunitiesstic_resolution_date_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_resolution_date_c',
      'vname' => 'LBL_STIC_RESOLUTION_DATE', 
      'source' => 'custom_fields',
      'type' => 'date',
      'comments' => '',
      'help' => '',
      'size' => '20',
      'options' => 'date_range_search_dom',
      'enable_range_search' => 1,
      'unified_search' => 0,
      'required' => 0,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'inline_edit' => 1,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'reportable' => 1,
);
$dictionary['Opportunity']['fields']['stic_advance_date_c'] = array (
      'id' => 'Opportunitiesstic_advance_date_c',
      'name' => 'stic_advance_date_c',
      'vname' => 'LBL_STIC_ADVANCE_DATE',
      'custom_module' => 'Opportunities',
      'source' => 'custom_fields',
      'type' => 'date',
      'comments' => '',
      'help' => '',
      'required' => 0,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'options' => 'date_range_search_dom',
      'enable_range_search' => 1,
      'unified_search' => 0,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'reportable' => 1,
      'size' => '20',
      'inline_edit' => 1,
);
$dictionary['Opportunity']['fields']['stic_justification_date_c'] = array (
      'id' => 'Opportunitiesstic_justification_date_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_justification_date_c',
      'vname' => 'LBL_STIC_JUSTIFICATION_DATE',
      'source' => 'custom_fields',
      'type' => 'date',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'required' => 0,
      'audited' => 0,
      'options' => 'date_range_search_dom',
      'enable_range_search' => 1,
      'unified_search' => 0,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'inline_edit' => 1,
      'importable' => 1,
      'reportable' => 1,
      'size' => '20',
);
$dictionary['Opportunity']['fields']['stic_amount_awarded_c'] = array (
      'id' => 'Opportunitiesstic_amount_awarded_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_amount_awarded_c',
      'vname' => 'LBL_STIC_AMOUNT_AWARDED',
      'source' => 'custom_fields',
      'type' => 'decimal',
      'comments' => '',
      'help' => '',
      'options' => 'numeric_range_search_dom',
      'enable_range_search' => 1,
      'unified_search' => 0,
      'required' => 0,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'inline_edit' => 1,
      'massupdate' => 0,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'reportable' => 1,
      'len' => '26',
      'size' => '20',
      'precision' => 2,
);
$dictionary['Opportunity']['fields']['stic_target_c'] = array (
      'id' => 'Opportunitiesstic_target_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_target_c',
      'vname' => 'LBL_STIC_TARGET',
      'source' => 'custom_fields',
      'type' => 'enum',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'unified_search' => 0,
      'required' => 0,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'inline_edit' => 1,
      'reportable' => 1,
      'merge_filter' => 'disabled',
      'len' => 100,
      'size' => '20',
      'options' => 'stic_payments_targets_list',
      'studio' => 'visible',
      'dependency' => 0,
);
$dictionary['Opportunity']['fields']['stic_documentation_to_deliver_c'] = array (
      'id' => 'Opportunitiesstic_documentation_to_deliver_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_documentation_to_deliver_c',
      'vname' => 'LBL_STIC_DOCUMENTATION_TO_DELIVER',
      'source' => 'custom_fields',
      'type' => 'multienum',
      'isMultiSelect' => 1,
      'comments' => '',
      'help' => '',
      'size' => '20',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'unified_search' => 0,
      'massupdate' => 0,
      'default' => '^^',
      'no_default' => 0,
      'required' => 0,
      'importable' => 1,
      'audited' => 0,
      'inline_edit' => 1,
      'reportable' => 1,
      'merge_filter' => 'disabled',
      'options' => 'stic_opportunities_documents_list',
      'studio' => 'visible',
);
$dictionary['Opportunity']['fields']['stic_payment_date_c'] = array (
      'id' => 'Opportunitiesstic_payment_date_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_payment_date_c',
      'vname' => 'LBL_STIC_PAYMENT_DATE',
      'source' => 'custom_fields',
      'type' => 'date',
      'comments' => '',
      'help' => '',
      'size' => '20',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'unified_search' => 0,
      'options' => 'numeric_range_search_dom',
      'enable_range_search' => 1,
      'required' => 0,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'inline_edit' => 1,
      'reportable' => 1,
);
$dictionary['Opportunity']['fields']['stic_status_c'] = array (
      'id' => 'Opportunitiesstic_status_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_status_c',
      'vname' => 'LBL_STIC_STATUS',
      'source' => 'custom_fields',
      'type' => 'enum',
      'comments' => '',
      'help' => '',
      'len' => 100,
      'size' => '20',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'unified_search' => 0,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'required' => 1,
      'inline_edit' => 1,
      'reportable' => 1,
      'options' => 'stic_opportunities_status_list',
      'studio' => 'visible',
      'dependency' => 0,
);
$dictionary['Opportunity']['fields']['stic_type_c'] = array (
      'id' => 'Opportunitiesstic_type_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_type_c',
      'vname' => 'LBL_STIC_TYPE',
      'source' => 'custom_fields',
      'type' => 'enum',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'merge_filter' => 'disabled',
      'len' => 100,
      'size' => '20',
      'required' => 0,
      'massupdate' => 1,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'inline_edit' => 1,
      'reportable' => 1,
      'unified_search' => 0,
      'options' => 'stic_opportunities_types_list',
      'studio' => 'visible',
      'dependency' => 0,
);

$dictionary['Opportunity']['fields']['stic_opportunity_url_c'] = array(
      'id' => 'Opportunitiesstic_opportunity_url_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_opportunity_url_c',
      'vname' => 'LBL_STIC_OPPORTUNITY_URL', 
      'source' => 'custom_fields',
      'type' => 'url',
      'comments' => '',
      'help' => '',
      'size' => '20',
      'unified_search' => 0,
      'required' => 0,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '0',
      'merge_filter' => 'disabled',
      'inline_edit' => 1,
      'massupdate' => 0,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'reportable' => 1,
      'studio' => 'visible',
      'link_target' => '_blank',
);

$dictionary['Opportunity']['fields']['stic_additional_information_c'] = array(
      'id' => 'Opportunitiesstic_additional_information_c',
      'custom_module' => 'Opportunities',
      'name' => 'stic_additional_information_c',
      'vname' => 'LBL_STIC_ADDITIONAL_INFORMATION',
      'source' => 'custom_fields',
      'type' => 'text',
      'comments' => '',
      'help' => '',
      'size' => '20',
      'unified_search' => 0,
      'required' => 0,
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '0',
      'merge_filter' => 'enabled',
      'inline_edit' => 1,
      'massupdate' => 0,
      'default' => '',
      'no_default' => 0,
      'importable' => 1,
      'audited' => 0,
      'reportable' => 1,
      'studio' => 'visible',
      'rows' => '2',
);

$dictionary["Opportunity"]["fields"]["project_opportunities_1"] = array (
    'name' => 'project_opportunities_1',
    'type' => 'link',
    'relationship' => 'project_opportunities_1',
    'source' => 'non-db',
    'module' => 'Project',
    'bean_name' => 'Project',
    'vname' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
    'id_name' => 'project_opportunities_1project_ida',
);
$dictionary["Opportunity"]["fields"]["project_opportunities_1_name"] = array (
    'name' => 'project_opportunities_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
    'save' => true,
    'id_name' => 'project_opportunities_1project_ida',
    'link' => 'project_opportunities_1',
    'table' => 'project',
    'module' => 'Project',
    'rname' => 'name',
    'inline_edit' => 1,
    'massupdate' => 1,
);
$dictionary["Opportunity"]["fields"]["project_opportunities_1project_ida"] = array (
    'name' => 'project_opportunities_1project_ida',
    'type' => 'link',
    'relationship' => 'project_opportunities_1',
    'source' => 'non-db',
    'reportable' => false,
    'side' => 'right',
    'vname' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
);

// Grants relationship Vardef
$dictionary["Opportunity"]["fields"]["stic_grants_opportunities"] = array (
      'name' => 'stic_grants_opportunities',
      'type' => 'link',
      'relationship' => 'stic_grants_opportunities',
      'source' => 'non-db',
      'module' => 'stic_Grants',
      'bean_name' => 'stic_Grants',
      'side' => 'right',
      'vname' => 'LBL_STIC_GRANTS_OPPORTUNITIES_FROM_STIC_GRANTS_TITLE',
);

// Participations relationship
$dictionary["Opportunity"]["fields"]["stic_group_opportunities_opportunities"] = array (
      'name' => 'stic_group_opportunities_opportunities',
      'type' => 'link',
      'relationship' => 'stic_group_opportunities_opportunities',
      'source' => 'non-db',
      'module' => 'stic_Group_Opportunities',
      'bean_name' => false,
      'side' => 'right',
      'vname' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_FROM_STIC_GROUP_OPPORTUNITIES_TITLE',
);

// Base fields from the module
$dictionary['Opportunity']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
$dictionary['Opportunity']['fields']['description']['massupdate'] = 0;

$dictionary['Opportunity']['fields']['sales_stage']['studio'] = false;
$dictionary['Opportunity']['fields']['sales_stage']['massupdate'] = 0;
$dictionary['Opportunity']['fields']['sales_stage']['merge_filter'] = 'disabled';
$dictionary['Opportunity']['fields']['sales_stage']['required'] = 0;
$dictionary['Opportunity']['fields']['sales_stage']['importable'] = true;

$dictionary['Opportunity']['fields']['date_closed']['required'] = 0;
$dictionary['Opportunity']['fields']['date_closed']['importable'] = true;
$dictionary['Opportunity']['fields']['date_closed']['inline_edit'] = 1;
$dictionary['Opportunity']['fields']['date_closed']['comments'] = 'Expected or actual date the oppportunity will close';
$dictionary['Opportunity']['fields']['date_closed']['merge_filter'] = 'disabled';
$dictionary['Opportunity']['fields']['date_closed']['massupdate'] = 0;

$dictionary['Opportunity']['fields']['amount']['required'] = 0;
$dictionary['Opportunity']['fields']['amount']['importable'] = true;
$dictionary['Opportunity']['fields']['amount']['inline_edit'] = 1;
$dictionary['Opportunity']['fields']['amount']['duplicate_merge'] = 'enabled';
$dictionary['Opportunity']['fields']['amount']['duplicate_merge_dom_value'] = 1;
$dictionary['Opportunity']['fields']['amount']['comments'] = 'Unconverted amount of the opportunity';
$dictionary['Opportunity']['fields']['amount']['merge_filter'] = 'disabled';
$dictionary['Opportunity']['fields']['amount']['massupdate'] = 0;

$dictionary['Opportunity']['fields']['opportunity_type']['studio'] = false;
$dictionary['Opportunity']['fields']['opportunity_type']['massupdate'] = 0;
$dictionary['Opportunity']['fields']['opportunity_type']['merge_filter'] = 'disabled';

$dictionary['Opportunity']['fields']['next_step']['studio'] = false;
$dictionary['Opportunity']['fields']['next_step']['massupdate'] = 0;
$dictionary['Opportunity']['fields']['next_step']['merge_filter'] = 'disabled';

$dictionary['Opportunity']['fields']['amount_usdollar']['studio'] = false;
$dictionary['Opportunity']['fields']['amount_usdollar']['massupdate'] = 0;
$dictionary['Opportunity']['fields']['amount_usdollar']['merge_filter'] = 'disabled';

$dictionary['Opportunity']['fields']['lead_source']['massupdate'] = 0;

// Enabling massupdate for core fields
// STIC#981
$dictionary['Opportunity']['fields']['account_name']['massupdate']='1';

