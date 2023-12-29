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
$popupMeta = array (
    'moduleMain' => 'stic_Incorpora_Locations',
    'varName' => 'stic_Incorpora_Locations',
    'orderBy' => 'stic_incorpora_locations.name',
    'whereClauses' => array (
  'name' => 'stic_incorpora_locations.name',
  'town' => 'stic_incorpora_locations.town',
  'municipality' => 'stic_incorpora_locations.municipality',
  'state' => 'stic_incorpora_locations.state',
  'town_code' => 'stic_incorpora_locations.town_code',
  'municipality_code' => 'stic_incorpora_locations.municipality_code',
  'state_code' => 'stic_incorpora_locations.state_code',
  'description' => 'stic_incorpora_locations.description',
  'assigned_user_name' => 'stic_incorpora_locations.assigned_user_name',
  'date_entered' => 'stic_incorpora_locations.date_entered',
  'date_modified' => 'stic_incorpora_locations.date_modified',
  'created_by_name' => 'stic_incorpora_locations.created_by_name',
  'modified_by_name' => 'stic_incorpora_locations.modified_by_name',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'town',
  5 => 'municipality',
  6 => 'state',
  7 => 'town_code',
  8 => 'municipality_code',
  9 => 'state_code',
  10 => 'description',
  11 => 'assigned_user_name',
  12 => 'date_entered',
  13 => 'date_modified',
  14 => 'created_by_name',
  15 => 'modified_by_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'town' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TOWN',
    'width' => '10%',
    'name' => 'town',
  ),
  'municipality' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MUNICIPALITY',
    'width' => '10%',
    'name' => 'municipality',
  ),
  'state' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_STATE',
    'width' => '10%',
    'name' => 'state',
  ),
  'town_code' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TOWN_CODE',
    'width' => '10%',
    'name' => 'town_code',
  ),
  'municipality_code' => 
  array (
    'type' => 'int',
    'label' => 'LBL_MUNICIPALITY_CODE',
    'width' => '10%',
    'name' => 'municipality_code',
  ),
  'state_code' => 
  array (
    'type' => 'int',
    'label' => 'LBL_STATE_CODE',
    'width' => '10%',
    'name' => 'state_code',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'name' => 'description',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'name' => 'assigned_user_name',
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'name' => 'date_modified',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'name' => 'created_by_name',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'name' => 'modified_by_name',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'MUNICIPALITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MUNICIPALITY',
    'width' => '10%',
    'default' => true,
    'name' => 'municipality',
  ),
  'TOWN' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TOWN',
    'width' => '10%',
    'default' => true,
    'name' => 'town',
  ),
  'STATE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_STATE',
    'width' => '10%',
    'default' => true,
    'name' => 'state',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
),
);
