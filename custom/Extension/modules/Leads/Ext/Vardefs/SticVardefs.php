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

$dictionary['Lead']['fields']['stic_identification_type_c'] = array(
    'id' => 'Leadsstic_identification_type_c',
    'name' => 'stic_identification_type_c',
    'vname' => 'LBL_STIC_IDENTIFICATION_TYPE',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_contacts_identification_types_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_identification_number_c'] = array(
    'id' => 'Leadsstic_identification_number_c',
    'name' => 'stic_identification_number_c',
    'vname' => 'LBL_STIC_IDENTIFICATION_NUMBER',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'varchar',
    'len' => '255',
    'size' => '20',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
);

$dictionary['Lead']['fields']['stic_language_c'] = array(
    'id' => 'Leadsstic_language_c',
    'name' => 'stic_language_c',
    'vname' => 'LBL_STIC_LANGUAGE',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_languages_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_gender_c'] = array(
    'id' => 'Leadsstic_gender_c',
    'name' => 'stic_gender_c',
    'vname' => 'LBL_STIC_GENDER',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_genders_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_employment_status_c'] = array(
    'id' => 'Leadsstic_employment_status_c',
    'name' => 'stic_employment_status_c',
    'vname' => 'LBL_STIC_EMPLOYMENT_STATUS',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_contacts_employment_status_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_professional_sector_c'] = array(
    'id' => 'Leadsstic_professional_sector_c',
    'name' => 'stic_professional_sector_c',
    'vname' => 'LBL_STIC_PROFESSIONAL_SECTOR',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_professional_sectors_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_professional_sector_other_c'] = array(
    'id' => 'Leadsstic_professional_sector_other_c',
    'name' => 'stic_professional_sector_other_c',
    'vname' => 'LBL_STIC_PROFESSIONAL_SECTOR_OTHER',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'varchar',
    'len' => '255',
    'size' => '20',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
);

$dictionary['Lead']['fields']['stic_primary_address_type_c'] = array(
    'id' => 'Leadsstic_primary_address_type_c',
    'name' => 'stic_primary_address_type_c',
    'vname' => 'LBL_STIC_PRIMARY_ADDRESS_TYPE',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_contacts_addresses_types_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_primary_address_county_c'] = array(
    'id' => 'Leadsstic_primary_address_county_c',
    'name' => 'stic_primary_address_county_c',
    'vname' => 'LBL_STIC_PRIMARY_ADDRESS_COUNTY',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_catalonia_counties_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_primary_address_region_c'] = array(
    'id' => 'Leadsstic_primary_address_region_c',
    'name' => 'stic_primary_address_region_c',
    'vname' => 'LBL_STIC_PRIMARY_ADDRESS_REGION',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_spain_autonomous_communities_list',
    'required' => 0,
    'default' => '',
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_alt_address_type_c'] = array(
    'id' => 'Leadsstic_alt_address_type_c',
    'name' => 'stic_alt_address_type_c',
    'vname' => 'LBL_STIC_ALT_ADDRESS_TYPE',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_contacts_addresses_types_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_alt_address_county_c'] = array(
    'id' => 'Leadsstic_alt_address_county_c',
    'name' => 'stic_alt_address_county_c',
    'vname' => 'LBL_STIC_ALT_ADDRESS_COUNTY',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_catalonia_counties_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_alt_address_region_c'] = array(
    'id' => 'Leadsstic_alt_address_region_c',
    'name' => 'stic_alt_address_region_c',
    'vname' => 'LBL_STIC_ALT_ADDRESS_REGION',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_spain_autonomous_communities_list',
    'required' => 0,
    'default' => '',
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_acquisition_channel_c'] = array(
    'id' => 'Leadsstic_acquisition_channel_c',
    'name' => 'stic_acquisition_channel_c',
    'vname' => 'LBL_STIC_ACQUISITION_CHANNEL',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_campaign_channels_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_do_not_send_postal_mail_c'] = array(
    'id' => 'Leadsstic_do_not_send_postal_mail_c',
    'name' => 'stic_do_not_send_postal_mail_c',
    'vname' => 'LBL_STIC_DO_NOT_SEND_POSTAL_MAIL',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'bool',
    'len' => '255',
    'size' => '20',
    'required' => 0,
    'default' => 0,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
);

$dictionary['Lead']['fields']['stic_postal_mail_return_reason_c'] = array(
    'id' => 'Leadsstic_postal_mail_return_reason_c',
    'name' => 'stic_postal_mail_return_reason_c',
    'vname' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_postal_mail_return_reasons_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 0,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_referral_agent_c'] = array(
    'id' => 'Leadsstic_referral_agent_c',
    'name' => 'stic_referral_agent_c',
    'vname' => 'LBL_STIC_REFERRAL_AGENT',
    'custom_module' => 'Leads',
    'source' => 'custom_fields',
    'comments' => '',
    'help' => '',
    'type' => 'enum',
    'len' => 100,
    'size' => '20',
    'options' => 'stic_contacts_referral_agents_list',
    'required' => 0,
    'default' => null,
    'no_default' => 0,
    'audited' => 0,
    'unified_search' => 0,
    'inline_edit' => 1,
    'importable' => 1,
    'massupdate' => 1,
    'reportable' => 1,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'enabled',
    'studio' => 'visible',
    'dependency' => 0,
);

$dictionary['Lead']['fields']['stic_registrations_leads'] = array(
    'name' => 'stic_registrations_leads',
    'type' => 'link',
    'relationship' => 'stic_registrations_leads',
    'source' => 'non-db',
    'module' => 'stic_Registrations',
    'bean_name' => 'stic_Registrations',
    'side' => 'right',
    'vname' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_STIC_REGISTRATIONS_TITLE',
);

$dictionary['Lead']['fields']['leads_documents_1'] = array(
    'name' => 'leads_documents_1',
    'type' => 'link',
    'relationship' => 'leads_documents_1',
    'source' => 'non-db',
    'module' => 'Documents',
    'bean_name' => 'Document',
    'vname' => 'LBL_LEADS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
);

// Modified properties in native fields
$dictionary['Lead']['fields']['birthdate']['options'] = 'date_range_search_dom';
$dictionary['Lead']['fields']['birthdate']['enable_range_search'] = 1;
$dictionary['Lead']['fields']['birthdate']['massupdate'] = 0;

$dictionary['Lead']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
$dictionary['Lead']['fields']['description']['massupdate'] = 0;

$dictionary['Lead']['fields']['primary_address_state']['type'] = 'enum';
$dictionary['Lead']['fields']['primary_address_state']['options'] = 'stic_spain_provinces_list';
$dictionary['Lead']['fields']['primary_address_state']['default'] = '';
$dictionary['Lead']['fields']['primary_address_state']['massupdate'] = 1;

$dictionary['Lead']['fields']['alt_address_state']['type'] = 'enum';
$dictionary['Lead']['fields']['alt_address_state']['options'] = 'stic_spain_provinces_list';
$dictionary['Lead']['fields']['alt_address_state']['default'] = '';
$dictionary['Lead']['fields']['alt_address_state']['massupdate'] = 0;

$dictionary['Lead']['fields']['email1']['massupdate'] = 0;
$dictionary['Lead']['fields']['email1']['inline_edit'] = 1;

$dictionary['Lead']['fields']['name']['massupdate'] = 0;
$dictionary['Lead']['fields']['name']['inline_edit'] = 0;

$dictionary['Lead']['fields']['accept_status_id']['massupdate'] = 0;
$dictionary['Lead']['fields']['account_name']['massupdate'] = 0;
$dictionary['Lead']['fields']['account_description']['massupdate'] = 0;
$dictionary['Lead']['fields']['alt_address_city']['massupdate'] = 0;
$dictionary['Lead']['fields']['alt_address_country']['massupdate'] = 0;
$dictionary['Lead']['fields']['alt_address_postalcode']['massupdate'] = 0;
$dictionary['Lead']['fields']['alt_address_street']['massupdate'] = 0;
$dictionary['Lead']['fields']['alt_address_street_2']['massupdate'] = 0;
$dictionary['Lead']['fields']['alt_address_street_3']['massupdate'] = 0;
$dictionary['Lead']['fields']['assistant']['massupdate'] = 0;
$dictionary['Lead']['fields']['converted']['massupdate'] = 0;
$dictionary['Lead']['fields']['department']['massupdate'] = 0;
$dictionary['Lead']['fields']['email2']['massupdate'] = 0;
$dictionary['Lead']['fields']['event_invite_id']['massupdate'] = 0;
$dictionary['Lead']['fields']['event_status_id']['massupdate'] = 0;
$dictionary['Lead']['fields']['first_name']['massupdate'] = 0;
$dictionary['Lead']['fields']['last_name']['massupdate'] = 0;
$dictionary['Lead']['fields']['lead_source']['massupdate'] = 0;
$dictionary['Lead']['fields']['lead_source_description']['massupdate'] = 0;
$dictionary['Lead']['fields']['opportunity_amount']['massupdate'] = 0;
$dictionary['Lead']['fields']['opportunity_name']['massupdate'] = 0;
$dictionary['Lead']['fields']['phone_home']['massupdate'] = 0;
$dictionary['Lead']['fields']['portal_app']['massupdate'] = 0;
$dictionary['Lead']['fields']['portal_name']['massupdate'] = 0;
$dictionary['Lead']['fields']['primary_address_street']['massupdate'] = 0;
$dictionary['Lead']['fields']['primary_address_street_2']['massupdate'] = 0;
$dictionary['Lead']['fields']['primary_address_street_3']['massupdate'] = 0;
$dictionary['Lead']['fields']['refered_by']['massupdate'] = 0;
$dictionary['Lead']['fields']['status_description']['massupdate'] = 0;
$dictionary['Lead']['fields']['title']['massupdate'] = 0;

$dictionary['Lead']['fields']['primary_address_country']['massupdate'] = 1;
$dictionary['Lead']['fields']['primary_address_city']['massupdate'] = 1;
$dictionary['Lead']['fields']['status']['massupdate'] = 1;
$dictionary['Lead']['fields']['do_not_call']['massupdate'] = 1;

// Add custom index for duplicates detection in import process
$dictionary['Lead']['indices'][] = array(
    'name' => 'SticIdentificationNumberIndex',
    'type' => 'index',
    'source' => 'non-db',
    'fields' => array('stic_identification_number_c'),
);

// Virtual fields for Kreporter

// This file add a calculated field to the EmailAddress module in Kreports.
// This field gets all the Email Addresses related to a record, and shows them concatenated.
// This is necessary because Kreports only shows the primary_email_address by default
// STIC#354

$dictionary['Lead']['fields']['emails_list'] = array(
    'name' => 'emails_list',
    'vname' => 'LBL_KREPORTER_EMAILS_LIST',
    'type' => 'kreporter',
    'source' => 'non-db',
    'kreporttype' => 'varchar',
    'eval' => array(
        'presentation' => array(
            'eval' => 'SELECT GROUP_CONCAT(ea.email_address) FROM email_addresses ea JOIN email_addr_bean_rel eabr ON ea.id = eabr.email_address_id WHERE eabr.deleted = 0 AND eabr.bean_id = {t}.id',
        ),
        'selection' => array(
            'starts' => 'exists(SELECT ea.email_address FROM email_addresses ea JOIN email_addr_bean_rel eabr ON ea.id = eabr.email_address_id WHERE eabr.deleted = 0 AND eabr.bean_id = {t}.id AND ea.email_address LIKE \'{p1}%\')',
            'notstarts' => 'exists(SELECT ea.email_address FROM email_addresses ea JOIN email_addr_bean_rel eabr ON ea.id = eabr.email_address_id WHERE eabr.deleted = 0 AND eabr.bean_id = {t}.id AND ea.email_address NOT LIKE \'{p1}%\')',
            'contains' => 'exists(SELECT ea.email_address FROM email_addresses ea JOIN email_addr_bean_rel eabr ON ea.id = eabr.email_address_id WHERE eabr.deleted = 0 AND eabr.bean_id = {t}.id AND ea.email_address LIKE \'%{p1}%\')',
            'notcontains' => 'exists(SELECT ea.email_address FROM email_addresses ea JOIN email_addr_bean_rel eabr ON ea.id = eabr.email_address_id WHERE eabr.deleted = 0 AND eabr.bean_id = {t}.id AND ea.email_address NOT LIKE \'%{p1}%\')',
        ),
    ),
);
