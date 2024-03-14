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

global $sugar_config;

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $listViewDefs ['AOS_Contracts'] =
// array(
//   'NAME' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_NAME',
//     'default' => true,
//     'link' => true,
//   ),
//   'STATUS' =>
//   array(
//     'type' => 'enum',
//     'default' => true,
//     'studio' => 'visible',
//     'label' => 'LBL_STATUS',
//     'sortable' => false,
//     'width' => '10%',
//   ),
//   'ASSIGNED_USER_NAME' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ASSIGNED_TO_NAME',
//     'default' => true,
//     'module' => 'Users',
//     'id' => 'ASSIGNED_USER_ID',
//     'link' => true,
//   ),
//   'CONTRACT_ACCOUNT' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_CONTRACT_ACCOUNT',
//     'default' => true,
//     'module' => 'Accounts',
//     'id' => 'CONTRACT_ACCOUNT_ID',
//     'link' => true,
//       'related_fields' =>
//           array(
//               'contract_account_id',
//           ),
//   ),
//   'TOTAL_CONTRACT_VALUE' =>
//   array(
//     'label' => 'LBL_TOTAL_CONTRACT_VALUE',
//     'currency_format' => true,
//     'width' => '10%',
//     'default' => true,
//   ),
//   'START_DATE' =>
//   array(
//     'type' => 'date',
//     'label' => 'LBL_START_DATE',
//     'width' => '10%',
//     'default' => true,
//   ),
//   'END_DATE' =>
//   array(
//     'type' => 'date',
//     'label' => 'LBL_END_DATE',
//     'width' => '10%',
//     'default' => true,
//   ),
//   'DATE_ENTERED' =>
//   array(
//     'width' => '5%',
//     'label' => 'LBL_DATE_ENTERED',
//     'default' => preg_match('/^6\.?[2-9]/', $sugar_config['sugar_version']),
//   ),
// );

$listViewDefs['AOS_Contracts'] =
array(
    'NAME' => array(
        'width' => '15%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'REFERENCE_CODE' => array(
        'type' => 'varchar',
        'label' => 'LBL_REFERENCE_CODE ',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'sortable' => false,
        'width' => '10%',
    ),
    'TOTAL_CONTRACT_VALUE' => array(
        'label' => 'LBL_TOTAL_CONTRACT_VALUE',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
    ),
    'TOTAL_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_GRAND_TOTAL',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
    ),
    'START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
        'align' => 'center',
    ),
    'END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
        'align' => 'center',
    ),
    'CONTACT' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT',
        'id' => 'CONTACT_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
    ),
    'CONTRACT_ACCOUNT' => array(
        'width' => '15%',
        'label' => 'LBL_CONTRACT_ACCOUNT',
        'default' => true,
        'module' => 'Accounts',
        'id' => 'CONTRACT_ACCOUNT_ID',
        'link' => true,
        'related_fields' => array(
            0 => 'contract_account_id',
        ),
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '10%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'default' => true,
        'module' => 'Users',
        'id' => 'ASSIGNED_USER_ID',
        'link' => true,
    ),
    'OPPORTUNITY' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_OPPORTUNITY',
        'id' => 'OPPORTUNITY_ID',
        'link' => true,
        'width' => '10%',
        'default' => false,
    ),
    'CURRENCY_ID' => array(
        'type' => 'id',
        'studio' => 'visible',
        'label' => 'LBL_CURRENCY',
        'width' => '10%',
        'default' => false,
    ),
    'TAX_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_TAX_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'SHIPPING_TAX_AMT' => array(
        'type' => 'currency',
        'label' => 'LBL_SHIPPING_TAX_AMT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'SHIPPING_TAX' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SHIPPING_TAX',
        'width' => '10%',
        'default' => false,
    ),
    'SHIPPING_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_SHIPPING_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'DISCOUNT_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_DISCOUNT_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'SUBTOTAL_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_SUBTOTAL_AMOUNT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'TOTAL_AMT' => array(
        'type' => 'currency',
        'label' => 'LBL_TOTAL_AMT',
        'currency_format' => true,
        'width' => '10%',
        'default' => false,
    ),
    'CONTRACT_TYPE' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_CONTRACT_TYPE',
        'width' => '10%',
    ),
    'RENEWAL_REMINDER_DATE' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_RENEWAL_REMINDER_DATE',
        'width' => '10%',
        'default' => false,
    ),
    'COMPANY_SIGNED_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_COMPANY_SIGNED_DATE',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
    'CUSTOMER_SIGNED_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_CUSTOMER_SIGNED_DATE',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'align' => 'center',
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
);
// END STIC-Custom