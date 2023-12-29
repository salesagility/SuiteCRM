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
    'moduleMain' => 'stic_Personal_Environment',
    'varName' => 'stic_Personal_Environment',
    'orderBy' => 'stic_personal_environment.name',
    'whereClauses' => array (
  'name' => 'stic_personal_environment.name',
  'relationship_type' => 'stic_personal_environment.relationship_type',
  'stic_personal_environment_contacts_name' => 'stic_personal_environment.stic_personal_environment_contacts_name',
  'stic_personal_environment_contacts_1_name' => 'stic_personal_environment.stic_personal_environment_contacts_1_name',
  'stic_personal_environment_accounts_name' => 'stic_personal_environment.stic_personal_environment_accounts_name',
  'start_date' => 'stic_personal_environment.start_date',
  'end_date' => 'stic_personal_environment.end_date',
  'coexistence_state' => 'stic_personal_environment.coexistence_status',
  'assigned_user_id' => 'stic_personal_environment.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'relationship_type',
  5 => 'stic_personal_environment_contacts_name',
  6 => 'stic_personal_environment_contacts_1_name',
  7 => 'stic_personal_environment_accounts_name',
  8 => 'start_date',
  9 => 'end_date',
  10 => 'coexistence_status',
  11 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'relationship_type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_RELATIONSHIP_TYPE',
    'width' => '10%',
    'name' => 'relationship_type',
  ),
  'stic_personal_environment_contacts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_PERSONAL_ENVIRONMENT_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_PERSONAL_ENVIRONMENT_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'name' => 'stic_personal_environment_contacts_name',
  ),
  'stic_personal_environment_contacts_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_PERSONAL_ENVIRONMENT_CONTACTS_1_FROM_CONTACTS_TITLE',
    'id' => 'STIC_PERSONAL_ENVIRONMENT_CONTACTS_1CONTACTS_IDA',
    'width' => '10%',
    'name' => 'stic_personal_environment_contacts_1_name',
  ),
  'stic_personal_environment_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_PERSONAL_ENVIRONMENT_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'STIC_PERSONAL_ENVIRONMENT_ACCOUNTSACCOUNTS_IDA',
    'width' => '10%',
    'name' => 'stic_personal_environment_accounts_name',
  ),
  'start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'name' => 'start_date',
  ),
  'end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_END_DATE',
    'width' => '10%',
    'name' => 'end_date',
  ),
  'coexistence_status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_COEXISTENCE_STATUS',
    'width' => '10%',
    'name' => 'coexistence_status',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
);
