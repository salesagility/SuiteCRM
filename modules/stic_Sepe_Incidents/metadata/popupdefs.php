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
$popupMeta = array (
    'moduleMain' => 'stic_Sepe_Incidents',
    'varName' => 'stic_Sepe_Incidents',
    'orderBy' => 'stic_sepe_incidents.name',
    'whereClauses' => array (
  'name' => 'stic_sepe_incidents.name',
  'stic_sepe_incidents_contacts_name' => 'stic_sepe_incidents.stic_sepe_incidents_contacts_name',
  'incident_date' => 'stic_sepe_incidents.incident_date',
  'type' => 'stic_sepe_incidents.type',
  'assigned_user_name' => 'stic_sepe_incidents.assigned_user_name',
  'description' => 'stic_sepe_incidents.description',
  'created_by_name' => 'stic_sepe_incidents.created_by_name',
  'modified_by_name' => 'stic_sepe_incidents.modified_by_name',
  'date_entered' => 'stic_sepe_incidents.date_entered',
  'date_modified' => 'stic_sepe_incidents.date_modified',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'stic_sepe_incidents_contacts_name',
  5 => 'incident_date',
  6 => 'type',
  7 => 'assigned_user_name',
  8 => 'description',
  9 => 'created_by_name',
  10 => 'modified_by_name',
  11 => 'date_entered',
  12 => 'date_modified',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'stic_sepe_incidents_contacts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_SEPE_INCIDENTS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_SEPE_INCIDENTS_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'name' => 'stic_sepe_incidents_contacts_name',
  ),
  'incident_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_INCIDENT_DATE',
    'width' => '10%',
    'name' => 'incident_date',
  ),
  'type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'name' => 'type',
  ),
  'description' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'name' => 'description',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'name' => 'created_by_name',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'name' => 'modified_by_name',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'name' => 'date_modified',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'name' => 'assigned_user_name',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
    'name' => 'name',
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'STIC_SEPE_INCIDENTS_CONTACTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_SEPE_INCIDENTS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_SEPE_INCIDENTS_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'stic_sepe_incidents_contacts_name',
  ),
  'INCIDENT_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_INCIDENT_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'incident_date',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
),
);
