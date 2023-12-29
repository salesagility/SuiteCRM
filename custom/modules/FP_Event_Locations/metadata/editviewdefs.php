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
$viewdefs['FP_Event_Locations']['EditView'] = array (
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
      'LBL_FP_EVENT_LOCATIONS_INFORMATION' => 
      array (
        'newTab' => true,
        'panelDefault' => 'expanded',
      ),
      'LBL_STIC_PANEL_ADDRESS' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
    'syncDetailEditViews' => false,
  ),
  'panels' => 
  array (
    'lbl_fp_event_locations_information' => 
    array (
      0 => 
      array (
        0 => 'name',
        1 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'capacity',
          'label' => 'LBL_CAPACITY',
        ),
        1 => '',
      ),
      2 => 
      array (
        0 => 'description',
      ),
    ),
    'lbl_stic_panel_address' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'address',
          'label' => 'LBL_ADDRESS',
        ),
        1 => '',
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'address_postalcode',
          'label' => 'LBL_ADDRESS_POSTALCODE',
        ),
        1 => '',
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'address_city',
          'label' => 'LBL_ADDRESS_CITY',
        ),
        1 => '',
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'stic_address_county_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ADDRESS_COUNTY',
        ),
        1 => '',
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'address_state',
          'label' => 'LBL_ADDRESS_STATE',
        ),
        1 => '',
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'stic_address_region_c',
          'studio' => 'visible',
          'label' => 'LBL_STIC_ADDRESS_REGION',
        ),
        1 => '',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'address_country',
          'label' => 'LBL_ADDRESS_COUNTRY',
        ),
        1 => '',
      ),
    ),
  ),
);