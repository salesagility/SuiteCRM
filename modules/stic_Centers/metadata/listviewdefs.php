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
$module_name = 'stic_Centers';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'STIC_CENTERS_ACCOUNTS_NAME' => array(
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_STIC_CENTERS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
        'id' => 'STIC_CENTERS_ACCOUNTSACCOUNTS_IDA',
        'link' => true,
        'width' => '10%',
        'default' => true,
    ),
    'TYPE' => array(
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_TYPE',
        'width' => '10%',
    ),
    'ADDRESS_CITY' => array(
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_CITY',
        'width' => '10%',
        'default' => true,
    ),
    'PLACES' => array(
        'type' => 'int',
        'label' => 'LBL_PLACES',
        'width' => '5%',
        'default' => true,
    ),
    'ADAPTED' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_ADAPTED',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'ADDRESS_STREET' => array(
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_STREET',
        'width' => '10%',
        'default' => false,
    ),
    'ADDRESS_STATE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_ADDRESS_STATE',
        'width' => '10%',
        'default' => false,
    ),
    'ADDRESS_POSTALCODE' => array(
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_POSTALCODE',
        'width' => '10%',
        'default' => false,
    ),
    'ADDRESS_COUNTRY' => array(
        'type' => 'varchar',
        'label' => 'LBL_ADDRESS_COUNTRY',
        'width' => '10%',
        'default' => false,
    ),
    'URL_LOCATION' => array(
        'type' => 'url',
        'label' => 'LBL_URL_LOCATION',
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
      'default' => false,
      'width' => '10%',
  ),
  'MODIFIED_BY_NAME' => array(
      'type' => 'relate',
      'link' => true,
      'label' => 'LBL_MODIFIED_NAME',
      'id' => 'MODIFIED_USER_ID',
      'default' => false,
      'width' => '10%',
  ),
  'DATE_MODIFIED' => array(
      'type' => 'datetime',
      'label' => 'LBL_DATE_MODIFIED',
      'default' => false,
      'width' => '10%',
  ),
  'DATE_ENTERED' => array(
      'type' => 'datetime',
      'label' => 'LBL_DATE_ENTERED',
      'default' => false,
      'width' => '10%',
  ),
);
