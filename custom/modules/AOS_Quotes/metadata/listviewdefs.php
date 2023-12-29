<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
$listViewDefs['AOS_Quotes'] =
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
    'STAGE' => array(
        'width' => '10%',
        'label' => 'LBL_STAGE',
        'default' => true,
    ),
    'APPROVAL_STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_APPROVAL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'INVOICE_STATUS' => array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_INVOICE_STATUS',
        'width' => '10%',
    ),
    'TOTAL_AMOUNT' => array(
        'width' => '10%',
        'label' => 'LBL_GRAND_TOTAL',
        'default' => true,
        'currency_format' => true,
    ),
    'EXPIRATION' => array(
        'width' => '10%',
        'label' => 'LBL_EXPIRATION',
        'default' => true,
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
    ),
    'TERMS_C' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_TERMS_C',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'APPROVAL_ISSUE' => array(
        'type' => 'text',
        'studio' => 'visible',
        'label' => 'LBL_APPROVAL_ISSUE',
        'sortable' => false,
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
    'DISCOUNT_AMOUNT' => array(
        'type' => 'currency',
        'label' => 'LBL_DISCOUNT_AMOUNT',
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
    'SHIPPING_TAX' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SHIPPING_TAX',
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
    'BILLING_ADDRESS_STREET' => array(
        'width' => '15%',
        'label' => 'LBL_BILLING_ADDRESS_STREET',
        'default' => false,
    ),
    'BILLING_ADDRESS_POSTALCODE' => array(
        'width' => '10%',
        'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
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
    'SHIPPING_ADDRESS_POSTALCODE' => array(
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
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
    'SHIPPING_ADDRESS_COUNTRY' => array(
        'width' => '10%',
        'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
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
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'width' => '5%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'align' => 'center',
    ),
);
