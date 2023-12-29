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
    'moduleMain' => 'stic_Centers',
    'varName' => 'stic_Centers',
    'orderBy' => 'stic_centers.name',
    'whereClauses' => array (
  'name' => 'stic_centers.name',
  'stic_centers_accounts_name' => 'stic_centers.stic_centers_accounts_name',
  'type' => 'stic_centers.type',
  'adapted' => 'stic_centers.adapted',
  'assigned_user_name' => 'stic_centers.assigned_user_name',
  'places' => 'stic_centers.places',
  'address_city' => 'stic_centers.address_city',
  'current_user_only' => 'stic_centers.current_user_only',
),
    'searchInputs' => array (
  1 => 'name',
  2 => 'stic_centers_accounts_name',
  3 => 'type',
  6 => 'adapted',
  7 => 'assigned_user_name',
  8 => 'places',
  10 => 'address_city',
  20 => 'current_user_only',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'stic_centers_accounts_name' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'link' => true,
    'width' => '10%',
    'id' => 'STIC_CENTERS_ACCOUNTSACCOUNTS_IDA',
    'name' => 'stic_centers_accounts_name',
  ),
  'type' => 
  array (
    'type' => 'multienum',
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'name' => 'type',
  ),
  'address_city' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_CITY',
    'width' => '10%',
    'name' => 'address_city',
  ),
  'places' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PLACES',
    'width' => '10%',
    'name' => 'places',
  ),
  'adapted' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ADAPTED',
    'width' => '10%',
    'name' => 'adapted',
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
  'current_user_only' => 
  array (
    'label' => 'LBL_CURRENT_USER_FILTER',
    'type' => 'bool',
    'width' => '10%',
    'name' => 'current_user_only',
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
  'STIC_CENTERS_ACCOUNTS_NAME' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'STIC_CENTERS_ACCOUNTSACCOUNTS_IDA',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'name' => 'stic_centers_accounts_name',
  ),
  'TYPE' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
    'name' => 'type',
  ),
  'ADDRESS_CITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'PLACES' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PLACES',
    'width' => '10%',
    'default' => true,
  ),
  'ADAPTED' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ADAPTED',
    'width' => '10%',
    'default' => true,
    'name' => 'adapted',
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
