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
// $popupMeta = array('moduleMain' => 'Project',
//                         'varName' => 'PROJECT',
//                         'orderBy' => 'name',
//                         'whereClauses' =>
//                             array('name' => 'project.name'),
//                         'searchInputs' =>
//                             array('name')
//                         );

$popupMeta = array (
    'moduleMain' => 'Project',
    'varName' => 'PROJECT',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'project.name',
  'status' => 'project.status',
  'estimated_start_date' => 'project.estimated_start_date',
  'estimated_end_date' => 'project.estimated_end_date',
  'assigned_user_name' => 'project.assigned_user_name',
  'total_estimated_effort' => 'project.total_estimated_effort',
  'created_by' => 'project.created_by',
  'current_user_only' => 'project.current_user_only',
  'favorites_only' => 'project.favorites_only',
  'priority' => 'project.priority',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'status',
  2 => 'estimated_start_date',
  3 => 'estimated_end_date',
  5 => 'assigned_user_name',
  7 => 'total_estimated_effort',
  13 => 'created_by',
  16 => 'current_user_only',
  17 => 'favorites_only',
  18 => 'priority',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'status' => 
  array (
    'name' => 'status',
    'width' => '10%',
  ),
  'estimated_start_date' => 
  array (
    'name' => 'estimated_start_date',
    'width' => '10%',
  ),
  'estimated_end_date' => 
  array (
    'name' => 'estimated_end_date',
    'width' => '10%',
  ),
  'priority' => 
  array (
    'name' => 'priority',
    'width' => '10%',
  ),
  'assigned_user_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ASSIGNED_USER_NAME',
    'width' => '10%',
    'id' => 'ASSIGNED_USER_ID',
    'name' => 'assigned_user_name',
  ),
  'total_estimated_effort' => 
  array (
    'type' => 'int',
    'label' => 'LBL_LIST_TOTAL_ESTIMATED_EFFORT',
    'width' => '10%',
    'name' => 'total_estimated_effort',
  ),
  'created_by' => 
  array (
    'type' => 'assigned_user_name',
    'label' => 'LBL_CREATED_BY',
    'width' => '10%',
    'name' => 'created_by',
  ),
  'current_user_only' => 
  array (
    'label' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
    'width' => '10%',
    'name' => 'current_user_only',
  ),
  'favorites_only' => 
  array (
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => '10%',
    'name' => 'favorites_only',
  ),
),
);
// END STIC-Custom