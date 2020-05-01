<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

global $sugar_config;
$listViewDefs['AOS_Quotes'] =
[
    'NUMBER' => [
        'width' => '5%',
        'label' => 'LBL_LIST_NUM',
        'default' => true,
    ],
    'NAME' => [
        'width' => '15%',
        'label' => 'LBL_ACCOUNT_NAME',
        'link' => true,
        'default' => true,
    ],
    'STAGE' => [
        'width' => '10%',
        'label' => 'LBL_STAGE',
        'default' => true,
    ],
    'BILLING_CONTACT' => [
        'width' => '11%',
        'label' => 'LBL_BILLING_CONTACT',
        'default' => true,
        'module' => 'Contacts',
        'id' => 'BILLING_CONTACT_ID',
        'link' => true,
        'related_fields' => [
            'billing_contact_id',
        ],
    ],
    'BILLING_ACCOUNT' => [
        'width' => '15%',
        'label' => 'LBL_BILLING_ACCOUNT',
        'default' => true,
        'module' => 'Accounts',
        'id' => 'BILLING_ACCOUNT_ID',
        'link' => true,
        'related_fields' => [
            'billing_account_id',
        ],
    ],
    'TOTAL_AMOUNT' => [
        'width' => '10%',
        'label' => 'LBL_GRAND_TOTAL',
        'default' => true,
        'currency_format' => true,
    ],
    'EXPIRATION' => [
        'width' => '10%',
        'label' => 'LBL_EXPIRATION',
        'default' => true,
    ],
    'ASSIGNED_USER_NAME' => [
        'width' => '10%',
        'label' => 'LBL_ASSIGNED_USER',
        'default' => true,
        'module' => 'Users',
        'id' => 'ASSIGNED_USER_ID',
        'link' => true,
    ],
    'AOS_QUOTES_TYPE' => [
        'width' => '10%',
        'label' => 'LBL_TYPE',
        'default' => false,
    ],
    'BILLING_ADDRESS_STREET' => [
        'width' => '15%',
        'label' => 'LBL_BILLING_ADDRESS_STREET',
        'default' => false,
    ],
    'BILLING_ADDRESS_CITY' => [
        'width' => '10%',
        'label' => 'LBL_CITY',
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
    'BILLING_ADDRESS_COUNTRY' => [
        'width' => '10%',
        'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
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
    'PHONE_ALTERNATE' => [
        'width' => '10%',
        'label' => 'LBL_PHONE_ALT',
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
    'TICKER_SYMBOL' => [
        'width' => '10%',
        'label' => 'LBL_TICKER_SYMBOL',
        'default' => false,
    ],
    'DATE_ENTERED' => [
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => preg_match('/^6\.?[2-9]/', $sugar_config['sugar_version']),
    ],
];
