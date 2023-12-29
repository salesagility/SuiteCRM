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
// created: 2020-07-04 10:28:55
$viewdefs['Project']['QuickCreate'] = array (
  'templateMeta' => 
  array (
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
      'LBL_OVERVIEW_PANEL' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'lbl_overview_panel' => 
    array (
      0 => 
      array (
        0 => 'name',
        1 => 'assigned_user_name',
      ),
      1 => 
      array (
        0 => 'estimated_start_date',
        1 => 'estimated_end_date',
      ),
      2 => 
      array (
        0 => 'status',
        1 => 
        array (
          'name' => 'am_projecttemplates_project_1_name',
          'label' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
        ),
      ),
      3 => 
      array (
        0 => 'priority',
        1 => 
        array (
          'name' => 'override_business_hours',
          'comment' => '',
          'label' => 'LBL_OVERRIDE_BUSINESS_HOURS',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'stic_location_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_LOCATION',
        ),
        1 => '',
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'comment' => 'Project description',
          'label' => 'LBL_DESCRIPTION',
        ),
      ),
    ),
  ),
);