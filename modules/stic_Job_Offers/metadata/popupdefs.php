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
    'moduleMain' => 'stic_Job_Offers',
    'varName' => 'stic_Job_Offers',
    'orderBy' => 'stic_job_offers.name',
    'whereClauses' => array (
  'name' => 'stic_job_offers.name',
  'status' => 'stic_job_offers.status',
  'professional_profile' => 'stic_job_offers.professional_profile',
  'process_start_date' => 'stic_job_offers.process_start_date',
  'process_end_date' => 'stic_job_offers.process_end_date',
  'offer_code' => 'stic_job_offers.offer_code',
  'applications_start_date' => 'stic_job_offers.applications_start_date',
  'applications_end_date' => 'stic_job_offers.applications_end_date',
  'type' => 'stic_job_offers.type',
  'stic_job_offers_accounts_name' => 'stic_job_offers.stic_job_offers_accounts_name',
  'assigned_user_id' => 'stic_job_offers.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  5 => 'professional_profile',
  6 => 'process_start_date',
  7 => 'process_end_date',
  9 => 'offer_code',
  10 => 'applications_start_date',
  13 => 'applications_end_date',
  14 => 'type',
  15 => 'stic_job_offers_accounts_name',
  18 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'offer_code' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_OFFER_CODE',
    'width' => '10%',
    'name' => 'offer_code',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'professional_profile' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_PROFESSIONAL_PROFILE',
    'width' => '10%',
    'name' => 'professional_profile',
  ),
  'process_start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_PROCESS_START_DATE',
    'width' => '10%',
    'name' => 'process_start_date',
  ),
  'process_end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_PROCESS_END_DATE',
    'width' => '10%',
    'name' => 'process_end_date',
  ),
  'applications_start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_APPLICATIONS_START_DATE',
    'width' => '10%',
    'name' => 'applications_start_date',
  ),
  'applications_end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_APPLICATIONS_END_DATE',
    'width' => '10%',
    'name' => 'applications_end_date',
  ),
  'type' => 
  array (
    'type' => 'multienum',
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'name' => 'type',
  ),
  'stic_job_offers_accounts_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_STIC_JOB_OFFERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'width' => '10%',
    'id' => 'STIC_JOB_OFFERS_ACCOUNTSACCOUNTS_IDA',
    'name' => 'stic_job_offers_accounts_name',
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
