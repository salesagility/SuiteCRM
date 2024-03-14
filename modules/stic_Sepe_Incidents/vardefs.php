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

$dictionary['stic_Sepe_Incidents'] = array(
    'table' => 'stic_sepe_incidents',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'incident_date' =>
        array(
            'required' => true,
            'name' => 'incident_date',
            'vname' => 'LBL_INCIDENT_DATE',
            'type' => 'date',
            'massupdate' => 1,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled', 
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'size' => '20',
            'enable_range_search' => '1',
            'options' => 'date_range_search_dom',
        ),
        'type' =>
        array(
            'required' => true,
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'enum',
            'massupdate' => 1,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled', 
            'duplicate_merge_dom_value' => '2',
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'enabled',
            'len' => 100,
            'size' => '20',
            'options' => 'stic_sepe_incident_types_list',
            'studio' => 'visible',
            'dependency' => false,
        ),
        "stic_sepe_incidents_contacts" =>
        array(
            'name' => 'stic_sepe_incidents_contacts',
            'type' => 'link',
            'relationship' => 'stic_sepe_incidents_contacts',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_SEPE_INCIDENTS_CONTACTS_FROM_CONTACTS_TITLE',
            'id_name' => 'stic_sepe_incidents_contactscontacts_ida',
        ),
        "stic_sepe_incidents_contacts_name" =>
        array(
            'required' => true,
            'name' => 'stic_sepe_incidents_contacts_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_STIC_SEPE_INCIDENTS_CONTACTS_FROM_CONTACTS_TITLE',
            'save' => true,
            'id_name' => 'stic_sepe_incidents_contactscontacts_ida',
            'link' => 'stic_sepe_incidents_contacts',
            'table' => 'contacts',
            'module' => 'Contacts',
            'rname' => 'name',
            'db_concat_fields' =>
            array(
                0 => 'first_name',
                1 => 'last_name',
            ),
        ),
        "stic_sepe_incidents_contactscontacts_ida" =>
        array(
            'name' => 'stic_sepe_incidents_contactscontacts_ida',
            'type' => 'link',
            'relationship' => 'stic_sepe_incidents_contacts',
            'source' => 'non-db',
            'reportable' => false,
            'side' => 'right',
            'vname' => 'LBL_STIC_SEPE_INCIDENTS_CONTACTS_FROM_STIC_SEPE_INCIDENTS_TITLE',
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
VardefManager::createVardef('stic_Sepe_Incidents', 'stic_Sepe_Incidents', array('basic', 'assignable', 'security_groups'));

// Set special values for SuiteCRM base fields
$dictionary['stic_Sepe_Incidents']['fields']['name']['required'] = '0'; // Name is not required in this module
$dictionary['stic_Sepe_Incidents']['fields']['name']['importable'] = true; // Name is importable but not required in this module
$dictionary['stic_Sepe_Incidents']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
