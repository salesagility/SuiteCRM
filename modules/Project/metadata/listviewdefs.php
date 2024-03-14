<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
// $listViewDefs ['Project'] =
// array(
//   'NAME' =>
//   array(
//     'width' => '25%',
//     'label' => 'LBL_LIST_NAME',
//     'link' => true,
//     'default' => true,
//   ),
//   'PRIORITY' =>
//   array(
//     'type' => 'enum',
//     'label' => 'LBL_PRIORITY',
//     'width' => '10%',
//     'default' => true,
//   ),
//   'STATUS' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_STATUS',
//     'link' => false,
//     'default' => true,
//   ),
//   'ESTIMATED_START_DATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_DATE_START',
//     'link' => false,
//     'default' => true,
//   ),
//   'ASSIGNED_USER_NAME' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LIST_ASSIGNED_USER_ID',
//     'module' => 'Employees',
//     'id' => 'ASSIGNED_USER_ID',
//     'default' => true,
//   ),
//   'ESTIMATED_END_DATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_DATE_END',
//     'link' => false,
//     'default' => true,
//   ),
// );

$listViewDefs['Project'] = array (
  'NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
  ),
  'STATUS' => 
  array (
    'width' => '10%',
    'label' => 'LBL_STATUS',
    'link' => false,
    'default' => true,
  ),
  'ESTIMATED_START_DATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_START',
    'link' => false,
    'default' => true,
  ),
  'ESTIMATED_END_DATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_END',
    'link' => false,
    'default' => true,
  ),
  'STIC_LOCATION_C' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_LOCATION',
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_ASSIGNED_USER_ID',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'PRIORITY' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_PRIORITY',
    'width' => '10%',
    'default' => false,
  ),
  'OVERRIDE_BUSINESS_HOURS' => 
  array (
    'type' => 'bool',
    'default' => false,
    'label' => 'LBL_OVERRIDE_BUSINESS_HOURS',
    'width' => '10%',
  ),
  'AM_PROJECTTEMPLATES_PROJECT_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
    'id' => 'AM_PROJECTTEMPLATES_PROJECT_1AM_PROJECTTEMPLATES_IDA',
    'width' => '10%',
    'default' => false,
  ),
  'TOTAL_ACTUAL_EFFORT' => 
  array (
    'type' => 'int',
    'label' => 'LBL_LIST_TOTAL_ACTUAL_EFFORT',
    'width' => '10%',
    'default' => false,
  ),
  'TOTAL_ESTIMATED_EFFORT' => 
  array (
    'type' => 'int',
    'label' => 'LBL_LIST_TOTAL_ESTIMATED_EFFORT',
    'width' => '10%',
    'default' => false,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => false,
  ),
);
// END STIC-Custom