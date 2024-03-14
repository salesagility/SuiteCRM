<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $dashletData['ProjectDashlet']['searchFields'] = array(
//   'date_entered' =>
//   array(
//     'default' => '',
//   ),
//   'date_modified' =>
//   array(
//     'default' => '',
//   ),
//   'assigned_user_id' =>
//   array(
//     'type' => 'assigned_user_name',
//     'default' => 'Administrator',
//   ),
// );
// $dashletData['ProjectDashlet']['columns'] = array(
//   'name' =>
//   array(
//     'width' => '30%',
//     'label' => 'LBL_LIST_NAME',
//     'link' => true,
//     'default' => true,
//     'name' => 'name',
//   ),
//   'status' =>
//   array(
//     'type' => 'enum',
//     'default' => true,
//     'label' => 'LBL_STATUS',
//     'width' => '10%',
//     'name' => 'status',
//   ),
//   'estimated_start_date' =>
//   array(
//     'type' => 'date',
//     'label' => 'LBL_DATE_START',
//     'width' => '10%',
//     'default' => true,
//     'name' => 'estimated_start_date',
//   ),
//   'assigned_user_name' =>
//   array(
//     'width' => '8%',
//     'label' => 'LBL_LIST_ASSIGNED_USER',
//     'name' => 'assigned_user_name',
//     'default' => true,
//   ),
//   'estimated_end_date' =>
//   array(
//     'type' => 'date',
//     'label' => 'LBL_DATE_END',
//     'width' => '10%',
//     'default' => true,
//     'name' => 'estimated_end_date',
//   ),
//   'date_modified' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_DATE_MODIFIED',
//     'name' => 'date_modified',
//     'default' => false,
//   ),
//   'date_entered' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_DATE_ENTERED',
//     'default' => false,
//     'name' => 'date_entered',
//   ),
//   'created_by' =>
//   array(
//     'width' => '8%',
//     'label' => 'LBL_CREATED',
//     'name' => 'created_by',
//     'default' => false,
//   ),
// );

$dashletData['ProjectDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'estimated_start_date' => 
  array (
    'default' => '',
  ),
  'estimated_end_date' => 
  array (
    'default' => '',
  ),
  'status' => 
  array (
    'default' => '',
  ),
  'stic_location_c' => 
  array (
    'default' => '',
  ),
  'priority' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'default' => '',
  ),
);
$dashletData['ProjectDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '30%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'name' => 'status',
  ),
  'estimated_start_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATE_START',
    'width' => '10%',
    'default' => true,
    'name' => 'estimated_start_date',
  ),
  'estimated_end_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATE_END',
    'width' => '10%',
    'default' => true,
    'name' => 'estimated_end_date',
  ),
  'stic_location_c' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_LOCATION',
    'width' => '10%',
    'name' => 'stic_location_c',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => true,
  ),
  'override_business_hours' => 
  array (
    'type' => 'bool',
    'default' => false,
    'label' => 'LBL_OVERRIDE_BUSINESS_HOURS',
    'width' => '10%',
  ),
  'am_projecttemplates_project_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
    'id' => 'AM_PROJECTTEMPLATES_PROJECT_1AM_PROJECTTEMPLATES_IDA',
    'width' => '10%',
    'default' => false,
  ),
  'total_actual_effort' => 
  array (
    'type' => 'int',
    'label' => 'LBL_LIST_TOTAL_ACTUAL_EFFORT',
    'width' => '10%',
    'default' => false,
  ),
  'total_estimated_effort' => 
  array (
    'type' => 'int',
    'label' => 'LBL_LIST_TOTAL_ESTIMATED_EFFORT',
    'width' => '10%',
    'default' => false,
  ),
  'priority' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_PRIORITY',
    'width' => '10%',
    'default' => false,
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
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
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
);
// END STIC-Custom