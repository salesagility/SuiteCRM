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
$listViewDefs['Accounts'] = array (
  'NAME' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
  ),
  'STIC_ACRONYM_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_ACRONYM',
    'width' => '10%',
  ),
  'STIC_RELATIONSHIP_TYPE_C' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
    'width' => '10%',
  ),
  'STIC_CATEGORY_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_CATEGORY',
    'width' => '10%',
  ),
  'STIC_SUBCATEGORY_C' => 
  array (
    'type' => 'dynamicenum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SUBCATEGORY',
    'width' => '10%',
  ),
  'PHONE_OFFICE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_PHONE',
    'default' => true,
  ),
  'EMAIL1' => 
  array (
    'width' => '15%',
    'label' => 'LBL_EMAIL_ADDRESS',
    'sortable' => false,
    'link' => true,
    'customCode' => '{$EMAIL1_LINK}',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'STIC_IDENTIFICATION_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
    'width' => '10%',
  ),
  'PARENT_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MEMBER_OF',
    'id' => 'PARENT_ID',
    'width' => '10%',
    'default' => false,
  ),
  'STIC_LANGUAGE_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_LANGUAGE',
    'width' => '10%',
  ),
  'STIC_TAX_NAME_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_TAX_NAME',
    'width' => '10%',
  ),
  'PHONE_ALTERNATE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_OTHER_PHONE',
    'default' => false,
  ),
  'WEBSITE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_WEBSITE',
    'default' => false,
  ),
  'PHONE_FAX' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PHONE_FAX',
    'default' => false,
  ),
  'STIC_BILLING_ADDRESS_TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_BILLING_ADDRESS_TYPE',
    'width' => '10%',
  ),
  'BILLING_ADDRESS_STREET' => 
  array (
    'width' => '15%',
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'default' => false,
  ),
  'BILLING_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'BILLING_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_CITY',
    'default' => false,
  ),
  'STIC_BILLING_ADDRESS_COUNTY_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_BILLING_ADDRESS_COUNTY',
    'width' => '10%',
  ),
  'BILLING_ADDRESS_STATE' => 
  array (
    'width' => '7%',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'default' => false,
  ),
  'STIC_BILLING_ADDRESS_REGION_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_BILLING_ADDRESS_REGION',
    'width' => '10%',
  ),
  'BILLING_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'default' => false,
  ),
  'STIC_SHIPPING_ADDRESS_TYPE_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SHIPPING_ADDRESS_TYPE',
    'width' => '10%',
  ),
  'SHIPPING_ADDRESS_STREET' => 
  array (
    'width' => '15%',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_CITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'default' => false,
  ),
  'STIC_SHIPPING_ADDRESS_COUNTY_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SHIPPING_ADDRESS_COUNTY',
    'width' => '10%',
  ),
  'SHIPPING_ADDRESS_STATE' => 
  array (
    'width' => '7%',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'default' => false,
  ),
  'STIC_SHIPPING_ADDRESS_REGION_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SHIPPING_ADDRESS_REGION',
    'width' => '10%',
  ),
  'SHIPPING_ADDRESS_COUNTRY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'default' => false,
  ),
  'CAMPAIGN_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CAMPAIGN',
    'id' => 'CAMPAIGN_ID',
    'width' => '10%',
    'default' => false,
  ),
  'STIC_182_ERROR_C' => 
  array (
    'type' => 'bool',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_182_ERROR',
    'width' => '10%',
  ),
  'STIC_TOTAL_ANNUAL_DONATIONS_C' => 
  array (
    'type' => 'currency',
    'default' => false,
    'studio' => 
    array (
      'editview' => false,
      'quickcreate' => false,
    ),
    'label' => 'LBL_STIC_TOTAL_ANNUAL_DONATIONS',
    'currency_format' => true,
    'width' => '10%',
  ),
  'STIC_182_EXCLUDED_C' => 
  array (
    'type' => 'bool',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_182_EXCLUDED',
    'width' => '10%',
  ),
  'STIC_POSTAL_MAIL_RETURN_REASON_C' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
    'width' => '10%',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'EMPLOYEES' => 
  array (
    'width' => '10%',
    'label' => 'LBL_EMPLOYEES',
    'default' => false,
  ),
  'JJWG_MAPS_ADDRESS_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_ADDRESS',
    'width' => '10%',
  ),
  'JJWG_MAPS_GEOCODE_STATUS_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_GEOCODE_STATUS',
    'width' => '10%',
  ),
  'JJWG_MAPS_LAT_C' => 
  array (
    'type' => 'float',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_LAT',
    'width' => '10%',
  ),
  'JJWG_MAPS_LNG_C' => 
  array (
    'type' => 'float',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_LNG',
    'width' => '10%',
  ),
  'CREATED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_MODIFIED',
    'default' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => false,
  ),
  'DATE_MODIFIED' => 
  array (
    'width' => '5%',
    'label' => 'LBL_DATE_MODIFIED',
    'default' => false,
  ),
);