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
// $listViewDefs['AOS_Invoices'] =
// array(
//   'NUMBER' =>
//   array(
//     'width' => '5%',
//     'label' => 'LBL_LIST_NUM',
//     'default' => true,
//   ),
//   'NAME' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_ACCOUNT_NAME',
//     'link' => true,
//     'default' => true,
//   ),
//   'STATUS' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_STATUS',
//     'default' => true,
//   ),
//   'BILLING_CONTACT' =>
//   array(
//     'width' => '11%',
//     'label' => 'LBL_BILLING_CONTACT',
//     'default' => true,
//     'module' => 'Contacts',
//     'id' => 'BILLING_CONTACT_ID',
//     'link' => true,
//       'related_fields' =>
//           array(
//               'billing_contact_id',
//           ),
//   ),
//   'BILLING_ACCOUNT' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_BILLING_ACCOUNT',
//     'default' => true,
//     'module' => 'Accounts',
//     'id' => 'BILLING_ACCOUNT_ID',
//     'link' => true,
//       'related_fields' =>
//           array(
//               'billing_account_id',
//           ),
//   ),
//   'TOTAL_AMOUNT' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_GRAND_TOTAL',
//     'default' => true,
//     'currency_format' => true,
//   ),
//   'DUE_DATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_DUE_DATE',
//     'default' => true,
//   ),
//   'ASSIGNED_USER_NAME' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ASSIGNED_USER',
//     'default' => true,
//     'module' => 'Users',
//     'id' => 'ASSIGNED_USER_ID',
//     'link' => true,
//     'related_fields' => array('assigned_user_id')
//   ),
//   'ANNUAL_REVENUE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_ANNUAL_REVENUE',
//     'default' => false,
//   ),
//   'BILLING_ADDRESS_STREET' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_BILLING_ADDRESS_STREET',
//     'default' => false,
//   ),
//   'BILLING_ADDRESS_CITY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_CITY',
//     'default' => false,
//   ),
//   'BILLING_ADDRESS_STATE' =>
//   array(
//     'width' => '7%',
//     'label' => 'LBL_BILLING_ADDRESS_STATE',
//     'default' => false,
//   ),
//   'BILLING_ADDRESS_POSTALCODE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
//     'default' => false,
//   ),
//   'BILLING_ADDRESS_COUNTRY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
//     'default' => false,
//   ),
//   'SHIPPING_ADDRESS_STREET' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_SHIPPING_ADDRESS_STREET',
//     'default' => false,
//   ),
//   'SHIPPING_ADDRESS_CITY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_SHIPPING_ADDRESS_CITY',
//     'default' => false,
//   ),
//   'SHIPPING_ADDRESS_STATE' =>
//   array(
//     'width' => '7%',
//     'label' => 'LBL_SHIPPING_ADDRESS_STATE',
//     'default' => false,
//   ),
//   'SHIPPING_ADDRESS_POSTALCODE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
//     'default' => false,
//   ),
//   'SHIPPING_ADDRESS_COUNTRY' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
//     'default' => false,
//   ),
//   'PHONE_ALTERNATE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_PHONE_ALT',
//     'default' => false,
//   ),
//   'WEBSITE' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_WEBSITE',
//     'default' => false,
//   ),
//   'OWNERSHIP' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_OWNERSHIP',
//     'default' => false,
//   ),
//   'EMPLOYEES' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_EMPLOYEES',
//     'default' => false,
//   ),
//   'TICKER_SYMBOL' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_TICKER_SYMBOL',
//     'default' => false,
//   ),
//   'DATE_ENTERED' =>
//   array(
//     'width' => '5%',
//     'label' => 'LBL_DATE_ENTERED',
//     'default' => preg_match('/^6\.?[2-9]/', $sugar_config['sugar_version']),
//   ),
// );

$listViewDefs['AOS_Invoices'] =
array(
    'NUMBER' => array(
        'width' => '5%',
        'label' => 'LBL_LIST_NUM',
        'default' => true,
    ),
    'NAME' => array(
        'width' => '15%',
        'label' => 'LBL_ACCOUNT_NAME',
        'link' => true,
        'default' => true,
    ),
    'QUOTE_NUMBER' => array(
        'type' => 'int',
        'label' => 'LBL_QUOTE_NUMBER',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'width' => '10%',
        'label' => 'LBL_STATUS',
        'default' => true,
    ),
    'TOTAL_AMOUNT' => array(
        'width' => '10%',
        'label' => 'LBL_GRAND_TOTAL',
        'default' => true,
        'currency_format' => true,
    ),
    'INVOICE_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_INVOICE_DATE',
        'width' => '10%',
        'default' => true,
        'align' => 'center',
    ),
    'DUE_DATE' => array(
        'width' => '10%',
        'label' => 'LBL_DUE_DATE',
        'default' => true,
        'align' => 'center',
    ),
    'BILLING_CONTACT' => array(
        'width' => '11%',
        'label' => 'LBL_BILLING_CONTACT',
        'default' => true,
        'module' => 'Contacts',
        'id' => 'BILLING_CONTACT_ID',
        'link' => true,
        'related_fields' => array(
            0 => 'billing_contact_id',
        ),
    ),
    'BILLING_ACCOUNT' => array(
        'width' => '15%',
        'label' => 'LBL_BILLING_ACCOUNT',
        'default' => true,
        'module' => 'Accounts',
        'id' => 'BILLING_ACCOUNT_ID',
        'link' => true,
        'related_fields' => array(
            0 => 'billing_account_id',
        ),
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '10%',
        'label' => 'LBL_ASSIGNED_USER',
        'default' => true,
        'module' => 'Users',
        'id' => 'ASSIGNED_USER_ID',
        'link' => true,
        'related_fields' => array(
            0 => 'assigned_user_id',
        ),
    ),
    'QUOTE_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_QUOTE_DATE',
        'width' => '10%',
        'default' => false,
        'align' => 'center',
    ),
    'DATE_ENTERED' => array(
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'align' => 'center',
    ),
    'CURRENCY_ID' => array(
        'type' => 'id',
        'studio' => 'visible',
        'label' => 'LBL_CURRENCY',
        'width' => '10%',
        'default' => false,
    ),
    'BILLING_ADDRESS_STREET' => array(
        'width' => '15%',
        'label' => 'LBL_BILLING_ADDRESS_STREET',
        'default' => false,
    ),
    'BILLING_ADDRESS_CITY' => array(
        'width' => '10%',
        'label' => 'LBL_CITY',
        'default' => false,
    ),
    'BILLING_ADDRESS_STATE' => array(
        'width' => '7%',
        'label' => 'LBL_BILLING_ADDRESS_STATE',
        'default' => false,
    ),
    'BILLING_ADDRESS_POSTALCODE' => array(
        'width' => '10%',
        'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
        'default' => false,
    ),
    'BILLING_ADDRESS_COUNTRY' => array(
        'width' => '10%',
        'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
        'default' => false,
    ),
    'SHIPPING_ADDRESS_STREET' => array(
        'width' => '15%',
        'label' => 'LBL_SHIPPING_ADDRESS_STREET',
        'default' => false,
    ),
    'SHIPPING_ADDRESS_CITY' => array(
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_CITY',
        'default' => false,
    ),
    'SHIPPING_ADDRESS_STATE' => array(
        'width' => '7%',
        'label' => 'LBL_SHIPPING_ADDRESS_STATE',
        'default' => false,
    ),
    'SHIPPING_ADDRESS_POSTALCODE' => array(
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
        'default' => false,
    ),
    'SHIPPING_ADDRESS_COUNTRY' => array(
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
        'default' => false,
    ),
    'PHONE_ALTERNATE' => array(
        'width' => '10%',
        'label' => 'LBL_PHONE_ALT',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
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
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
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
    'SUBTOTAL_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_SUBTOTAL_AMOUNT',
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
    'TAX_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_TAX_AMOUNT',
        'currency_format' => true,
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
);
// END STIC-Custom