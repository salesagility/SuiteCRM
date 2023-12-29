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
$dashletData['stic_EventsDashlet']['searchFields'] = array(
    'name' => array(
        'default' => '',
    ),
    'type' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'start_date' => array(
        'default' => '',
    ),
    'end_date' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['stic_EventsDashlet']['columns'] = array(
    'name' => array(
        'width' => '25%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
        'name' => 'name',
    ),
    'type' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
    ),
    'start_date' => array(
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'start_date',
    ),
    'end_date' => array(
        'type' => 'date',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'end_date',
    ),
    'status' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
    ),
    'total_hours' => array(
        'type' => 'decimal',
        'label' => 'LBL_TOTAL_HOURS',
        'width' => '10%',
        'default' => true,
        'name' => 'total_hours',
    ),
    'max_attendees' => array(
        'type' => 'int',
        'label' => 'LBL_MAX_ATTENDEES',
        'width' => '10%',
        'default' => false,
        'name' => 'max_attendees',
    ),
    'status_took_part' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_TOOK_PART',
        'width' => '10%',
        'default' => false,
        'name' => 'status_took_part',
    ),
    'stic_events_project_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_EVENTS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'STIC_EVENTS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => false,
        'name' => 'stic_events_project_name',
    ),
    'assigned_user_name' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => false,
        'name' => 'assigned_user_name',
    ),
    'status_drop_out' => array(
        'label' => 'LBL_STATUS_DROP_OUT',
        'width' => '10%',
        'default' => false,
        'name' => 'status_drop_out',
    ),
    'attendees' => array(
        'type' => 'int',
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
        'default' => false,
        'name' => 'attendees',
    ),
    'price' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_PRICE',
        'width' => '10%',
        'default' => false,
        'name' => 'price',
    ),
    'actual_income' => array(
        'type' => 'decimal',
        'label' => 'LBL_ACTUAL_INCOME',
        'width' => '10%',
        'default' => false,
        'name' => 'actual_income',
    ),
    'expected_income' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_EXPECTED_INCOME',
        'width' => '10%',
        'default' => false,
        'name' => 'expected_income',
    ),
    'actual_cost' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_ACTUAL_COST',
        'width' => '10%',
        'default' => false,
        'name' => 'actual_cost',
    ),
    'expected_cost' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_EXPECTED_COST',
        'width' => '10%',
        'default' => false,
        'name' => 'expected_cost',
    ),
    'budget' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_BUDGET',
        'width' => '10%',
        'default' => false,
        'name' => 'budget',
    ),
    'status_didnt_take_part' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_DIDNT_TAKE_PART',
        'width' => '10%',
        'default' => false,
        'name' => 'status_didnt_take_part',
    ),
    'status_maybe' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_MAYBE',
        'width' => '10%',
        'default' => false,
        'name' => 'status_maybe',
    ),
    'status_rejected' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_REJECTED',
        'width' => '10%',
        'default' => false,
        'name' => 'status_rejected',
    ),
    'status_confirmed' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_CONFIRMED',
        'width' => '10%',
        'default' => false,
        'name' => 'status_confirmed',
    ),
    'status_invited' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_INVITED',
        'width' => '10%',
        'default' => false,
        'name' => 'status_invited',
    ),
    'status_not_invited' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_NOT_INVITED',
        'width' => '10%',
        'default' => false,
        'name' => 'status_not_invited',
    ),
    'discard_reason' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DISCARD_REASON',
        'width' => '10%',
        'default' => false,
        'name' => 'discard_reason',
    ),
    'timetable' => array(
        'type' => 'varchar',
        'label' => 'LBL_TIMETABLE',
        'width' => '10%',
        'default' => false,
        'name' => 'timetable',
    ),
    'session_amount' => array(
        'type' => 'decimal',
        'label' => 'LBL_SESSION_AMOUNT',
        'width' => '10%',
        'default' => false,
        'name' => 'session_amount',
    ),
    'session_color' => array(
        'type' => 'enum',
        'label' => 'LBL_SESSION_COLOR',
        'width' => '10%',
        'default' => false,
        'name' => 'session_color',
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
