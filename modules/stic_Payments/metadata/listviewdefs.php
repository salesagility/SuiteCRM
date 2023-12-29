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
$module_name = 'stic_Payments';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
        'width' => '10%',
    ),
    'AMOUNT' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_AMOUNT',
        'default' => true,
        'width' => '10%',
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'default' => true,
        'width' => '10%',
    ),
    'PAYMENT_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_PAYMENT_DATE',
        'default' => true,
        'width' => '10%',
    ),
    'PAYMENT_TYPE' => array(
        'type' => 'Enum',
        'studio' => 'Visible',
        'label' => 'LBL_PAYMENT_TYPE',
        'default' => true,
        'width' => '10%',
    ),
    'PAYMENT_METHOD' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_PAYMENT_METHOD',
        'default' => true,
        'width' => '10%',
    ),
    'ASSIGNED_USER_NAME' => array(
        'link' => true,
        'type' => 'relate',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'id' => 'ASSIGNED_USER_ID',
        'width' => '10%',
        'default' => true,
    ),
    'BANK_ACCOUNT' => array(
        'type' => 'varchar',
        'label' => 'LBL_BANK_ACCOUNT',
        'default' => false,
        'width' => '10%',
    ),
    'STIC_PAYMENTS_STIC_REGISTRATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
        'default' => false,
        'width' => '10%',
    ),
    'STIC_PAYMENTS_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_PAYMENTS_ACCOUNTSACCOUNTS_IDA',
        'default' => false,
        'width' => '10%',
    ),
    'STIC_PAYMENTS_STIC_REMITTANCES_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_REMITTANCES_FROM_STIC_REMITTANCES_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_REMITTANCESSTIC_REMITTANCES_IDA',
        'default' => false,
        'width' => '10%',
    ),
    'STIC_PAYMENTS_CONTACTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_PAYMENTS_CONTACTSCONTACTS_IDA',
        'default' => false,
        'width' => '10%',
    ),
    'STIC_PAYMENTS_STIC_PAYMENT_COMMITMENTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_PAYMENT_COMMITMENTS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
        'id' => 'STIC_PAYMEBFE2ITMENTS_IDA',
        'default' => false,
        'width' => '10%',
    ),
    'C19_REJECTED_REASON' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_C19_REJECTED_REASON',
        'width' => '10%',
    ),
    'REJECTION_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_REJECTION_DATE',
        'default' => false,
        'width' => '10%',
    ),
    'SEPA_REJECTED_REASON' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SEPA_REJECTED_REASON',
        'default' => false,
        'width' => '10%',
    ),
    'M182_EXCLUDED' => array(
        'type' => 'bool',
        'label' => 'LBL_M182_EXCLUDED',
        'default' => false,
        'width' => '10%',
    ),
    'BANKING_CONCEPT' => array(
        'type' => 'varchar',
        'label' => 'LBL_BANKING_CONCEPT',
        'default' => false,
        'width' => '10%',
    ),
    'IN_KIND_DESCRIPTION' => array(
        'type' => 'varchar',
        'label' => 'LBL_IN_KIND_DESCRIPTION',
        'default' => false,
        'width' => '10%',
    ),
    'GATEWAY_REJECTION_REASON' => array(
        'type' => 'varchar',
        'label' => 'LBL_GATEWAY_REJECTION_REASON',
        'default' => false,
        'width' => '10%',
    ),
    'SEGMENTATION' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SEGMENTATION',
        'default' => false,
        'width' => '10%',
    ),
    'MANDATE' => array(
        'type' => 'varchar',
        'label' => 'LBL_MANDATE',
        'default' => false,
        'width' => '10%',
    ),
    'TRANSACTION_TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TRANSACTION_TYPE',
        'default' => false,
        'width' => '10%',
    ),
    'TRANSACTION_CODE' => array(
        'type' => 'int',
        'studio' => array(
            'quickcreate' => 0,
        ),
        'label' => 'LBL_TRANSACTION_CODE',
        'width' => '10%',
        'default' => false,
    ),
    'AGGREGATED_SERVICES_COMPLETE' => array(
        'type' => 'bool',
        'label' => 'LBL_AGGREGATED_SERVICES_COMPLETE',
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'default' => false,
        'width' => '10%',
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'default' => false,
        'width' => '10%',
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'default' => false,
        'width' => '10%',
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'default' => false,
        'width' => '10%',
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'width' => '10%',
    ),
);
