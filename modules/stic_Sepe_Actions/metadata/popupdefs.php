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
    'moduleMain' => 'stic_Sepe_Actions',
    'varName' => 'stic_Sepe_Actions',
    'orderBy' => 'stic_sepe_actions.name',
    'whereClauses' => array (
  'name' => 'stic_sepe_actions.name',
  'stic_sepe_actions_contacts_name' => 'stic_sepe_actions.stic_sepe_actions_contacts_name',
  'type' => 'stic_sepe_actions.type',
  'start_date' => 'stic_sepe_actions.start_date',
  'end_date' => 'stic_sepe_actions.end_date',
  'assigned_user_name' => 'stic_sepe_actions.assigned_user_name',
  'agreement' => 'stic_sepe_actions.agreement',
  'description' => 'stic_sepe_actions.description',
  'date_entered' => 'stic_sepe_actions.date_entered',
  'date_modified' => 'stic_sepe_actions.date_modified',
  'created_by_name' => 'stic_sepe_actions.created_by_name',
  'modified_by_name' => 'stic_sepe_actions.modified_by_name',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'stic_sepe_actions_contacts_name',
  5 => 'type',
  6 => 'start_date',
  7 => 'end_date',
  8 => 'assigned_user_name',
  9 => 'agreement',
  10 => 'description',
  11 => 'date_entered',
  12 => 'date_modified',
  13 => 'created_by_name',
  14 => 'modified_by_name',
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
  'stic_sepe_actions_contacts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_SEPE_ACTIONS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_SEPE_ACTIONS_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'name' => 'stic_sepe_actions_contacts_name',
  ),
  'type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ACTION_TYPE',
    'width' => '10%',
    'name' => 'type',
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
  'agreement' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_AGREEMENT',
    'width' => '10%',
    'name' => 'agreement',
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
  'STIC_SEPE_ACTIONS_CONTACTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_SEPE_ACTIONS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_SEPE_ACTIONS_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'stic_sepe_actions_contacts_name',
  ),
  'ACTION_TYPE' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ACTION_TYPE',
    'width' => '10%',
    'default' => true,
    'name' => 'type',
  ),
  'START_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'start_date',
  ),
  'END_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_END_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'end_date',
  ),
  'AGREEMENT' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_AGREEMENT',
    'width' => '10%',
    'default' => true,
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
