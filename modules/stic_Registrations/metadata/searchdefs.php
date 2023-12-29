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
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_registrations_stic_events_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
                'id' => 'STIC_REGISTRATIONS_STIC_EVENTSSTIC_EVENTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_registrations_stic_events_name',
            ),
            'registration_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_REGISTRATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'registration_date',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'name' => 'status',
            ),
            'stic_registrations_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
                'id' => 'STIC_REGISTRATIONS_CONTACTSCONTACTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_registrations_contacts_name',
            ),
            'attended_hours' => array(
                'type' => 'decimal',
                'label' => 'LBL_ATTENDED_HOURS',
                'width' => '10%',
                'default' => true,
                'name' => 'attended_hours',
            ),
            'attendance_percentage' => array(
                'type' => 'decimal',
                'label' => 'LBL_ATTENDANCE_PERCENTAGE',
                'width' => '10%',
                'default' => true,
                'name' => 'attendance_percentage',
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
            'stic_registrations_stic_events_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
                'id' => 'STIC_REGISTRATIONS_STIC_EVENTSSTIC_EVENTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_registrations_stic_events_name',
            ),
            'registration_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_REGISTRATION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'registration_date',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'name' => 'status',
            ),
            'stic_registrations_contacts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
                'id' => 'STIC_REGISTRATIONS_CONTACTSCONTACTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_registrations_contacts_name',
            ),
            'attended_hours' => array(
                'type' => 'decimal',
                'label' => 'LBL_ATTENDED_HOURS',
                'width' => '10%',
                'default' => true,
                'name' => 'attended_hours',
            ),
            'attendance_percentage' => array(
                'type' => 'decimal',
                'label' => 'LBL_ATTENDANCE_PERCENTAGE',
                'width' => '10%',
                'default' => true,
                'name' => 'attendance_percentage',
            ),
            'disabled_weekdays' => array(
                'type' => 'enum',
                'label' => 'LBL_DISABLED_WEEKDAYS',
                'width' => '10%',
                'default' => true,
                'name' => 'disabled_weekdays',
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
            'stic_registrations_accounts_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'id' => 'STIC_REGISTRATIONS_ACCOUNTSACCOUNTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_registrations_accounts_name',
            ),
            'stic_registrations_leads_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_LEADS_TITLE',
                'id' => 'STIC_REGISTRATIONS_LEADSLEADS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_registrations_leads_name',
            ),
            'participation_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_PARTICIPATION_TYPE',
                'width' => '10%',
                'name' => 'participation_type',
            ),
            'special_needs' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_SPECIAL_NEEDS',
                'width' => '10%',
                'name' => 'special_needs',
            ),
            'special_needs_description' => array(
                'type' => 'varchar',
                'label' => 'LBL_SPECIAL_NEEDS_DESCRIPTION',
                'width' => '10%',
                'default' => true,
                'name' => 'special_needs_description',
            ),
            'rejection_reason' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_REJECTION_REASON',
                'width' => '10%',
                'name' => 'rejection_reason',
            ),
            'not_participating_reason' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'default' => true,
                'label' => 'LBL_NOT_PARTICIPATING_REASON',
                'width' => '10%',
                'name' => 'not_participating_reason',
            ),
            'attendees' => array(
                'default' => true,
                'type' => 'decimal',
                'studio' => 'visible',
                'label' => 'LBL_ATTENDEES',
                'name' => 'attendees',
                'width' => '10%',
            ),
            'stic_payments_stic_registrations_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
                'id' => 'STIC_PAYMENTS_STIC_REGISTRATIONSSTIC_PAYMENTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_stic_registrations_name',
            ),
            'session_amount' => array(
                'type' => 'decimal',
                'label' => 'LBL_SESSION_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'session_amount',
            ),
            'stic_payment_commitments_stic_registrations_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
                'id' => 'STIC_PAYME96D2ITMENTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payment_commitments_stic_registrations_name',
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
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
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
