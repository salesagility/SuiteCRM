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
$module_name = 'stic_Registrations';
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
            ),
            'syncDetailEditViews' => false,
        ),
        'panels' => array(
            'LBL_DEFAULT_PANEL' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'stic_registrations_stic_events_name',
                        'label' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
                    ),
                    1 => array(
                        'name' => 'registration_date',
                        'label' => 'LBL_REGISTRATION_DATE',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'stic_registrations_contacts_name',
                        'label' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
                    ),
                    1 => array(
                        'name' => 'stic_registrations_accounts_name',
                        'label' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'stic_registrations_leads_name',
                        'label' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_LEADS_TITLE',
                    ),
                    1 => array(
                        'name' => 'stic_payments_stic_registrations_name',
                        'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'participation_type',
                        'studio' => 'visible',
                        'label' => 'LBL_PARTICIPATION_TYPE',
                    ),
                    1 => array(
                        'name' => 'attendees',
                        'label' => 'LBL_ATTENDEES',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                    1 => array(
                        'name' => 'disabled_weekdays',
                        'studio' => 'visible',
                        'label' => 'LBL_DISABLED_WEEKDAYS',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'not_participating_reason',
                        'studio' => 'visible',
                        'label' => 'LBL_NOT_PARTICIPATING_REASON',
                    ),
                    1 => array(
                        'name' => 'rejection_reason',
                        'studio' => 'visible',
                        'label' => 'LBL_REJECTION_REASON',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'special_needs',
                        'studio' => 'visible',
                        'label' => 'LBL_SPECIAL_NEEDS',
                    ),
                    1 => array(
                        'name' => 'special_needs_description',
                        'label' => 'LBL_SPECIAL_NEEDS_DESCRIPTION',
                    ),
                ),
                8 => array(
                    0 => array(
                        'name' => 'session_amount',
                        'label' => 'LBL_SESSION_AMOUNT',
                    ),
                    1 => array(
                        'name' => 'stic_payment_commitments_stic_registrations_name',
                        'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
                    ),
                ),
                10 => array(
                    0 => array(
                        'name' => 'stic_training_stic_registrations_name',
                        'label' => 'LBL_STIC_TRAINING_STIC_REGISTRATIONS_FROM_STIC_TRAINING_TITLE',
                    ),
                    1 => '',
                ),
                11 => array(
                    0 => 'description',
                ),
            ),
        ),
    ),
);
