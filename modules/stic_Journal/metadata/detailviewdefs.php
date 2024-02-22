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

$module_name = 'stic_Journal';
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
        'LBL_PANEL_TASKS' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_INFRINGEMENTS' => 
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
      'syncDetailEditViews' => false,
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
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'journal_date',
            'label' => 'LBL_JOURNAL_DATE',
          ),
          1 => 
          array (
            'name' => 'turn',
            'studio' => 'visible',
            'label' => 'LBL_TURN',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'stic_journal_stic_centers_name',
            'label' => 'LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_CENTERS_TITLE',
          ),
          1 => array (),
        ),
        4 => 
        array (
          0 => 'description',
        ),
      ),
      'lbl_panel_tasks' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'task',
            'studio' => 'visible',
            'label' => 'LBL_TASK',
          ),
          1 => 
          array (
            'name' => 'task_scope',
            'studio' => 'visible',
            'label' => 'LBL_TASK_SCOPE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'task_start_date',
            'label' => 'LBL_TASK_START_DATE',
          ),
          1 => 
          array (
            'name' => 'task_end_date',
            'label' => 'LBL_TASK_END_DATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'task_fulfillment',
            'studio' => 'visible',
            'label' => 'LBL_TASK_FULFILLMENT',
          ),
          1 => array (),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'task_description',
            'studio' => 'visible',
            'label' => 'LBL_TASK_DESCRIPTION',
          ),
        ),
      ),
      'lbl_panel_infringements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'infringement_seriousness',
            'studio' => 'visible',
            'label' => 'LBL_INFRINGEMENT_SERIOUSNESS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'infringement_description',
            'studio' => 'visible',
            'label' => 'LBL_INFRINGEMENT_DESCRIPTION',
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
            'comment' => 'Date record created',
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
            'comment' => 'Date record last modified',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
    ),
  ),
);
;
?>