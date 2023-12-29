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
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'STIC_REGISTRATIONS_STIC_EVENTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
        'id' => 'STIC_REGISTRATIONS_STIC_EVENTSSTIC_EVENTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'REGISTRATION_DATE' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_REGISTRATION_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => true,
        'label' => 'LBL_STATUS',
        'width' => '10%',
    ),
    'STIC_REGISTRATIONS_CONTACTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
        'id' => 'STIC_REGISTRATIONS_CONTACTSCONTACTS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'ATTENDED_HOURS' => array(
        'type' => 'decimal',
        'label' => 'LBL_ATTENDED_HOURS',
        'align' => 'right',
        'width' => '10%',
        'default' => true,
    ),
    'ATTENDANCE_PERCENTAGE' => array(
        'type' => 'decimal',
        'label' => 'LBL_ATTENDANCE_PERCENTAGE',
        'align' => 'right',
        'width' => '10%',
        'default' => true,
    ),
    'DISABLED_WEEKDAYS' => array(
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_DISABLED_WEEKDAYS',
        'width' => '10%',
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'STIC_REGISTRATIONS_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_REGISTRATIONS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_REGISTRATIONS_ACCOUNTSACCOUNTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_REGISTRATIONS_LEADS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_REGISTRATIONS_LEADS_FROM_LEADS_TITLE',
        'id' => 'STIC_REGISTRATIONS_LEADSLEADS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'NOT_PARTICIPATING_REASON' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_NOT_PARTICIPATING_REASON',
        'width' => '10%',
    ),
    'SPECIAL_NEEDS_DESCRIPTION' => array(
        'type' => 'varchar',
        'label' => 'LBL_SPECIAL_NEEDS_DESCRIPTION',
        'width' => '10%',
        'default' => false,
    ),
    'SPECIAL_NEEDS' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_SPECIAL_NEEDS',
        'width' => '10%',
    ),
    'PARTICIPATION_TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_PARTICIPATION_TYPE',
        'width' => '10%',
    ),
    'REJECTION_REASON' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'default' => false,
        'label' => 'LBL_REJECTION_REASON',
        'width' => '10%',
    ),
    'ATTENDEES' => array(
        'type' => 'int',
        'default' => false,
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
    ),
    'STIC_PAYMENTS_STIC_REGISTRATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENTS_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_REGISTRATIONSSTIC_PAYMENTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'SESSION_AMOUNT' => array(
        'type' => 'decimal',
        'label' => 'LBL_SESSION_AMOUNT',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENT_COMMITMENTS_STIC_REGISTRATIONS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
        'id' => 'STIC_PAYME96D2ITMENTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
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
    ),
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
);
