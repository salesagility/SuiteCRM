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
// $viewdefs ['Campaigns'] =
// array(
//   'EditView' =>
//   array(
//     'templateMeta' =>
//     array(
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
//       'javascript' => '<script type="text/javascript" src="include/javascript/popup_parent_helper.js?v=igGzALk_bn-xeyTYyoHxog"></script>
// <script type="text/javascript">
// function type_change() {ldelim}
// 	type = document.getElementsByName(\'campaign_type\');
// 	if(type[0].value==\'NewsLetter\') {ldelim}
// 		document.getElementById(\'freq_label\').style.display = \'\';
// 		document.getElementById(\'freq_field\').style.display = \'\';
// 	 {rdelim} else {ldelim}
// 		document.getElementById(\'freq_label\').style.display = \'none\';
// 		document.getElementById(\'freq_field\').style.display = \'none\';
// 	 {rdelim}
//  {rdelim}
// type_change();

// function ConvertItems(id)  {ldelim}
// 	var items = new Array();

// 	//get the items that are to be converted
// 	expected_revenue = document.getElementById(\'expected_revenue\');
// 	budget = document.getElementById(\'budget\');
// 	actual_cost = document.getElementById(\'actual_cost\');
// 	expected_cost = document.getElementById(\'expected_cost\');

// 	//unformat the values of the items to be converted
// 	expected_revenue.value = unformatNumber(expected_revenue.value, num_grp_sep, dec_sep);
// 	expected_cost.value = unformatNumber(expected_cost.value, num_grp_sep, dec_sep);
// 	budget.value = unformatNumber(budget.value, num_grp_sep, dec_sep);
// 	actual_cost.value = unformatNumber(actual_cost.value, num_grp_sep, dec_sep);

// 	//add the items to an array
// 	items[items.length] = expected_revenue;
// 	items[items.length] = budget;
// 	items[items.length] = expected_cost;
// 	items[items.length] = actual_cost;

// 	//call function that will convert currency
// 	ConvertRate(id, items);

// 	//Add formatting back to items
// 	expected_revenue.value = formatNumber(expected_revenue.value, num_grp_sep, dec_sep);
// 	expected_cost.value = formatNumber(expected_cost.value, num_grp_sep, dec_sep);
// 	budget.value = formatNumber(budget.value, num_grp_sep, dec_sep);
// 	actual_cost.value = formatNumber(actual_cost.value, num_grp_sep, dec_sep);
//  {rdelim}
// </script>',
//       'useTabs' => false,
//       'tabDefs' =>
//       array(
//         'LBL_CAMPAIGN_INFORMATION' =>
//         array(
//           'newTab' => false,
//           'panelDefault' => 'expanded',
//         ),
//         'LBL_NAVIGATION_MENU_GEN2' =>
//         array(
//           'newTab' => false,
//           'panelDefault' => 'expanded',
//         ),
//       ),
//     ),
//     'panels' =>
//     array(
//       'lbl_campaign_information' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//             'name' => 'name',
//           ),
//           1 =>
//           array(
//             'name' => 'status',
//           ),
//         ),
//         1 =>
//         array(
//           0 =>
//           array(
//             'name' => 'start_date',
//             'displayParams' =>
//             array(
//               'required' => false,
//               'showFormats' => true,
//             ),
//           ),
//           1 =>
//           array(
//             'name' => 'campaign_type',
//             'displayParams' =>
//             array(
//               'javascript' => 'onchange="type_change();"',
//             ),
//           ),
//         ),
//         2 =>
//         array(
//           0 =>
//           array(
//             'name' => 'end_date',
//             'displayParams' =>
//             array(
//               'showFormats' => true,
//             ),
//           ),
//           1 =>
//           array(
//             'name' => 'frequency',
//             'customCode' => '<div style=\'none\' id=\'freq_field\'>{html_options name="frequency" options=$fields.frequency.options selected=$fields.frequency.value}</div></TD>',
//             'customLabel' => '<div style=\'none\' id=\'freq_label\'>{$MOD.LBL_CAMPAIGN_FREQUENCY}</div>',
//           ),
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'content',
//             'displayParams' =>
//             array(
//               'rows' => 8,
//               'cols' => 80,
//             ),
//           ),
//         ),
//         4 =>
//         array(
//           0 =>
//           array(
//             'name' => 'assigned_user_name',
//             'label' => 'LBL_ASSIGNED_TO',
//           ),
//         ),
//       ),
//       'LBL_NAVIGATION_MENU_GEN2' =>
//       array(
//         0 =>
//         array(
//           0 => 'currency_id',
//           1 => 'impressions',
//         ),
//         1 =>
//         array(
//           0 => 'budget',
//           1 => 'expected_cost',
//         ),
//         2 =>
//         array(
//           0 => 'actual_cost',
//           1 => 'expected_revenue',
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'objective',
//             'displayParams' =>
//             array(
//               'rows' => 8,
//               'cols' => 80,
//             ),
//           ),
//         ),
//       ),
//     ),
//   ),
// );

$viewdefs['Campaigns']['EditView'] = array (
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
    // STIC-Custom - JBL - 20240515 - Notify new Opportunities: New Campaign type (Notification)
    // https://github.com/SinergiaTIC/SinergiaCRM/pull/44
    // 'javascript' => '<script type="text/javascript" src="include/javascript/popup_parent_helper.js?v=igGzALk_bn-xeyTYyoHxog"></script>
    // <script type="text/javascript">
    // function type_change() {ldelim}
    // 	type = document.getElementsByName(\'campaign_type\');
    // 	if(type[0].value==\'NewsLetter\') {ldelim}
    // 		document.getElementById(\'freq_label\').style.display = \'\';
    // 		document.getElementById(\'freq_field\').style.display = \'\';
    // 	 {rdelim} else {ldelim}
    // 		document.getElementById(\'freq_label\').style.display = \'none\';
    // 		document.getElementById(\'freq_field\').style.display = \'none\';
    // 	 {rdelim}
    //  {rdelim}
    // type_change();

    // function ConvertItems(id)  {ldelim}
    // 	var items = new Array();

    // 	//get the items that are to be converted
    // 	expected_revenue = document.getElementById(\'expected_revenue\');
    // 	budget = document.getElementById(\'budget\');
    // 	actual_cost = document.getElementById(\'actual_cost\');
    // 	expected_cost = document.getElementById(\'expected_cost\');

    // 	//unformat the values of the items to be converted
    // 	expected_revenue.value = unformatNumber(expected_revenue.value, num_grp_sep, dec_sep);
    // 	expected_cost.value = unformatNumber(expected_cost.value, num_grp_sep, dec_sep);
    // 	budget.value = unformatNumber(budget.value, num_grp_sep, dec_sep);
    // 	actual_cost.value = unformatNumber(actual_cost.value, num_grp_sep, dec_sep);

    // 	//add the items to an array
    // 	items[items.length] = expected_revenue;
    // 	items[items.length] = budget;
    // 	items[items.length] = expected_cost;
    // 	items[items.length] = actual_cost;

    // 	//call function that will convert currency
    // 	ConvertRate(id, items);

    // 	//Add formatting back to items
    // 	expected_revenue.value = formatNumber(expected_revenue.value, num_grp_sep, dec_sep);
    // 	expected_cost.value = formatNumber(expected_cost.value, num_grp_sep, dec_sep);
    // 	budget.value = formatNumber(budget.value, num_grp_sep, dec_sep);
    // 	actual_cost.value = formatNumber(actual_cost.value, num_grp_sep, dec_sep);
    //  {rdelim}
    // </script>',
    'javascript' => '{sugar_getscript file="include/javascript/popup_parent_helper.js"}
                     {sugar_getscript file="SticInclude/js/Utils.js"}
                     {sugar_getscript file="custom/modules/Campaigns/SticUtils.js"}',
    // END STIC-Custom JBL
    'useTabs' => true,
    'tabDefs' => 
    array (
      'LBL_CAMPAIGN_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      // STIC-Custom - JBL - 20240620 - Notify new Opportunities: New Campaign type (Notification)
      // https://github.com/SinergiaTIC/SinergiaCRM/pull/44
      'LBL_NOTIFICATION_INFORMATION_PANEL' =>
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      // END STIC-Custom JBL
      'LBL_NAVIGATION_MENU_GEN2' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'lbl_campaign_information' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'name',
        ),
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'campaign_type',
          'displayParams' => 
          array (
            'javascript' => 'onchange="type_change();"',
          ),
        ),
        1 => 
        array (
          'name' => 'status',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'start_date',
          'displayParams' => 
          array (
            'required' => false,
            'showFormats' => true,
          ),
        ),
        1 => 
        array (
          'name' => 'end_date',
          'displayParams' => 
          array (
            'showFormats' => true,
          ),
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'frequency',
          // STIC-Custom - JBL - 20240611 - Notify new Opportunities: New Campaign type (Notification)
          // https://github.com/SinergiaTIC/SinergiaCRM/pull/44
          // 'customCode' => '<div style=\'none\' id=\'freq_field\'>{html_options name="frequency" options=$fields.frequency.options selected=$fields.frequency.value}</div></TD>',
          // 'customLabel' => '<div style=\'none\' id=\'freq_label\'>{$MOD.LBL_CAMPAIGN_FREQUENCY}</div>',
          // END STIC-Custom JBL
        ),
        // STIC-Custom - JBL - 20240611 - New Campaign type (Notification)
        // https://github.com/SinergiaTIC/SinergiaCRM/pull/44
        1 => array (
          'name' => 'parent_name',
        ),
        // END STIC-Custom JBL
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'content',
          'displayParams' => 
          array (
            // STIC-Custom - JBL - 20240620 - Notify new Opportunities: New Campaign type (Notification)
            // https://github.com/SinergiaTIC/SinergiaCRM/pull/44
            // 'rows' => 8,
            'rows' => 2,
            // END STIC-Custom JBL
            'cols' => 80,
          ),
        ),
      ),
    ),
    // STIC-Custom - JBL - 20240620 - Notify new Opportunities: New Campaign type (Notification)
    // https://github.com/SinergiaTIC/SinergiaCRM/pull/44
    'LBL_NOTIFICATION_INFORMATION_PANEL' =>
    array (
      0 => array(
        0 => array(
          'name' => 'notification_prospect_list_ids',
          'label' => 'LBL_NOTIFICATION_PROSPECT_LIST_ID',
        ),
        1 => array(
          'name' => 'notification_template_id',
          'label' => 'LBL_NOTIFICATION_TEMPLATE_ID',
        ),
      ),
      1 => array(
        0 => array(
          'name' => 'notification_outbound_email_id',
          'label' => 'LBL_NOTIFICATION_OUTBOUND_EMAIL_ID',
        ),
        1 => array(
          'name' => 'notification_inbound_email_id',
          'label' => 'LBL_NOTIFICATION_INBOUND_EMAIL_ID',
        ),
      ),
      2 => array(
        0 => array(
          'name' => 'notification_from_name',
          'label' => 'LBL_NOTIFICATION_FROM_NAME',
        ),
        1 => array(
          'name' => 'notification_from_addr',
          'label' => 'LBL_NOTIFICATION_FROM_ADDR',
        ),
      ),
      3 => array(
        0 => array(
          'name' => 'notification_reply_to_name',
          'label' => 'LBL_NOTIFICATION_REPLY_TO_NAME',
        ),
        1 => array(
          'name' => 'notification_reply_to_addr',
          'label' => 'LBL_NOTIFICATION_REPLY_TO_ADDR',
        ),
      ),
    ),
    // END STIC-Custom JBL
    'LBL_NAVIGATION_MENU_GEN2' => 
    array (
      0 => 
      array (
        0 => 'currency_id',
        1 => 'impressions',
      ),
      1 => 
      array (
        0 => 'budget',
        1 => 'expected_cost',
      ),
      2 => 
      array (
        0 => 'actual_cost',
        1 => 'expected_revenue',
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'objective',
          'displayParams' => 
          array (
            'rows' => 8,
            'cols' => 80,
          ),
        ),
        1 => '',
      ),
    ),
  ),
);
// END STIC-Custom