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
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'amount' => array(
                'type' => 'currency',
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
            'payment_date' => array(
                'type' => 'date',
                'label' => 'LBL_PAYMENT_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'payment_date',
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
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'amount' => array(
                'type' => 'currency',
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
            'payment_date' => array(
                'type' => 'date',
                'label' => 'LBL_PAYMENT_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'payment_date',
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
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'bank_account' => array(
                'type' => 'varchar',
                'label' => 'LBL_BANK_ACCOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'bank_account',
            ),
            'transaction_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TRANSACTION_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'transaction_type',
            ),
            'mandate' => array(
                'type' => 'varchar',
                'label' => 'LBL_MANDATE',
                'width' => '10%',
                'default' => true,
                'name' => 'mandate',
            ),
            'banking_concept' => array(
                'type' => 'varchar',
                'label' => 'LBL_BANKING_CONCEPT',
                'width' => '10%',
                'default' => true,
                'name' => 'banking_concept',
            ),
            'in_kind_description' => array(
                'type' => 'varchar',
                'label' => 'LBL_IN_KIND_DESCRIPTION',
                'width' => '10%',
                'default' => true,
                'name' => 'in_kind_description',
            ),
            'gateway_rejection_reason' => array(
                'type' => 'varchar',
                'label' => 'LBL_GATEWAY_REJECTION_REASON',
                'width' => '10%',
                'default' => true,
                'name' => 'gateway_rejection_reason',
            ),
            'm182_excluded' => array(
                'type' => 'bool',
                'label' => 'LBL_M182_EXCLUDED',
                'width' => '10%',
                'default' => true,
                'name' => 'm182_excluded',
            ),
            'segmentation' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SEGMENTATION',
                'width' => '10%',
                'default' => true,
                'name' => 'segmentation',
            ),
            'sepa_rejected_reason' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_SEPA_REJECTED_REASON',
                'width' => '10%',
                'default' => true,
                'name' => 'sepa_rejected_reason',
            ),
            'rejection_date' => array(
                'type' => 'date',
                'label' => 'LBL_REJECTION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'rejection_date',
            ),
            'c19_rejected_reason' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_C19_REJECTED_REASON',
                'width' => '10%',
                'name' => 'c19_rejected_reason',
            ),
            'stic_payments_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_CONTACTS_FROM_CONTACTS_TITLE',
                'id' => 'STIC_PAYMENTS_CONTACTSCONTACTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_contacts_name',
            ),
            'stic_payments_stic_remittances_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_STIC_REMITTANCES_FROM_STIC_REMITTANCES_TITLE',
                'id' => 'STIC_PAYMENTS_STIC_REMITTANCESSTIC_REMITTANCES_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_stic_remittances_name',
            ),
            'stic_payments_stic_registrations_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
                'id' => 'STIC_PAYMENTS_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDB',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_stic_registrations_name',
            ),
            'stic_payments_stic_payment_commitments_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_STIC_PAYMENT_COMMITMENTS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
                'id' => 'STIC_PAYMEBFE2ITMENTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_stic_payment_commitments_name',
            ),
            'stic_payments_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'id' => 'STIC_PAYMENTS_ACCOUNTSACCOUNTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_accounts_name',
            ),
            'transaction_code' => array(
                'type' => 'int',
                'studio' => array(
                    'quickcreate' => 0,
                ),
                'label' => 'LBL_TRANSACTION_CODE',
                'width' => '10%',
                'default' => true,
                'name' => 'transaction_code',
            ),
            'aggregated_services_complete' => array(
                'type' => 'bool',
                'label' => 'LBL_AGGREGATED_SERVICES_COMPLETE',
                'width' => '10%',
                'default' => true,
                'name' => 'aggregated_services_complete',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
