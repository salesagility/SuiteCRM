<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$listViewDefs['Accounts'] =
[
    'NAME' => [
        'width' => '20%',
        'label' => 'LBL_LIST_ACCOUNT_NAME',
        'link' => true,
        'default' => true,
    ],
    'BILLING_ADDRESS_CITY' => [
        'width' => '10%',
        'label' => 'LBL_LIST_CITY',
        'default' => true,
    ],
    'BILLING_ADDRESS_COUNTRY' => [
        'width' => '10%',
        'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
        'default' => true,
    ],
    'PHONE_OFFICE' => [
        'width' => '10%',
        'label' => 'LBL_LIST_PHONE',
        'default' => true,
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '10%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ],
    'EMAIL1' => [
        'width' => '15%',
        'label' => 'LBL_EMAIL_ADDRESS',
        'sortable' => false,
        'link' => true,
        'customCode' => '{$EMAIL1_LINK}',
        'default' => true,
    ],
    'DATE_ENTERED' => [
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
    ],
    'ACCOUNT_TYPE' => [
        'width' => '10%',
        'label' => 'LBL_TYPE',
        'default' => false,
    ],
    'INDUSTRY' => [
        'width' => '10%',
        'label' => 'LBL_INDUSTRY',
        'default' => false,
    ],
    'ANNUAL_REVENUE' => [
        'width' => '10%',
        'label' => 'LBL_ANNUAL_REVENUE',
        'default' => false,
    ],
    'PHONE_FAX' => [
        'width' => '10%',
        'label' => 'LBL_PHONE_FAX',
        'default' => false,
    ],
    'BILLING_ADDRESS_STREET' => [
        'width' => '15%',
        'label' => 'LBL_BILLING_ADDRESS_STREET',
        'default' => false,
    ],
    'BILLING_ADDRESS_STATE' => [
        'width' => '7%',
        'label' => 'LBL_BILLING_ADDRESS_STATE',
        'default' => false,
    ],
    'BILLING_ADDRESS_POSTALCODE' => [
        'width' => '10%',
        'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
        'default' => false,
    ],
    'SHIPPING_ADDRESS_STREET' => [
        'width' => '15%',
        'label' => 'LBL_SHIPPING_ADDRESS_STREET',
        'default' => false,
    ],
    'SHIPPING_ADDRESS_CITY' => [
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_CITY',
        'default' => false,
    ],
    'SHIPPING_ADDRESS_STATE' => [
        'width' => '7%',
        'label' => 'LBL_SHIPPING_ADDRESS_STATE',
        'default' => false,
    ],
    'SHIPPING_ADDRESS_POSTALCODE' => [
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
        'default' => false,
    ],
    'SHIPPING_ADDRESS_COUNTRY' => [
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
        'default' => false,
    ],
    'RATING' => [
        'width' => '10%',
        'label' => 'LBL_RATING',
        'default' => false,
    ],
    'PHONE_ALTERNATE' => [
        'width' => '10%',
        'label' => 'LBL_OTHER_PHONE',
        'default' => false,
    ],
    'WEBSITE' => [
        'width' => '10%',
        'label' => 'LBL_WEBSITE',
        'default' => false,
    ],
    'OWNERSHIP' => [
        'width' => '10%',
        'label' => 'LBL_OWNERSHIP',
        'default' => false,
    ],
    'EMPLOYEES' => [
        'width' => '10%',
        'label' => 'LBL_EMPLOYEES',
        'default' => false,
    ],
    'SIC_CODE' => [
        'width' => '10%',
        'label' => 'LBL_SIC_CODE',
        'default' => false,
    ],
    'TICKER_SYMBOL' => [
        'width' => '10%',
        'label' => 'LBL_TICKER_SYMBOL',
        'default' => false,
    ],
    'DATE_MODIFIED' => [
        'width' => '5%',
        'label' => 'LBL_DATE_MODIFIED',
        'default' => false,
    ],
    'CREATED_BY_NAME' => [
        'width' => '10%',
        'label' => 'LBL_CREATED',
        'default' => false,
    ],
    'MODIFIED_BY_NAME' => [
        'width' => '10%',
        'label' => 'LBL_MODIFIED',
        'default' => false,
    ],
];
