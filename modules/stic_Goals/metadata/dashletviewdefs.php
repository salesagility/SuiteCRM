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
$dashletData['stic_GoalsDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'stic_goals_contacts_name' => 
  array (
    'default' => '',
  ),
  'origin' => 
  array (
    'default' => '',
  ),
  'start_date' => 
  array (
    'default' => '',
  ),
  'area' => 
  array (
    'default' => '',
  ),
  'status' => 
  array (
    'default' => '',
  ),
);
$dashletData['stic_GoalsDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'stic_goals_contacts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_GOALS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_GOALS_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'default' => true,
    'name' => 'stic_goals_contacts_name',
  ),
  'origin' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ORIGIN',
    'width' => '10%',
    'default' => true,
    'name' => 'origin',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
    'name' => 'status',
  ),
  'start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'start_date',
  ),
  'expected_end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_EXPECTED_END_DATE',
    'width' => '10%',
    'default' => true,
    'name' => 'expected_end_date',
  ),
  'actual_end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_ACTUAL_END_DATE',
    'width' => '10%',
    'default' => false,
    'name' => 'actual_end_date',
  ),
  'follow_up' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_FOLLOW_UP',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
    'name' => 'follow_up',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
    'name' => 'description',
  ),
  'stic_goals_stic_registrations_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_GOALS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
    'id' => 'STIC_GOALS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
    'width' => '10%',
    'default' => false,
    'name' => 'stic_goals_stic_registrations_name',
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'area' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_AREA',
    'width' => '10%',
    'default' => false,
    'name' => 'area',
  ),
  'stic_goals_stic_assessments_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_GOALS_STIC_ASSESSMENTS_FROM_STIC_ASSESSMENTS_TITLE',
    'id' => 'STIC_GOALS_STIC_ASSESSMENTSSTIC_ASSESSMENTS_IDA',
    'width' => '10%',
    'default' => false,
    'name' => 'stic_goals_stic_assessments_name',
  ),
  'stic_goals_project_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_GOALS_PROJECT_FROM_PROJECT_TITLE',
    'id' => 'STIC_GOALS_PROJECTPROJECT_IDA',
    'width' => '10%',
    'default' => false,
    'name' => 'stic_goals_project_name',
  ),
  'subarea' => 
  array (
    'type' => 'dynamicenum',
    'studio' => 'visible',
    'label' => 'LBL_SUBAREA',
    'width' => '10%',
    'default' => false,
    'name' => 'subarea',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
  'level' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_LEVEL',
    'width' => '10%',
    'default' => false,
    'name' => 'level',
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
    'name' => 'modified_by_name',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
    'name' => 'created_by_name',
  ),
);
