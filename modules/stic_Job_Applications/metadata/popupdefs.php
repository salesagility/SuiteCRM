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
    'moduleMain' => 'stic_Job_Applications',
    'varName' => 'stic_Job_Applications',
    'orderBy' => 'stic_job_applications.name',
    'whereClauses' => array (
  'name' => 'stic_job_applications.name',
  'start_date' => 'stic_job_applications.start_date',
  'end_date' => 'stic_job_applications.end_date',
  'status' => 'stic_job_applications.status',
  'stic_job_applications_stic_job_offers_name' => 'stic_job_applications.stic_job_applications_stic_job_offers_name',
  'stic_job_applications_contacts_name' => 'stic_job_applications.stic_job_applications_contacts_name',
  'assigned_user_name' => 'stic_job_applications.assigned_user_name',
  'contract_start_date' => 'stic_job_applications.contract_start_date',
  'contract_end_date' => 'stic_job_applications.contract_end_date',
  'motivations' => 'stic_job_applications.motivations',
  'date_entered' => 'stic_job_applications.date_entered',
  'date_modified' => 'stic_job_applications.date_modified',
  'created_by_name' => 'stic_job_applications.created_by_name',
  'modified_by_name' => 'stic_job_applications.modified_by_name',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'start_date',
  5 => 'end_date',
  6 => 'stic_job_applications_stic_job_offers_name',
  7 => 'stic_job_applications_contacts_name',
  8 => 'assigned_user_name',
  9 => 'contract_start_date',
  10 => 'contract_end_date',
  11 => 'motivations',
  12 => 'date_entered',
  13 => 'date_modified',
  14 => 'created_by_name',
  15 => 'modified_by_name',
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
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'stic_job_applications_stic_job_offers_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_JOB_APPLICATIONS_STIC_JOB_OFFERS_FROM_STIC_JOB_OFFERS_TITLE',
    'id' => 'STIC_JOB_APPLICATIONS_STIC_JOB_OFFERSSTIC_JOB_OFFERS_IDA',
    'width' => '10%',
    'name' => 'stic_job_applications_stic_job_offers_name',
  ),
  'stic_job_applications_contacts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_JOB_APPLICATIONS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_JOB_APPLICATIONS_CONTACTSCONTACTS_IDA',
    'width' => '10%',
    'name' => 'stic_job_applications_contacts_name',
  ),
  'contract_start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_CONTRACT_START_DATE',
    'width' => '10%',
    'name' => 'contract_start_date',
  ),
  'contract_end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_CONTRACT_END_DATE',
    'width' => '10%',
    'name' => 'contract_end_date',
  ),
  'motivations' => 
  array (
    'type' => 'text',
    'studio' => 'visible',
    'label' => 'LBL_MOTIVATIONS',
    'sortable' => false,
    'width' => '10%',
    'name' => 'motivations',
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
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'START_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'END_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_END_DATE',
    'width' => '10%',
    'default' => true,
  ),
  'STIC_JOB_APPLICATIONS_STIC_JOB_OFFERS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_JOB_APPLICATIONS_STIC_JOB_OFFERS_FROM_STIC_JOB_OFFERS_TITLE',
    'id' => 'STIC_JOB_APPLICATIONS_STIC_JOB_OFFERSSTIC_JOB_OFFERS_IDA',
    'width' => '10%',
    'default' => true,
  ),
  'STIC_JOB_APPLICATIONS_CONTACTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_JOB_APPLICATIONS_CONTACTS_FROM_CONTACTS_TITLE',
    'id' => 'STIC_JOB_APPLICATIONS_CONTACTSCONTACTS_IDA',
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
  ),
),
);
