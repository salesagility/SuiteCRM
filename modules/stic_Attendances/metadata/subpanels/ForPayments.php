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
// created: 2020-10-27 18:10:11
$subpanel_layout = array(
    'top_buttons' => '',
    'where' => '',
    'list_fields' => array(
        'name' => array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '45%',
            'default' => true,
        ),
        'start_date' => array(
            'type' => 'datetimecombo',
            'vname' => 'LBL_START_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'duration' => array(
            'type' => 'decimal',
            'vname' => 'LBL_DURATION',
            'width' => '10%',
            'default' => true,
        ),
        'amount' => array(
            'type' => 'decimal',
            'vname' => 'LBL_AMOUNT',
            'width' => '10%',
            'default' => true,
        ),
        'payment_exception' => array(
            'type' => 'enum',
            'vname' => 'LBL_PAYMENT_EXCEPTION',
            'width' => '10%',
            'default' => true,
        ),
        'status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'vname' => 'LBL_STATUS',
            'width' => '10%',
            'default' => true,
        ),
        'stic_attendances_stic_sessions_name' => array(
            'type' => 'relate',
            'link' => true,
            'vname' => 'LBL_STIC_ATTENDANCES_STIC_SESSIONS_FROM_STIC_SESSIONS_TITLE',
            'id' => 'STIC_ATTENDANCES_STIC_SESSIONSSTIC_SESSIONS_IDA',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'stic_Sessions',
            'target_record_key' => 'stic_attendances_stic_sessionsstic_sessions_ida',
        ),
        'stic_attendances_stic_registrations_name' => array(
            'type' => 'relate',
            'link' => true,
            'vname' => 'LBL_STIC_ATTENDANCES_STIC_REGISTRATIONS_FROM_STIC_REGISTRATIONS_TITLE',
            'id' => 'STIC_ATTENDANCES_STIC_REGISTRATIONSSTIC_REGISTRATIONS_IDA',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'stic_Registrations',
            'target_record_key' => 'stic_attendances_stic_registrationsstic_registrations_ida',
        ),
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'vname' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'Users',
            'target_record_key' => 'assigned_user_id',
        ),
        'edit_button' => array(
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'stic_Attendances',
            'width' => '4%',
            'default' => true,
        ),
        // 'remove_button' => array(
        //     'width' => '5%',
        //     'default' => true,
        //     'vname' => 'LBL_REMOVE',
        //     'widget_class' => 'SubPanelRemoveButton',
        // ),
    ),
);
