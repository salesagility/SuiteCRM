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
$module_name = 'stic_Events';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '25%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'START_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'END_DATE' => array(
        'type' => 'date',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'MAX_ATTENDEES' => array(
        'type' => 'int',
        'label' => 'LBL_MAX_ATTENDEES',
        'width' => '10%',
        'default' => true,
        'align' => 'right',
    ),
    'TOTAL_HOURS' => array(
        'type' => 'decimal',
        'label' => 'LBL_TOTAL_HOURS',
        'width' => '10%',
        'align' => 'right',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'STIC_EVENTS_FP_EVENT_LOCATIONS_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_EVENTS_FP_EVENT_LOCATIONS_FROM_FP_EVENT_LOCATIONS_TITLE',
        'id' => 'STIC_EVENTS_FP_EVENT_LOCATIONSFP_EVENT_LOCATIONS_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'STIC_EVENTS_PROJECT_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_EVENTS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'STIC_EVENTS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => false,
    ),
    'ATTENDEES' => array(
        'type' => 'int',
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'PRICE' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_PRICE',
        'width' => '10%',
        'default' => false,
    ),
    'ACTUAL_INCOME' => array(
        'type' => 'decimal',
        'label' => 'LBL_ACTUAL_INCOME',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'EXPECTED_INCOME' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_EXPECTED_INCOME',
        'width' => '10%',
        'default' => false,
    ),
    'ACTUAL_COST' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_ACTUAL_COST',
        'width' => '10%',
        'default' => false,
    ),
    'EXPECTED_COST' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_EXPECTED_COST',
        'width' => '10%',
        'default' => false,
    ),
    'BUDGET' => array(
        'type' => 'decimal',
        'align' => 'right',
        'label' => 'LBL_BUDGET',
        'width' => '10%',
        'default' => false,
    ),
    'STATUS_DIDNT_TAKE_PART' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_DIDNT_TAKE_PART',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_MAYBE' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_MAYBE',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_REJECTED' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_REJECTED',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_CONFIRMED' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_CONFIRMED',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_INVITED' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_INVITED',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_NOT_INVITED' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_NOT_INVITED',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_TOOK_PART' => array(
        'type' => 'int',
        'label' => 'LBL_STATUS_TOOK_PART',
        'width' => '10%',
        'default' => false,
        'align' => 'right',
    ),
    'STATUS_DROP_OUT' => array(
        'label' => 'LBL_STATUS_DROP_OUT',
        'width' => '10%',
        'default' => false,
    ),
    'DISCARD_REASON' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DISCARD_REASON',
        'width' => '10%',
        'default' => false,
    ),
    'TIMETABLE' => array(
        'type' => 'varchar',
        'label' => 'LBL_TIMETABLE',
        'width' => '10%',
        'default' => false,
    ),
    'SESSION_AMOUNT' => 
    array (
        'type' => 'decimal',
        'label' => 'LBL_SESSION_AMOUNT',
        'width' => '10%',
        'default' => false,
    ),
    'SESSION_COLOR' => 
    array (
        'type' => 'enum',
        'label' => 'LBL_SESSION_COLOR',
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
