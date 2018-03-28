<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = '<module_name>';
$OBJECT_NAME = '<OBJECT_NAME>';
$listViewDefs[$module_name] = array(
    'NAME' => array(
        'width' => '40',
        'label' => 'LBL_ACCOUNT_NAME',
        'link' => true,
        'default' => true
    ),
    'BILLING_ADDRESS_CITY' => array(
        'width' => '10',
        'label' => 'LBL_CITY',
        'default' => true
    ),
    'PHONE_OFFICE' => array(
        'width' => '10',
        'label' => 'LBL_PHONE',
        'default' => true
    ),
    $OBJECT_NAME . '_TYPE' => array(
        'width' => '10',
        'label' => 'LBL_TYPE'
    ),
    'INDUSTRY' => array(
        'width' => '10',
        'label' => 'LBL_INDUSTRY'
    ),
    'ANNUAL_REVENUE' => array(
        'width' => '10',
        'label' => 'LBL_ANNUAL_REVENUE'
    ),
    'PHONE_FAX' => array(
        'width' => '10',
        'label' => 'LBL_PHONE_FAX'
    ),
    'BILLING_ADDRESS_STREET' => array(
        'width' => '15',
        'label' => 'LBL_BILLING_ADDRESS_STREET'
    ),
    'BILLING_ADDRESS_STATE' => array(
        'width' => '7',
        'label' => 'LBL_BILLING_ADDRESS_STATE'
    ),
    'BILLING_ADDRESS_POSTALCODE' => array(
        'width' => '10',
        'label' => 'LBL_BILLING_ADDRESS_POSTALCODE'
    ),
    'BILLING_ADDRESS_COUNTRY' => array(
        'width' => '10',
        'label' => 'LBL_BILLING_ADDRESS_COUNTRY'
    ),
    'SHIPPING_ADDRESS_STREET' => array(
        'width' => '15',
        'label' => 'LBL_SHIPPING_ADDRESS_STREET'
    ),
    'SHIPPING_ADDRESS_CITY' => array(
        'width' => '10',
        'label' => 'LBL_SHIPPING_ADDRESS_CITY'
    ),
    'SHIPPING_ADDRESS_STATE' => array(
        'width' => '7',
        'label' => 'LBL_SHIPPING_ADDRESS_STATE'
    ),
    'SHIPPING_ADDRESS_POSTALCODE' => array(
        'width' => '10',
        'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE'
    ),
    'SHIPPING_ADDRESS_COUNTRY' => array(
        'width' => '10',
        'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY'
    ),
    'PHONE_ALTERNATE' => array(
        'width' => '10',
        'label' => 'LBL_PHONE_ALT'
    ),
    'WEBSITE' => array(
        'width' => '10',
        'label' => 'LBL_WEBSITE'
    ),
    'OWNERSHIP' => array(
        'width' => '10',
        'label' => 'LBL_OWNERSHIP'
    ),
    'EMPLOYEES' => array(
        'width' => '10',
        'label' => 'LBL_EMPLOYEES'
    ),
    'TICKER_SYMBOL' => array(
        'width' => '10',
        'label' => 'LBL_TICKER_SYMBOL'
    ),
    'EMAIL1' => array(
        'width' => '15%',
        'label' => 'LBL_EMAIL_ADDRESS',
        'sortable' => false,
        'link' => true,
        'customCode' => '{$EMAIL1_LINK}',
        'default' => true
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '2',
        'label' => 'LBL_ASSIGNED_USER',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true
    ),
);
