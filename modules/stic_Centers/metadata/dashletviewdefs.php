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
$dashletData['stic_CentersDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'type' => 
  array (
    'default' => '',
  ),
  'stic_centers_accounts_name' => 
  array (
    'default' => '',
  ),
  'adress_city' => 
  array (
    'default' => '',
  ),
  'places' => 
  array (
    'default' => '',
  ),
  'adapted' => 
  array (
    'default' => '',
  ),
  'assigned_user_name' => 
  array (
    'default' => '',
  ),
);
$dashletData['stic_CentersDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'stic_centers_accounts_name' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
    'id' => 'STIC_CENTERS_ACCOUNTSACCOUNTS_IDA',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'type' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
  ),
  'address_city' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'places' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PLACES',
    'width' => '5%',
    'default' => true,
  ),
  'adapted' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ADAPTED',
    'width' => '10%',
    'default' => true,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => true,
  ),
  'address_street' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_STREET',
    'width' => '10%',
    'default' => false,
  ),
  'address_state' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_ADDRESS_STATE',
    'width' => '10%',
    'default' => false,
  ),
  'address_postalcode' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_POSTALCODE',
    'width' => '10%',
    'default' => false,
  ),
  'address_country' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_COUNTRY',
    'width' => '10%',
    'default' => false,
  ),
  'url_location' => 
  array (
    'type' => 'url',
    'label' => 'LBL_URL_LOCATION',
    'width' => '10%',
    'default' => false,
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
    'name' => 'date_entered',
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
);
