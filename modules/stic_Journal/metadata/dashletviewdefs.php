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

$dashletData['stic_JournalDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'type' => 
  array (
    'default' => '',
  ),
  'journal_date' => 
  array (
    'default' => '',
  ),
  'turn' => 
  array (
    'default' => '',
  ),
  'stic_journal_stic_centers_name' => 
  array (
    'default' => '',
  ),
  'assigned_user_name' => 
  array (
    'default' => '',
  ),
);
$dashletData['stic_JournalDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'type' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'journal_date' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_JOURNAL_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'turn' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TURN',
    'width' => '10%',
    'default' => true,
  ),
  'stic_journal_stic_centers_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_CENTERS_TITLE',
    'id' => 'STIC_JOURNAL_STIC_CENTERSSTIC_CENTERS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => true,
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'task' => 
  array (
    'type' => 'multienum',
    'studio' => 'visible',
    'label' => 'LBL_TASK',
    'width' => '10%',
    'default' => false,
  ),
  'task_scope' => 
  array (
    'type' => 'multienum',
    'studio' => 'visible',
    'label' => 'LBL_TASK_SCOPE',
    'width' => '10%',
    'default' => false,
  ),
  'task_start_date' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_TASK_START_DATE',
    'width' => '10%',
    'default' => false,
  ),
  'task_end_date' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_TASK_END_DATE',
    'width' => '10%',
    'default' => false,
  ),
  'task_fulfillment' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_TASK_FULFILLMENT',
    'width' => '10%',
    'default' => false,
  ),
  'task_description' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_TASK_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'infringement_seriousness' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_INFRINGEMENT_SERIOUSNESS',
    'width' => '10%',
    'default' => false,
  ),
  'infringement_description' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_INFRINGEMENT_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
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
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
);
