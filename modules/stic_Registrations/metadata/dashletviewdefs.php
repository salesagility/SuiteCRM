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
$dashletData['stic_RegistrationsDashlet']['searchFields'] = array(
    'registration_date' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'special_needs' => array(
        'default' => '',
    ),
    'rejection_reason' => array(
        'default' => '',
    ),
    'stic_registrations_stic_contacts_name' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'type' => 'assigned_user_name',
        'default' => $current_user->name,
    ),
);
$dashletData['stic_RegistrationsDashlet']['columns'] = array(
    'name' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
        'name' => 'name',
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
    'attendance_percentage' => array(
        'type' => 'decimal',
        'label' => 'LBL_ATTENDANCE_PERCENTAGE',
        'width' => '10%',
        'default' => true,
        'name' => 'attendance_percentage',
    ),
    'attended_hours' => array(
        'type' => 'decimal',
        'label' => 'LBL_ATTENDED_HOURS',
        'width' => '10%',
        'default' => false,
        'name' => 'attended_hours',
    ),
    'assigned_user_name' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => false,
        'name' => 'assigned_user_name',
    ),
    'participation_type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_PARTICIPATION_TYPE',
        'width' => '10%',
        'name' => 'participation_type',
    ),
    'attendees' => array(
        'type' => 'int',
        'default' => false,
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
        'name' => 'attendees',
    ),
    'disabled_weekdays' => array(
        'type' => 'multienum',
        'default' => false,
        'label' => 'LBL_DISABLED_WEEKDAYS',
        'width' => '10%',
        'name' => 'disabled_weekdays',
    ),
    'stic_registrations_accounts_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_REGISTRATIONS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_registrations_accounts_name',
    ),
    'stic_registrations_leads_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_LEADS_TITLE',
        'id' => 'STIC_REGISTRATIONS_LEADSLEADS_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_registrations_leads_name',
    ),
    'not_participating_reason' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_NOT_PARTICIPATING_REASON',
        'width' => '10%',
        'name' => 'not_participating_reason',
    ),
    'special_needs_description' => array(
        'type' => 'varchar',
        'label' => 'LBL_SPECIAL_NEEDS_DESCRIPTION',
        'width' => '10%',
        'default' => false,
        'name' => 'special_needs_description',
    ),
    'special_needs' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_SPECIAL_NEEDS',
        'width' => '10%',
        'name' => 'special_needs',
    ),
    'rejection_reason' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_REJECTION_REASON',
        'width' => '10%',
        'name' => 'rejection_reason',
    ),
    'stic_payments_stic_registrations_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_REGISTRATIONSSTIC_PAYMENTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'stic_payment_commitments_stic_registrations_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
        'id' => 'STIC_PAYME96D2ITMENTS_IDA',
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
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'modified_by_name',
    ),
    'date_modified' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
        'name' => 'date_modified',
    ),
    'date_entered' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
        'name' => 'date_entered',
    ),
);
