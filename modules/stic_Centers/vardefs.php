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

$dictionary['stic_Centers'] = array(
    'table' => 'stic_centers',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'address_street' => array(
            'required' => false,
            'name' => 'address_street',
            'vname' => 'LBL_ADDRESS_STREET',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '150',
            'size' => '20',
        ),
        'address_city' => array(
            'required' => false,
            'name' => 'address_city',
            'vname' => 'LBL_ADDRESS_CITY',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '100',
            'size' => '20',
        ),
        'address_state' => array(
            'required' => false,
            'name' => 'address_state',
            'vname' => 'LBL_ADDRESS_STATE',
            'type' => 'enum',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_spain_provinces_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'address_postalcode' => array(
            'required' => false,
            'name' => 'address_postalcode',
            'vname' => 'LBL_ADDRESS_POSTALCODE',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '20',
            'size' => '20',
        ),
        'address_country' => array(
            'required' => false,
            'name' => 'address_country',
            'vname' => 'LBL_ADDRESS_COUNTRY',
            'type' => 'varchar',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
        ),
        'url_location' => array(
            'required' => false,
            'name' => 'url_location',
            'vname' => 'LBL_URL_LOCATION',
            'type' => 'url',
            'massupdate' => 0,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
            'dbType' => 'varchar',
            'gen' => '0',
            'link_target' => '_self',
        ),
        'type' => array(
            'required' => true,
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'multienum',
            'massupdate' => '1',
            'default' => '^^',
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'required',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => true,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'size' => '20',
            'options' => 'stic_centers_types_list',
            'studio' => 'visible',
            'isMultiSelect' => true,
        ),
        'places' => array(
            'required' => false,
            'name' => 'places',
            'vname' => 'LBL_PLACES',
            'type' => 'int',
            'massupdate' => '1',
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => true,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => '255',
            'size' => '20',
            'options' => 'numeric_range_search_dom',
            'enable_range_search' => true,
            'disable_num_format' => '',
            'min' => false,
            'max' => false,
        ),
        'adapted' => array(
            'required' => false,
            'name' => 'adapted',
            'vname' => 'LBL_ADAPTED',
            'type' => 'enum',
            'massupdate' => '1',
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'inline_edit' => true,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_boolean_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        'stic_centers_accounts' => array(
            'name' => 'stic_centers_accounts',
            'type' => 'link',
            'relationship' => 'stic_centers_accounts',
            'source' => 'non-db',
            'module' => 'Accounts',
            'bean_name' => 'Accounts',
            'vname' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'id_name' => 'stic_centers_accountsaccounts_ida',
        ),
        'stic_centers_accounts_name' => array(
            'name' => 'stic_centers_accounts_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
            'save' => true,
            'id_name' => 'stic_centers_accountsaccounts_ida',
            'link' => 'stic_centers_accounts',
            'table' => 'accounts',
            'module' => 'Accounts',
            'massupdate' => 0,
            'required' => true,
            'inline_edit' => false,
            'audited' => true,
            'importable' => 'required',
            'rname' => 'name',
        ),
        'stic_centers_accountsaccounts_ida' => array(
            'name' => 'stic_centers_accountsaccounts_ida',
            'type' => 'link',
            'relationship' => 'stic_centers_accounts',
            'source' => 'non-db',
            'reportable' => false,
            'side' => 'right',
            'vname' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_STIC_CENTERS_TITLE',
        ),
        // Contacts relationship Vardef
        'stic_centers_contacts' => array (
            'name' => 'stic_centers_contacts',
            'type' => 'link',
            'relationship' => 'stic_centers_contacts',
            'source' => 'non-db',
            'module' => 'Contacts',
            'bean_name' => 'Contact',
            'side' => 'right',
            'vname' => 'LBL_STIC_CENTERS_CONTACTS_FROM_CONTACTS_TITLE',
        ),

        // Projects relationship Vardef
        'stic_centers_project' => array (
            'name' => 'stic_centers_project',
            'type' => 'link',
            'relationship' => 'stic_centers_project',
            'source' => 'non-db',
            'module' => 'Project',
            'bean_name' => 'Project',
            'vname' => 'LBL_STIC_CENTERS_PROJECT_FROM_PROJECT_TITLE',
        ),

        // Contacts Relathionships relationship Vardef
        'stic_centers_stic_contacts_relationships' => array (
            'name' => 'stic_centers_stic_contacts_relationships',
            'type' => 'link',
            'relationship' => 'stic_centers_stic_contacts_relationships',
            'source' => 'non-db',
            'module' => 'stic_Contacts_Relationships',
            'bean_name' => 'stic_Contacts_Relationships',
            'side' => 'right',
            'vname' => 'LBL_STIC_CENTERS_STIC_CONTACTS_RELATIONSHIPS_FROM_STIC_CONTACTS_RELATIONSHIPS_TITLE',
        ),

        // Events relationship Vardef
        'stic_centers_stic_events' => array (
            'name' => 'stic_centers_stic_events',
            'type' => 'link',
            'relationship' => 'stic_centers_stic_events',
            'source' => 'non-db',
            'module' => 'stic_Events',
            'bean_name' => 'stic_Events',
            'side' => 'right',
            'vname' => 'LBL_STIC_CENTERS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
        ),

        // Journal relationship Vardef
        'stic_journal_stic_centers' => array(
            'name' => 'stic_journal_stic_centers',
            'type' => 'link',
            'relationship' => 'stic_journal_stic_centers',
            'source' => 'non-db',
            'module' => 'stic_Journal',
            'bean_name' => false,
            'side' => 'right',
            'vname' => 'LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_JOURNAL_TITLE',
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
    'unified_search_default_enabled' => true,
);
if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('stic_Centers', 'stic_Centers', array('basic', 'assignable', 'security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Centers']['fields']['description']['rows'] = '2'; // Make textarea fields shorter