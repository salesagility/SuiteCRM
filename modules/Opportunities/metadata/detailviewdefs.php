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
// $viewdefs ['Opportunities'] =
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
//       'useTabs' => true,
//       'tabDefs' =>
//       array(
//         'DEFAULT' =>
//         array(
//           'newTab' => true,
//           'panelDefault' => 'expanded',
//         ),
//         'LBL_PANEL_ASSIGNMENT' =>
//         array(
//           'newTab' => true,
//           'panelDefault' => 'expanded',
//         ),
//       ),
//     ),
//     'panels' =>
//     array(
//       'default' =>
//       array(
//         0 =>
//         array(
//           0 => 'name',
//           1 => 'account_name',
//         ),
//         1 =>
//         array(
//           0 =>
//           array(
//             'name' => 'amount',
//             'label' => '{$MOD.LBL_AMOUNT} ({$CURRENCY})',
//           ),
//           1 => 'date_closed',
//         ),
//         2 =>
//         array(
//           0 => 'sales_stage',
//           1 => 'opportunity_type',
//         ),
//         3 =>
//         array(
//           0 => 'probability',
//           1 => 'lead_source',
//         ),
//         4 =>
//         array(
//           0 => 'next_step',
//           1 => 'campaign_name',
//         ),
//         5 =>
//         array(
//           0 =>
//           array(
//             'name' => 'description',
//             'nl2br' => true,
//           ),
//         ),
//         6 =>
//         array(
//           0 =>
//           array(
//             'name' => 'assigned_user_name',
//             'label' => 'LBL_ASSIGNED_TO',
//           ),
//         ),
//       ),
//       'LBL_PANEL_ASSIGNMENT' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//             'name' => 'date_modified',
//             'label' => 'LBL_DATE_MODIFIED',
//             'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
//           ),
//           1 =>
//           array(
//             'name' => 'date_entered',
//             'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
//           ),
//         ),
//       ),
//     ),
//   ),
// );

$viewdefs['Opportunities']['DetailView'] = array (
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
      'LBL_OPPORTUNITIES_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_RECORD_DETAILS' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'LBL_OPPORTUNITIES_INFORMATION' => 
    array (
      0 => 
      array (
        0 => 'name',
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
        ),
      ),
      1 => 
      array (
        0 => 'account_name',
        1 => 
        array (
          'name' => 'stic_type_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_TYPE',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'stic_target_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_TARGET',
        ),
        1 => 
        array (
          'name' => 'project_opportunities_1_name',
          'label' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_PROJECT_TITLE',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'stic_status_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_STATUS',
        ),
        1 => 
        array (
          'name' => 'stic_documentation_to_deliver_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_DOCUMENTATION_TO_DELIVER',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'amount',
          'label' => '{$MOD.LBL_AMOUNT} ({$CURRENCY})',
        ),
        1 => 
        array (
          'name' => 'stic_amount_awarded_c',
          'label' => '{$MOD.LBL_STIC_AMOUNT_AWARDED} ({$CURRENCY})',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'stic_amount_received_c',
          'label' => '{$MOD.LBL_STIC_AMOUNT_RECEIVED} ({$CURRENCY})',
        ),
        1 => 
        array (
          'name' => 'stic_presentation_date_c',
          'label' => 'LBL_STIC_PRESENTATION_DATE',
        ),
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'stic_resolution_date_c',
          'label' => 'LBL_STIC_RESOLUTION_DATE',
        ),
        1 => 
        array (
          'name' => 'stic_advance_date_c',
          'label' => 'LBL_STIC_ADVANCE_DATE',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'stic_justification_date_c',
          'label' => 'LBL_STIC_JUSTIFICATION_DATE',
        ),
        1 => 
        array (
          'name' => 'stic_payment_date_c',
          'label' => 'LBL_STIC_PAYMENT_DATE',
        ),
      ),
      8 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'nl2br' => true,
        ),
      ),
    ),
    'LBL_STIC_PANEL_RECORD_DETAILS' => 
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
          'label' => 'LBL_DATE_MODIFIED',
          'customCode' => '{$fields.date_modified.value}',
        ),
      ),
    ),
  ),
);
// END STIC-Custom