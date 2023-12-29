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
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'type' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'start_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'start_date',
      ),
      'end_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'end_date',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
      'max_attendees' => 
      array (
        'type' => 'int',
        'label' => 'LBL_MAX_ATTENDEES',
        'width' => '10%',
        'default' => true,
        'name' => 'max_attendees',
      ),
      'total_hours' => 
      array (
        'type' => 'decimal',
        'label' => 'LBL_TOTAL_HOURS',
        'width' => '10%',
        'default' => true,
        'name' => 'total_hours',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'width' => '10%',
        'default' => true,
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
      'favorites_only' => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'type' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'type',
      ),
      'start_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_START_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'start_date',
      ),
      'end_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_END_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'end_date',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
      'max_attendees' => 
      array (
        'type' => 'int',
        'label' => 'LBL_MAX_ATTENDEES',
        'width' => '10%',
        'default' => true,
        'name' => 'max_attendees',
      ),
      'total_hours' => 
      array (
        'type' => 'decimal',
        'label' => 'LBL_TOTAL_HOURS',
        'width' => '10%',
        'default' => true,
        'name' => 'total_hours',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'width' => '10%',
        'default' => true,
      ),
      'stic_events_fp_event_locations_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_EVENTS_FP_EVENT_LOCATIONS_FROM_FP_EVENT_LOCATIONS_TITLE',
        'id' => 'STIC_EVENTS_FP_EVENT_LOCATIONSFP_EVENT_LOCATIONS_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'stic_events_fp_event_locations_name',
      ),
      'stic_events_project_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_STIC_EVENTS_PROJECT_FROM_PROJECT_TITLE',
        'id' => 'STIC_EVENTS_PROJECTPROJECT_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'stic_events_project_name',
      ),
      'attendees' => 
      array (
        'type' => 'int',
        'label' => 'LBL_ATTENDEES',
        'width' => '10%',
        'default' => true,
        'name' => 'attendees',
      ),
      'price' => 
      array (
        'type' => 'currency',
        'label' => 'LBL_PRICE',
        'width' => '10%',
        'default' => true,
        'name' => 'price',
      ),
      'status_drop_out' => 
      array (
        'label' => 'LBL_STATUS_DROP_OUT',
        'width' => '10%',
        'default' => true,
        'name' => 'status_drop_out',
      ),
      'status_took_part' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_TOOK_PART',
        'width' => '10%',
        'default' => true,
        'name' => 'status_took_part',
      ),
      'status_didnt_take_part' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_DIDNT_TAKE_PART',
        'width' => '10%',
        'default' => true,
        'name' => 'status_didnt_take_part',
      ),
      'status_maybe' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_MAYBE',
        'width' => '10%',
        'default' => true,
        'name' => 'status_maybe',
      ),
      'status_rejected' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_REJECTED',
        'width' => '10%',
        'default' => true,
        'name' => 'status_rejected',
      ),
      'status_confirmed' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_CONFIRMED',
        'width' => '10%',
        'default' => true,
        'name' => 'status_confirmed',
      ),
      'status_invited' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_INVITED',
        'width' => '10%',
        'default' => true,
        'name' => 'status_invited',
      ),
      'status_not_invited' => 
      array (
        'type' => 'int',
        'label' => 'LBL_STATUS_NOT_INVITED',
        'width' => '10%',
        'default' => true,
        'name' => 'status_not_invited',
      ),
      'discard_reason' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_DISCARD_REASON',
        'width' => '10%',
        'default' => true,
        'name' => 'discard_reason',
      ),
      'timetable' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_TIMETABLE',
        'width' => '10%',
        'default' => true,
        'name' => 'timetable',
      ),
      'session_amount' => 
      array (
        'type' => 'decimal',
        'label' => 'LBL_SESSION_AMOUNT',
        'width' => '10%',
        'default' => true,
        'name' => 'session_amount',
      ),
      'session_color' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_SESSION_COLOR',
        'width' => '10%',
        'default' => true,
        'name' => 'session_color',
      ),
      'created_by' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_CREATED',
        'width' => '10%',
        'default' => true,
        'name' => 'created_by',
      ),
      'modified_user_id' => 
      array (
        'type' => 'assigned_user_name',
        'label' => 'LBL_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'modified_user_id',
      ),
      'date_modified' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_modified',
      ),
      'date_entered' => 
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      'current_user_only' => 
      array (
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'current_user_only',
      ),
      'favorites_only' => 
      array (
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'favorites_only',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
?>
