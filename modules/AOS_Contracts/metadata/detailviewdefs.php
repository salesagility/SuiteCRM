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

$module_name = 'AOS_Contracts';

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
//           4 =>
//           array(
//             'customCode' => '<input type="button" class="button" onClick="showPopup(\'pdf\');" value="{$MOD.LBL_PRINT_AS_PDF}">',
//           ),
//           5 =>
//           array(
//             'customCode' => '<input type="button" class="button" onClick="showPopup(\'emailpdf\');" value="{$MOD.LBL_EMAIL_PDF}">',
//           ),
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
//       'syncDetailEditViews' => true,
//       'tabDefs' =>
//       array(
//         'DEFAULT' =>
//         array(
//           'newTab' => true,
//           'panelDefault' => 'expanded',
//         ),
//         'LBL_LINE_ITEMS' =>
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
//           1 =>
//           array(
//             'name' => 'status',
//             'studio' => 'visible',
//             'label' => 'LBL_STATUS',
//           ),
//         ),
//         1 =>
//         array(
//           0 =>
//           array(
//             'name' => 'total_contract_value',
//             'label' => 'LBL_TOTAL_CONTRACT_VALUE',
//           ),
//           1 =>
//           array(
//             'name' => 'assigned_user_name',
//             'label' => 'LBL_ASSIGNED_TO_NAME',
//           ),
//         ),
//         2 =>
//         array(
//           0 =>
//           array(
//             'name' => 'start_date',
//             'label' => 'LBL_START_DATE',
//           ),
//           1 =>
//           array(
//             'name' => 'contract_account',
//             'label' => 'LBL_CONTRACT_ACCOUNT',
//           ),
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'end_date',
//             'label' => 'LBL_END_DATE',
//           ),
//           1 =>
//           array(
//             'name' => 'contact',
//             'studio' => 'visible',
//             'label' => 'LBL_CONTACT',
//           ),
//         ),
//         4 =>
//         array(
//           0 =>
//           array(
//             'name' => 'renewal_reminder_date',
//             'label' => 'LBL_RENEWAL_REMINDER_DATE',
//           ),
//           1 =>
//           array(
//             'name' => 'opportunity',
//             'label' => 'LBL_OPPORTUNITY',
//           ),
//         ),
//         5 =>
//         array(
//           0 =>
//           array(
//             'name' => 'customer_signed_date',
//             'label' => 'LBL_CUSTOMER_SIGNED_DATE',
//           ),
//           1 =>
//           array(
//             'name' => 'contract_type',
//             'studio' => 'visible',
//             'label' => 'LBL_CONTRACT_TYPE',
//           ),
//         ),
//         6 =>
//         array(
//           0 =>
//           array(
//             'name' => 'company_signed_date',
//             'label' => 'LBL_COMPANY_SIGNED_DATE',
//           ),
//           1 => '',
//         ),
//         7 =>
//         array(
//           0 => 'description',
//         ),
//       ),
//       'lbl_line_items' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//             'name' => 'currency_id',
//             'studio' => 'visible',
//             'label' => 'LBL_CURRENCY',
//           ),
//         ),
//         1 =>
//         array(
//           0 =>
//           array(
//             'name' => 'line_items',
//             'label' => 'LBL_LINE_ITEMS',
//           ),
//         ),
//         2 =>
//         array(
//           0 => '',
//           1 => '',
//         ),
//         3 =>
//         array(
//           0 =>
//           array(
//             'name' => 'total_amt',
//             'label' => 'LBL_TOTAL_AMT',
//           ),
//         ),
//         4 =>
//         array(
//           0 =>
//           array(
//             'name' => 'discount_amount',
//             'label' => 'LBL_DISCOUNT_AMOUNT',
//           ),
//         ),
//         5 =>
//         array(
//           0 =>
//           array(
//             'name' => 'subtotal_amount',
//             'label' => 'LBL_SUBTOTAL_AMOUNT',
//           ),
//         ),
//         6 =>
//         array(
//           0 =>
//           array(
//             'name' => 'shipping_amount',
//             'label' => 'LBL_SHIPPING_AMOUNT',
//           ),
//         ),
//         7 =>
//         array(
//           0 =>
//           array(
//             'name' => 'shipping_tax_amt',
//             'label' => 'LBL_SHIPPING_TAX_AMT',
//           ),
//         ),
//         8 =>
//         array(
//           0 =>
//           array(
//             'name' => 'tax_amount',
//             'label' => 'LBL_TAX_AMOUNT',
//           ),
//         ),
//         9 =>
//         array(
//           0 =>
//           array(
//             'name' => 'total_amount',
//             'label' => 'LBL_GRAND_TOTAL',
//           ),
//         ),
//       ),
//       'LBL_PANEL_ASSIGNMENT' =>
//       array(
//         0 =>
//         array(
//           0 =>
//           array(
//               'name' => 'date_entered',
//               'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
//           ),
//           1 =>
//           array(
//               'name' => 'date_modified',
//               'label' => 'LBL_DATE_MODIFIED',
//               'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
//           ),
//         ),
//       ),
//     ),
//   ),
// );

$viewdefs[$module_name] =
array(
    'DetailView' => array(
        'templateMeta' => array(
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                    4 => array(
                        'customCode' => '<input type="button" class="button" onClick="showPopup(\'pdf\');" value="{$MOD.LBL_PRINT_AS_PDF}">',
                    ),
                    5 => array(
                        'customCode' => '<input type="button" class="button" onClick="showPopup(\'emailpdf\');" value="{$MOD.LBL_EMAIL_PDF}">',
                    ),
                ),
            ),
            'maxColumns' => '2',
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'syncDetailEditViews' => true,
            'tabDefs' => array(
                'LBL_DEFAULT_PANEL' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
                'LBL_LINE_ITEMS' => array(
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ),
                'LBL_PANEL_RECORD_DETAILS' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'LBL_DEFAULT_PANEL' => array(
                0 => array(
                    0 => 'name',
                    1 => array(
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_TO_NAME',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'contract_account',
                        'label' => 'LBL_CONTRACT_ACCOUNT',
                    ),
                    1 => array(
                        'name' => 'contact',
                        'studio' => 'visible',
                        'label' => 'LBL_CONTACT',
                    ),
                ),
                2 => array(
                    0 => '',
                    1 => array(
                        'name' => 'opportunity',
                        'label' => 'LBL_OPPORTUNITY',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                    1 => array(
                        'name' => 'total_contract_value',
                        'label' => 'LBL_TOTAL_CONTRACT_VALUE',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'contract_type',
                        'studio' => 'visible',
                        'label' => 'LBL_CONTRACT_TYPE',
                    ),
                    1 => array(
                        'name' => 'reference_code',
                        'label' => 'LBL_REFERENCE_CODE ',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ),
                    1 => array(
                        'name' => 'end_date',
                        'label' => 'LBL_END_DATE',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'company_signed_date',
                        'label' => 'LBL_COMPANY_SIGNED_DATE',
                    ),
                    1 => array(
                        'name' => 'customer_signed_date',
                        'label' => 'LBL_CUSTOMER_SIGNED_DATE',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'renewal_reminder_date',
                        'label' => 'LBL_RENEWAL_REMINDER_DATE',
                    ),
                    1 => '',
                ),
                8 => array(
                    0 => 'description',
                ),
            ),
            'lbl_line_items' => array(
                0 => array(
                    0 => array(
                        'name' => 'currency_id',
                        'studio' => 'visible',
                        'label' => 'LBL_CURRENCY',
                    ),
                    1 => '',
                ),
                1 => array(
                    0 => array(
                        'name' => 'line_items',
                        'label' => 'LBL_LINE_ITEMS',
                    ),
                ),
                2 => array(
                    0 => '',
                ),
                3 => array(
                    0 => array(
                        'name' => 'total_amt',
                        'label' => 'LBL_TOTAL_AMT',
                    ),
                    1 => '',
                ),
                4 => array(
                    0 => array(
                        'name' => 'discount_amount',
                        'label' => 'LBL_DISCOUNT_AMOUNT',
                    ),
                    1 => '',
                ),
                5 => array(
                    0 => array(
                        'name' => 'subtotal_amount',
                        'label' => 'LBL_SUBTOTAL_AMOUNT',
                    ),
                    1 => '',
                ),
                6 => array(
                    0 => array(
                        'name' => 'shipping_amount',
                        'label' => 'LBL_SHIPPING_AMOUNT',
                    ),
                    1 => '',
                ),
                7 => array(
                    0 => array(
                        'name' => 'shipping_tax_amt',
                        'label' => 'LBL_SHIPPING_TAX_AMT',
                    ),
                    1 => '',
                ),
                8 => array(
                    0 => array(
                        'name' => 'tax_amount',
                        'label' => 'LBL_TAX_AMOUNT',
                    ),
                    1 => '',
                ),
                9 => array(
                    0 => array(
                        'name' => 'total_amount',
                        'label' => 'LBL_GRAND_TOTAL',
                    ),
                    1 => '',
                ),
            ),
            'LBL_PANEL_RECORD_DETAILS' => array(
                0 => array(
                    0 => array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                    ),
                    1 => array(
                        'name' => 'date_entered',
                        'comment' => 'Date record created',
                        'label' => 'LBL_DATE_ENTERED',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'modified_by_name',
                        'label' => 'LBL_MODIFIED_NAME',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'comment' => 'Date record last modified',
                        'label' => 'LBL_DATE_MODIFIED',
                    ),
                ),
            ),
        ),
    ),
);
// END STIC-Custom