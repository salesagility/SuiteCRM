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
$viewdefs[$module_name] =
array(
    'EditView' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'LBL_DEFAULT_PANEL' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
                'LBL_RETURN_PANEL' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => false,
        ),
        'panels' => array(
            'lbl_default_panel' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'amount',
                        'label' => 'LBL_AMOUNT',
                    ),
                    1 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'payment_date',
                        'label' => 'LBL_PAYMENT_DATE',
                    ),
                    1 => '',
                ),
                3 => array(
                    0 => array(
                        'name' => 'stic_payments_stic_payment_commitments_name',
                        'label' => 'LBL_STIC_PAYMENTS_STIC_PAYMENT_COMMITMENTS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
                    ),
                    1 => array(
                        'name' => 'stic_payments_stic_remittances_name',
                        'label' => 'LBL_STIC_PAYMENTS_STIC_REMITTANCES_FROM_STIC_REMITTANCES_TITLE',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'payment_method',
                        'studio' => 'visible',
                        'label' => 'LBL_PAYMENT_METHOD',
                    ),
                    1 => array(
                        'name' => 'payment_type',
                        'studio' => 'visible',
                        'label' => 'LBL_PAYMENT_TYPE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'bank_account',
                        'label' => 'LBL_BANK_ACCOUNT',
                    ),
                    1 => array(
                        'name' => 'banking_concept',
                        'label' => 'LBL_BANKING_CONCEPT',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'segmentation',
                        'studio' => 'visible',
                        'label' => 'LBL_SEGMENTATION',
                    ),
                    1 => '',
                ),
                7 => array(
                    0 => array(
                        'name' => 'stic_payments_stic_registrations_name',
                        'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
                    ),
                    1 => array(
                        'name' => 'm182_excluded',
                        'label' => 'LBL_M182_EXCLUDED',
                    ),
                ),
                8 => array(
                    0 => array(
                        'name' => 'in_kind_description',
                        'label' => 'LBL_IN_KIND_DESCRIPTION',
                    ),
                    1 => array(
                        'name' => 'transaction_type',
                        'studio' => 'visible',
                        'label' => 'LBL_TRANSACTION_TYPE',
                    ),
                ),
                9 => array(
                    0 => 'description',
                ),
            ),
            'lbl_return_panel' => array(
                0 => array(
                    0 => array(
                        'name' => 'rejection_date',
                        'label' => 'LBL_REJECTION_DATE',
                    ),
                    1 => array(
                        'name' => 'sepa_rejected_reason',
                        'studio' => 'visible',
                        'label' => 'LBL_SEPA_REJECTED_REASON',
                    ),
                ),
            ),
        ),
    ),
);
