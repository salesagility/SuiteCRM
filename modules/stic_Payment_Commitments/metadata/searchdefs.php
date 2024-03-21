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
$module_name = 'stic_Payment_Commitments';
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
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
            'amount' => array(
                'type' => 'decimal',
                'align' => 'right',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'first_payment_date' => array(
                'type' => 'date',
                'label' => 'LBL_FIRST_PAYMENT_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'first_payment_date',
            ),
            'end_date' => array(
                'type' => 'date',
                'label' => 'LBL_END_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'end_date',
            ),
            'active' => array(
                'type' => 'bool',
                'label' => 'LBL_ACTIVE',
                'width' => '10%',
                'default' => true,
                'name' => 'active',
            ),
            'periodicity' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_PERIODICITY',
                'width' => '10%',
                'default' => true,
                'name' => 'periodicity',
            ),
            'stic_payment_commitments_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_PAYMENT_COMMITMENTS_CONTACTSCONTACTS_IDA',
                'name' => 'stic_payment_commitments_contacts_name',
            ),
            'stic_payment_commitments_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_PAYMENT_COMMITMENTS_ACCOUNTSACCOUNTS_IDA',
                'name' => 'stic_payment_commitments_accounts_name',
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
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
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
            'amount' => array(
                'type' => 'decimal',
                'align' => 'right',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'first_payment_date' => array(
                'type' => 'date',
                'label' => 'LBL_FIRST_PAYMENT_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'first_payment_date',
            ),
            'end_date' => array(
                'type' => 'date',
                'label' => 'LBL_END_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'end_date',
            ),
            'periodicity' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_PERIODICITY',
                'width' => '10%',
                'default' => true,
                'name' => 'periodicity',
            ),
            'stic_payment_commitments_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_CONTACTS_FROM_CONTACTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_PAYMENT_COMMITMENTS_CONTACTSCONTACTS_IDA',
                'name' => 'stic_payment_commitments_contacts_name',
            ),
            'stic_payment_commitments_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_PAYMENT_COMMITMENTS_ACCOUNTSACCOUNTS_IDA',
                'name' => 'stic_payment_commitments_accounts_name',
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
            'stic_payment_commitments_campaigns_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_CAMPAIGNS_FROM_CAMPAIGNS_TITLE',
                'id' => 'STIC_PAYMENT_COMMITMENTS_CAMPAIGNSCAMPAIGNS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payment_commitments_campaigns_name',
            ),
            'stic_payment_commitments_project_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_PROJECT_FROM_PROJECT_TITLE',
                'id' => 'STIC_PAYMENT_COMMITMENTS_PROJECTPROJECT_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payment_commitments_project_name',
            ),
            'destination' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_DESTINATION',
                'width' => '10%',
                'default' => true,
                'name' => 'destination',
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
            'in_kind_donation' => array(
                'type' => 'varchar',
                'label' => 'LBL_IN_KIND_DONATION',
                'width' => '10%',
                'default' => true,
                'name' => 'in_kind_donation',
            ),
            'segmentation' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_SEGMENTATION',
                'width' => '10%',
                'name' => 'segmentation',
            ),
            'annualized_fee' => array(
                'type' => 'decimal',
                'label' => 'LBL_ANNUALIZED_FEE',
                'width' => '10%',
                'default' => true,
                'name' => 'annualized_fee',
            ),
            'pending_annualized_fee' => array(
                'type' => 'decimal',
                'label' => 'LBL_PENDING_ANNUALIZED_FEE',
                'width' => '10%',
                'default' => true,
                'name' => 'pending_annualized_fee',
            ),
            'paid_annualized_fee' => array(
                'type' => 'decimal',
                'label' => 'LBL_PAID_ANNUALIZED_FEE',
                'width' => '10%',
                'default' => true,
                'name' => 'paid_annualized_fee',
            ),
            'channel' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_CHANNEL',
                'width' => '10%',
                'default' => true,
                'name' => 'channel',
            ),
            'signature_date' => array(
                'type' => 'date',
                'label' => 'LBL_SIGNATURE_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'signature_date',
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
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
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
