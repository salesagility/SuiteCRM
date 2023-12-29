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
$dashletData['stic_PaymentsDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'amount' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'payment_date' => array(
        'default' => '',
    ),
    'payment_type' => array(
        'default' => '',
    ),
    'payment_method' => array(
        'default' => '',
    ),
    'assigned_user_name' => array(
        'default' => '',
    ),
);
$dashletData['stic_PaymentsDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'amount' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'default' => true,
        'name' => 'amount',
    ),
    'status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
    ),
    'payment_type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_PAYMENT_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'payment_type',
    ),
    'payment_method' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_PAYMENT_METHOD',
        'width' => '10%',
        'default' => true,
        'name' => 'payment_method',
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ),
    'transaction_type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TRANSACTION_TYPE',
        'width' => '10%',
        'default' => false,
        'name' => 'transaction_type',
    ),
    'stic_payments_stic_registrations_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_payments_stic_registrations_name',
    ),
    'stic_payments_accounts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_PAYMENTS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_payments_accounts_name',
    ),
    'stic_payments_stic_remittances_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_REMITTANCES_FROM_STIC_REMITTANCES_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_REMITTANCESSTIC_REMITTANCES_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_payments_stic_remittances_name',
    ),
    'stic_payments_contacts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_PAYMENTS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_payments_contacts_name',
    ),
    'stic_payments_stic_payment_commitments_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_PAYMENT_COMMITMENTS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
        'id' => 'STIC_PAYMEBFE2ITMENTS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_payments_stic_payment_commitments_name',
    ),
    'payment_date' => array(
        'type' => 'date',
        'label' => 'LBL_PAYMENT_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'payment_date',
    ),
    'c19_rejected_reason' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_C19_REJECTED_REASON',
        'width' => '10%',
        'name' => 'c19_rejected_reason',
    ),
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'modified_by_name',
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'description',
    ),
    'bank_account' => array(
        'type' => 'varchar',
        'label' => 'LBL_BANK_ACCOUNT',
        'width' => '10%',
        'default' => false,
        'name' => 'bank_account',
    ),
    'currency_id' => array(
        'type' => 'currency_id',
        'studio' => 'visible',
        'label' => 'LBL_CURRENCY',
        'width' => '10%',
        'default' => false,
        'name' => 'currency_id',
    ),
    'rejection_date' => array(
        'type' => 'date',
        'label' => 'LBL_REJECTION_DATE',
        'width' => '10%',
        'default' => false,
        'name' => 'rejection_date',
    ),
    'sepa_rejected_reason' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SEPA_REJECTED_REASON',
        'width' => '10%',
        'default' => false,
        'name' => 'sepa_rejected_reason',
    ),
    'm182_excluded' => array(
        'type' => 'bool',
        'label' => 'LBL_M182_EXCLUDED',
        'width' => '10%',
        'default' => false,
        'name' => 'm182_excluded',
    ),
    'banking_concept' => array(
        'type' => 'varchar',
        'label' => 'LBL_BANKING_CONCEPT',
        'width' => '10%',
        'default' => false,
        'name' => 'banking_concept',
    ),
    'in_kind_description' => array(
        'type' => 'varchar',
        'label' => 'LBL_IN_KIND_DESCRIPTION',
        'width' => '10%',
        'default' => false,
        'name' => 'in_kind_description',
    ),
    'gateway_rejection_reason' => array(
        'type' => 'varchar',
        'label' => 'LBL_GATEWAY_REJECTION_REASON',
        'default' => false,
        'width' => '10%',
        'name' => 'gateway_rejection_reason',
    ),
    'segmentation' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_SEGMENTATION',
        'width' => '10%',
        'default' => false,
        'name' => 'segmentation',
    ),
    'mandate' => array(
        'type' => 'varchar',
        'label' => 'LBL_MANDATE',
        'width' => '10%',
        'default' => false,
        'name' => 'mandate',
    ),
    'transaction_code' => array(
        'type' => 'int',
        'studio' => array(
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_TRANSACTION_CODE',
        'width' => '10%',
        'default' => false,
    ),
    'aggregated_services_complete' => array(
        'type' => 'bool',
        'label' => 'LBL_AGGREGATED_SERVICES_COMPLETE',
        'width' => '10%',
        'default' => false,
    ),
    'created_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
        'name' => 'created_by_name',
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
);
