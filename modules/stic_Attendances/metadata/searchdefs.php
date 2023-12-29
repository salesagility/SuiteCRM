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
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
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
            'amount' => array(
                'type' => 'decimal',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'payment_exception' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_PAYMENT_EXCEPTION',
                'width' => '10%',
                'default' => true,
                'name' => 'payment_exception',
            ),
            'stic_payments_stic_attendances_name' => array(
                'type' => 'relate',
                'link' => true,
                'studio' => array(
                    'editview' => false,
                    'quickcreate' => false,
                ),
                'label' => 'LBL_STIC_PAYMENTS_STIC_ATTENDANCES_FROM_STIC_PAYMENTS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_PAYMENTS_STIC_ATTENDANCESSTIC_PAYMENTS_IDA',
                'name' => 'stic_payments_stic_attendances_name',
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
            'amount' => array(
                'type' => 'decimal',
                'label' => 'LBL_AMOUNT',
                'width' => '10%',
                'default' => true,
                'name' => 'amount',
            ),
            'payment_exception' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_PAYMENT_EXCEPTION',
                'width' => '10%',
                'default' => true,
                'name' => 'payment_exception',
            ),
            'stic_payments_stic_attendances_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_PAYMENTS_STIC_ATTENDANCES_FROM_STIC_PAYMENTS_TITLE',
                'id' => 'STIC_PAYMENTS_STIC_ATTENDANCESSTIC_PAYMENTS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_payments_stic_attendances_name',
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
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
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
