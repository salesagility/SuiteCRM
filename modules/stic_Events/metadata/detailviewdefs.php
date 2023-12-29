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
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_DEFAULT_PANEL' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_STATUS_PANEL' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_ECONOMY_PANEL' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_RECORD_DETAILS' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_default_panel' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'start_date',
            'label' => 'LBL_START_DATE',
          ),
          1 => 
          array (
            'name' => 'end_date',
            'label' => 'LBL_END_DATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'stic_events_project_name',
            'label' => 'LBL_STIC_EVENTS_PROJECT_FROM_PROJECT_TITLE',
          ),
          1 => 
          array (
            'name' => 'stic_events_fp_event_locations_name',
            'label' => 'LBL_STIC_EVENTS_FP_EVENT_LOCATIONS_FROM_FP_EVENT_LOCATIONS_TITLE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'stic_centers_stic_events_name',
            'label' => 'LBL_STIC_CENTERS_STIC_EVENTS_FROM_STIC_CENTERS_TITLE',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'max_attendees',
            'label' => 'LBL_MAX_ATTENDEES',
          ),
          1 => 
          array (
            'name' => 'attendees',
            'label' => 'LBL_ATTENDEES',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'timetable',
            'label' => 'LBL_TIMETABLE',
          ),
          1 => 
          array (
            'name' => 'total_hours',
            'label' => 'LBL_TOTAL_HOURS',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'discard_reason',
            'studio' => 'visible',
            'label' => 'LBL_DISCARD_REASON',
          ),
          1 => 
          array (
            'name' => 'session_amount',
            'label' => 'LBL_SESSION_AMOUNT',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'session_color',
            'label' => 'LBL_SESSION_COLOR',
          ),
          1 => '',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
      'lbl_status_panel' => 
      array (
        0 => 
        array (
          0 => 'status_confirmed',
          1 => 'status_invited',
        ),
        1 => 
        array (
          0 => 'status_not_invited',
          1 => 'status_maybe',
        ),
        2 => 
        array (
          0 => 'status_took_part',
          1 => 'status_didnt_take_part',
        ),
        3 => 
        array (
          0 => 'status_rejected',
          1 => 'status_drop_out',
        ),
      ),
      'lbl_economy_panel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'expected_cost',
            'label' => 'LBL_EXPECTED_COST',
          ),
          1 => 
          array (
            'name' => 'actual_cost',
            'label' => 'LBL_ACTUAL_COST',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
          1 => 
          array (
            'name' => 'budget',
            'label' => 'LBL_BUDGET',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'expected_income',
            'label' => 'LBL_EXPECTED_INCOME',
          ),
          1 => 
          array (
            'name' => 'actual_income',
            'label' => 'LBL_ACTUAL_INCOME',
          ),
        ),
      ),
      'lbl_panel_record_details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'modified_by_name',
            'label' => 'LBL_MODIFIED_NAME',
          ),
          1 => 
          array (
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
    ),
  ),
);
;
?>
