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
// created: 2020-10-27 18:12:42
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
        'stic_sessions_stic_events_name' => array(
            'type' => 'relate',
            'link' => true,
            'vname' => 'LBL_STIC_SESSIONS_STIC_EVENTS_FROM_STIC_EVENTS_TITLE',
            'id' => 'STIC_SESSIONS_STIC_EVENTSSTIC_EVENTS_IDA',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'stic_Events',
            'target_record_key' => 'stic_sessions_stic_eventsstic_events_ida',
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
        'activity_type' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'vname' => 'LBL_ACTIVITY_TYPE',
            'width' => '10%',
            'default' => true,
        ),
        'total_attendances' => array(
            'type' => 'int',
            'default' => true,
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
            'vname' => 'LBL_TOTAL_ATTENDANCES',
            'width' => '10%',
        ),
        'validated_attendances' => array(
            'type' => 'int',
            'default' => true,
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
            'vname' => 'LBL_VALIDATED_ATTENDANCES',
            'width' => '10%',
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
            'module' => 'stic_Sessions',
            'width' => '4%',
            'default' => true,
        ),
        // 'remove_button' => array(
        //     'vname' => 'LBL_REMOVE',
        //     'widget_class' => 'SubPanelRemoveButton',
        //     'module' => 'stic_Sessions',
        //     'width' => '5%',
        //     'default' => true,
        // ),
    ),
);