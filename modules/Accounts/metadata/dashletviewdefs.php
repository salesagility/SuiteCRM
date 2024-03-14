<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105

$dashletData['AccountsDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'stic_relationship_type_c' => 
  array (
    'default' => '',
  ),
  'stic_category_c' => 
  array (
    'default' => '',
  ),
  'stic_subcategory_c' => 
  array (
    'default' => '',
  ),
  'email1' => 
  array (
    'default' => '',
  ),
  'assigned_user_name' => 
  array (
    'default' => '',
  ),
);
$dashletData['AccountsDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'stic_relationship_type_c' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
    'width' => '10%',
    'name' => 'stic_relationship_type_c',
  ),
  'email1' => 
  array (
    'width' => '8%',
    'label' => 'LBL_EMAIL_ADDRESS_PRIMARY',
    'name' => 'email1',
    'default' => true,
  ),
  'stic_category_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STIC_CATEGORY',
    'width' => '10%',
    'name' => 'stic_category_c',
  ),
  'phone_office' => 
  array (
    'width' => '15%',
    'label' => 'LBL_LIST_PHONE',
    'default' => true,
    'name' => 'phone_office',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => true,
  ),
  'stic_acronym_c' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_STIC_ACRONYM',
    'width' => '10%',
    'name' => 'stic_acronym_c',
  ),
  'stic_subcategory_c' => 
  array (
    'type' => 'dynamicenum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SUBCATEGORY',
    'width' => '10%',
    'name' => 'stic_subcategory_c',
  ),
  'phone_alternate' => 
  array (
    'width' => '8%',
    'label' => 'LBL_OTHER_PHONE',
    'name' => 'phone_alternate',
    'default' => false,
  ),
  'stic_identification_number_c' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
    'width' => '10%',
    'name' => 'stic_identification_number_c',
  ),
  'parent_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MEMBER_OF',
    'id' => 'PARENT_ID',
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
    'name' => 'description',
  ),
  'stic_language_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_LANGUAGE',
    'width' => '10%',
    'name' => 'stic_language_c',
  ),
  'website' => 
  array (
    'width' => '8%',
    'label' => 'LBL_WEBSITE',
    'default' => false,
    'name' => 'website',
  ),
  'phone_fax' => 
  array (
    'width' => '8%',
    'label' => 'LBL_PHONE_FAX',
    'name' => 'phone_fax',
    'default' => false,
  ),
  'employees' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_EMPLOYEES',
    'width' => '10%',
    'default' => false,
    'name' => 'employees',
  ),
  'stic_billing_address_type_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_BILLING_ADDRESS_TYPE',
    'width' => '10%',
    'name' => 'stic_billing_address_type_c',
  ),
  'billing_address_street' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'name' => 'billing_address_street',
    'default' => false,
  ),
  'billing_address_postalcode' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'name' => 'billing_address_postalcode',
    'default' => false,
  ),
  'billing_address_city' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_CITY',
    'name' => 'billing_address_city',
    'default' => false,
  ),
  'stic_billing_address_county_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_BILLING_ADDRESS_COUNTY',
    'width' => '10%',
    'name' => 'stic_billing_address_county_c',
  ),
  'billing_address_state' => 
  array (
    'width' => '8%',
    'label' => 'LBL_BILLING_ADDRESS_STATE',
    'name' => 'billing_address_state',
    'default' => false,
  ),
  'stic_billing_address_region_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_BILLING_ADDRESS_REGION',
    'width' => '10%',
    'name' => 'stic_billing_address_region_c',
  ),
  'billing_address_country' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'width' => '10%',
    'default' => false,
    'name' => 'billing_address_country',
  ),
  'stic_shipping_address_type_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SHIPPING_ADDRESS_TYPE',
    'width' => '10%',
    'name' => 'stic_shipping_address_type_c',
  ),
  'shipping_address_street' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'name' => 'shipping_address_street',
    'default' => false,
  ),
  'shipping_address_postalcode' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'name' => 'shipping_address_postalcode',
    'default' => false,
  ),
  'shipping_address_city' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_CITY',
    'name' => 'shipping_address_city',
    'default' => false,
  ),
  'stic_shipping_address_county_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SHIPPING_ADDRESS_COUNTY',
    'width' => '10%',
    'name' => 'stic_shipping_address_county_c',
  ),
  'shipping_address_state' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_STATE',
    'name' => 'shipping_address_state',
    'default' => false,
  ),
  'stic_shipping_address_region_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_SHIPPING_ADDRESS_REGION',
    'width' => '10%',
    'name' => 'stic_shipping_address_region_c',
  ),
  'shipping_address_country' => 
  array (
    'width' => '8%',
    'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'name' => 'shipping_address_country',
    'default' => false,
  ),
  'campaign_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CAMPAIGN',
    'id' => 'CAMPAIGN_ID',
    'width' => '10%',
    'default' => false,
    'name' => 'campaign_name',
  ),
  'stic_tax_name_c' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_TAX_NAME',
    'width' => '10%',
    'name' => 'stic_tax_name_c',
  ),
  'stic_total_annual_donations_c' => 
  array (
    'type' => 'currency',
    'default' => false,
    'label' => 'LBL_STIC_TOTAL_ANNUAL_DONATIONS',
    'currency_format' => true,
    'width' => '10%',
    'name' => 'stic_total_annual_donations_c',
  ),
  'stic_182_excluded_c' => 
  array (
    'type' => 'bool',
    'default' => false,
    'label' => 'LBL_STIC_182_EXCLUDED',
    'width' => '10%',
    'name' => 'stic_182_excluded_c',
  ),
  'stic_182_error_c' => 
  array (
    'type' => 'bool',
    'default' => false,
    'label' => 'LBL_STIC_182_ERROR',
    'width' => '10%',
    'name' => 'stic_182_error_c',
  ),
  'stic_postal_mail_return_reason_c' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
    'width' => '10%',
    'name' => 'stic_postal_mail_return_reason_c',
  ),
  'jjwg_maps_address_c' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_ADDRESS',
    'width' => '10%',
    'name' => 'jjwg_maps_address_c',
  ),
  'jjwg_maps_geocode_status_c' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_GEOCODE_STATUS',
    'width' => '10%',
    'name' => 'jjwg_maps_geocode_status_c',
  ),
  'jjwg_maps_lng_c' => 
  array (
    'type' => 'float',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_LNG',
    'width' => '10%',
    'name' => 'jjwg_maps_lng_c',
  ),
  'jjwg_maps_lat_c' => 
  array (
    'type' => 'float',
    'default' => false,
    'label' => 'LBL_JJWG_MAPS_LAT',
    'width' => '10%',
    'name' => 'jjwg_maps_lat_c',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
    'name' => 'created_by_name',
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'name' => 'date_entered',
    'default' => false,
  ),
  'modified_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
    'name' => 'modified_by_name',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
);

// END STIC-Custom