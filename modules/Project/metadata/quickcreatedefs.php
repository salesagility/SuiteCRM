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
// $viewdefs['Project']['QuickCreate'] = array(
//                     'templateMeta' => array('maxColumns' => '2',
//                         'widths' => array(
//                                         array('label' => '10', 'field' => '30'),
//                                         array('label' => '10', 'field' => '30')
//                                         ),
//                        ),
// 'panels' =>

// array(
  
//   array(
//     'name',
//     'status'
//   ),
  
//   array(
//     'estimated_start_date',
//     'estimated_end_date'
//   ),
  
//   array('priority',),
//   array('assigned_user_name',
//   ),

// ),

// );

$viewdefs['Project']['QuickCreate'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '2',
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'useTabs' => true,
    'tabDefs' => 
    array (
      'LBL_OVERVIEW_PANEL' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'lbl_overview_panel' => 
    array (
      0 => 
      array (
        0 => 'name',
        1 => 'assigned_user_name',
      ),
      1 => 
      array (
        0 => 'estimated_start_date',
        1 => 'estimated_end_date',
      ),
      2 => 
      array (
        0 => 'status',
        1 => 
        array (
          'name' => 'am_projecttemplates_project_1_name',
          'label' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
        ),
      ),
      3 => 
      array (
        0 => 'priority',
        1 => 
        array (
          'name' => 'override_business_hours',
          'comment' => '',
          'label' => 'LBL_OVERRIDE_BUSINESS_HOURS',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'stic_location_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_LOCATION',
        ),
        1 => '',
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'comment' => 'Project description',
          'label' => 'LBL_DESCRIPTION',
        ),
      ),
    ),
  ),
);
// END STIC-Custom