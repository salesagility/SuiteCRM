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

$module_name = 'FP_Event_Locations';

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $viewdefs [$module_name] =
// array(
//   'DetailView' =>
//   array(
//     'templateMeta' =>
//     array(
//       'form' =>
//       array(
//         'buttons' =>
//         array(
//           0 => 'EDIT',
//           1 => 'DUPLICATE',
//           2 => 'DELETE',
//           3 => 'FIND_DUPLICATES',
//         ),
//       ),
//       'maxColumns' => '2',
//       'widths' =>
//       array(
//         0 =>
//         array(
//           'label' => '10',
//           'field' => '30',
//         ),
//         1 =>
//         array(
//           'label' => '10',
//           'field' => '30',
//         ),
//       ),
//       'useTabs' => false,
//       'tabDefs' =>
//       array(
//         'DEFAULT' =>
//         array(
//           'newTab' => false,
//           'panelDefault' => 'expanded',
//         ),
//         'LBL_EDITVIEW_PANEL1' =>
//         array(
//           'newTab' => false,
//           'panelDefault' => 'expanded',
//         ),
//       ),
//       'syncDetailEditViews' => true,
//     ),
//     'panels' =>
//     array(
//       'default' =>
//       array(
//         0 =>
//         array(
//           0 => 'name',
//           1 => 'date_entered',
//         ),
//         1 =>
//         array(
//           0 => 'description',
//           1 =>
//           array(
//             'name' => 'capacity',
//             'label' => 'LBL_CAPACITY',
//           ),
//         ),
//       ),
//       'lbl_editview_panel1' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//             'name' => 'address',
//             'label' => 'LBL_ADDRESS',
//           ),
//           1 => '',
//         ),
//         1 =>
//         array(
//           0 =>
//           array(
//             'name' => 'address_city',
//             'label' => 'LBL_ADDRESS_CITY',
//           ),
//           1 => '',
//         ),
//         2 =>
//         array(
//           0 =>
//           array(
//             'name' => 'address_postalcode',
//             'label' => 'LBL_ADDRESS_POSTALCODE',
//           ),
//           1 => '',
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'address_state',
//             'label' => 'LBL_ADDRESS_STATE',
//           ),
//           1 => '',
//         ),
//         4 =>
//         array(
//           0 =>
//           array(
//             'name' => 'address_country',
//             'label' => 'LBL_ADDRESS_COUNTRY',
//           ),
//           1 => '',
//         ),
//       ),
//     ),
//   ),
// );

$viewdefs['FP_Event_Locations']['DetailView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'buttons' => 
      array (
        0 => 'EDIT',
        1 => 'DUPLICATE',
        2 => 'DELETE',
        3 => 'FIND_DUPLICATES',
      ),
    ),
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
      'LBL_FP_EVENT_LOCATIONS_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_ADDRESS' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_RECORD_DETAILS' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => true,
  ),
  'panels' => 
  array (
    'lbl_fp_event_locations_information' => 
    array (
      0 => 
      array (
        0 => 'name',
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'capacity',
          'label' => 'LBL_CAPACITY',
        ),
        1 => '',
      ),
      2 => 
      array (
        0 => 'description',
      ),
    ),
    'lbl_stic_panel_address' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'address',
          'label' => 'LBL_ADDRESS',
        ),
        1 => '',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'address_postalcode',
          'label' => 'LBL_ADDRESS_POSTALCODE',
        ),
        1 => '',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'address_city',
          'label' => 'LBL_ADDRESS_CITY',
        ),
        1 => '',
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'stic_address_county_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ADDRESS_COUNTY',
        ),
        1 => '',
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'address_state',
          'label' => 'LBL_ADDRESS_STATE',
        ),
        1 => '',
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'stic_address_region_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ADDRESS_REGION',
        ),
        1 => '',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'address_country',
          'label' => 'LBL_ADDRESS_COUNTRY',
        ),
        1 => '',
      ),
    ),
    'lbl_stic_panel_record_details' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'created_by_name',
          'label' => 'LBL_CREATED',
        ),
        1 => 
        array (
          'name' => 'date_entered',
          'customCode' => '{$fields.date_entered.value}',
          'label' => 'LBL_DATE_ENTERED',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'modified_by_name',
          'label' => 'LBL_MODIFIED_NAME',
        ),
        1 => 
        array (
          'name' => 'date_modified',
          'customCode' => '{$fields.date_modified.value}',
          'label' => 'LBL_DATE_MODIFIED',
        ),
      ),
    ),
  ),
);
// END STIC-Custom