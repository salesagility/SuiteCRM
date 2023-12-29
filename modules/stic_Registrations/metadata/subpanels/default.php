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
$subpanel_layout = array(
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopCreateButton',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'popup_module' => 'stic_Registrations',
        ),
    ),
    'where' => '',
    'list_fields' => array(
        'name' => array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '20%',
            'default' => true,
        ),
        'stic_registrations_stic_events_name' => array(
            'type' => 'relate',
            'link' => true,
            'vname' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
            'id' => 'STIC_REGISTRATIONS_STIC_EVENTSSTIC_EVENTS_IDA',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'stic_Events',
            'target_record_key' => 'stic_registrations_stic_eventsstic_events_ida',
        ),
        'registration_date' => array(
            'type' => 'datetimecombo',
            'vname' => 'LBL_REGISTRATION_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'default' => true,
            'vname' => 'LBL_STATUS',
            'width' => '10%',
        ),
        'stic_registrations_contacts_name' => array(
            'type' => 'relate',
            'link' => true,
            'vname' => 'LBL_STIC_REGISTRATIONS_CONTACTS_FROM_CONTACTS_TITLE',
            'id' => 'STIC_REGISTRATIONS_CONTACTSCONTACTS_IDA',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'Contacts',
            'target_record_key' => 'stic_registrations_contactscontacts_ida',
        ),
        'attended_hours' => array(
            'type' => 'decimal',
            'vname' => 'LBL_ATTENDED_HOURS',
            'width' => '10%',
            'default' => true,
        ),
        'attendance_percentage' => array(
            'type' => 'decimal',
            'vname' => 'LBL_ATTENDANCE_PERCENTAGE',
            'width' => '10%',
            'default' => true,
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
            'module' => 'stic_Registrations',
            'width' => '4%',
            'default' => true,
        ),
        // 'remove_button' => array(
        //     'vname' => 'LBL_REMOVE',
        //     'widget_class' => 'SubPanelRemoveButton',
        //     'module' => 'stic_Registrations',
        //     'width' => '5%',
        //     'default' => true,
        // ),
    ),
);
