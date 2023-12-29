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
$module_name = 'stic_Attendances';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'START_DATE' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'DURATION' => array(
        'type' => 'decimal',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => true,
        'align' => 'right',
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'STIC_ATTENDANCES_STIC_SESSIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_ATTENDANCES_STIC_SESSIONS_FROM_STIC_SESSIONS_TITLE',
        'id' => 'STIC_ATTENDANCES_STIC_SESSIONSSTIC_SESSIONS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'STIC_ATTENDANCES_STIC_REGISTRATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_ATTENDANCES_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
        'id' => 'STIC_ATTENDANCES_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'AMOUNT' => array(
        'type' => 'decimal',
        'label' => 'LBL_AMOUNT',
        'width' => '10%',
        'default' => false,
    ),
    'PAYMENT_EXCEPTION' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_PAYMENT_EXCEPTION',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_PAYMENTS_STIC_ATTENDANCES_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_PAYMENTS_STIC_ATTENDANCES_FROM_STIC_PAYMENTS_TITLE',
        'id' => 'STIC_PAYMENTS_STIC_ATTENDANCESSTIC_PAYMENTS_IDA',
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
