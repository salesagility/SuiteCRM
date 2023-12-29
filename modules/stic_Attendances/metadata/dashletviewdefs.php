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
$dashletData['stic_AttendancesDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'start_date' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'duration' => array(
        'default' => '',
    ),
    'stic_attendances_stic_sessions_name' => array(
        'default' => '',
    ),
    'assigned_user_name' => array(
        'default' => '',
    ),
);
$dashletData['stic_AttendancesDashlet']['columns'] = array(
    'name' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
        'name' => 'name',
    ),
    'start_date' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'start_date',
    ),
    'duration' => array(
        'type' => 'decimal',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => true,
        'name' => 'duration',
    ),
    'status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
    ),
    'stic_attendances_stic_sessions_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_ATTENDANCES_STIC_SESSIONS_FROM_STIC_SESSIONS_TITLE',
        'id' => 'STIC_ATTENDANCES_STIC_SESSIONSSTIC_SESSIONS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'stic_attendances_stic_sessions_name',
    ),
    'stic_attendances_stic_registrations_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_ATTENDANCES_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_ATTENDANCES_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'stic_attendances_stic_registrations_name',
    ),
    'assigned_user_name' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => false,
        'name' => 'assigned_user_name',
    ),
    'stic_payments_stic_attendances_name' => array(
        'type' => 'relate',
        'link' => true,
        'studio' => array(
            'editview' => false,
            'quickcreate' => false,
        ),
        'label' => 'LBL_STIC_PAYMENTS_STIC_ATTENDANCES_FROM_STIC_PAYMENTS_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_ATTENDANCESSTIC_PAYMENTS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'description',
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
