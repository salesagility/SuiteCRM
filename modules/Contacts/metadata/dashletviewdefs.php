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
$dashletData['ContactsDashlet']['searchFields'] = array(
    'first_name' => array(
        'default' => '',
    ),
    'last_name' => array(
        'default' => '',
    ),
    'stic_relationship_type_c' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['ContactsDashlet']['columns'] = array(
    'full_name' => array(
        'type' => 'fullname',
        'studio' => array(
            'listview' => false,
        ),
        'label' => 'LBL_NAME',
        'width' => '10%',
        'default' => false,
        'name' => 'full_name',
    ),
    'name' => array(
        'width' => '30%',
        'label' => 'LBL_NAME',
        'link' => true,
        'default' => true,
        'related_fields' => array(
            0 => 'first_name',
            1 => 'last_name',
            2 => 'salutation',
        ),
        'name' => 'name',
    ),
    'stic_relationship_type_c' => array(
        'type' => 'multienum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
        'width' => '10%',
        'name' => 'stic_relationship_type_c',
    ),
    'account_name' => array(
        'width' => '20%',
        'label' => 'LBL_ACCOUNT_NAME',
        'sortable' => false,
        'link' => true,
        'module' => 'Accounts',
        'id' => 'ACCOUNT_ID',
        'ACLTag' => 'ACCOUNT',
        'name' => 'account_name',
        'default' => true,
    ),
    'phone_mobile' => array(
        'width' => '10%',
        'label' => 'LBL_MOBILE_PHONE',
        'name' => 'phone_mobile',
        'default' => true,
    ),
    'email1' => array(
        'width' => '10%',
        'label' => 'LBL_EMAIL_ADDRESS',
        'sortable' => false,
        'customCode' => '{$EMAIL1_LINK}',
        'name' => 'email1',
        'default' => true,
    ),
    'assigned_user_name' => array(
        'width' => '15%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'default' => true,
        'name' => 'assigned_user_name',
    ),
    'first_name' => array(
        'type' => 'varchar',
        'label' => 'LBL_FIRST_NAME',
        'width' => '10%',
        'default' => false,
    ),
    'last_name' => array(
        'type' => 'varchar',
        'label' => 'LBL_LAST_NAME',
        'width' => '10%',
        'default' => false,
    ),
    'stic_identification_type_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_IDENTIFICATION_TYPE',
        'width' => '10%',
        'name' => 'stic_identification_type_c',
    ),
    'stic_identification_number_c' => array(
        'type' => 'varchar',
        'default' => false,
        'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
        'width' => '10%',
        'name' => 'stic_identification_number_c',
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'phone_home' => array(
        'type' => 'phone',
        'label' => 'LBL_HOME_PHONE',
        'width' => '10%',
        'default' => false,
        'name' => 'phone_home',
    ),
    'phone_work' => array(
        'type' => 'phone',
        'label' => 'LBL_OFFICE_PHONE',
        'width' => '10%',
        'default' => false,
        'name' => 'phone_work',
    ),
    'phone_other' => array(
        'type' => 'phone',
        'label' => 'LBL_OTHER_PHONE',
        'width' => '10%',
        'default' => false,
        'name' => 'phone_other',
    ),
    'stic_gender_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_GENDER',
        'width' => '10%',
        'name' => 'stic_gender_c',
    ),
    'stic_language_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_LANGUAGE',
        'width' => '10%',
        'name' => 'stic_language_c',
    ),
    'stic_acquisition_channel_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_ACQUISITION_CHANNEL',
        'width' => '10%',
        'name' => 'stic_acquisition_channel_c',
    ),
    'stic_preferred_contact_channel_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_PREFERRED_CONTACT_CHANNEL',
        'width' => '10%',
        'name' => 'stic_preferred_contact_channel_c',
    ),
    'stic_referral_agent_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_REFERRAL_AGENT',
        'width' => '10%',
        'name' => 'stic_referral_agent_c',
    ),
    'stic_professional_sector_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_PROFESSIONAL_SECTOR',
        'width' => '10%',
        'name' => 'stic_professional_sector_c',
    ),
    'stic_professional_sector_other_c' => array(
        'type' => 'varchar',
        'default' => false,
        'label' => 'LBL_STIC_PROFESSIONAL_SECTOR_OTHER',
        'width' => '10%',
        'name' => 'stic_professional_sector_other_c',
    ),
    'stic_employment_status_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_EMPLOYMENT_STATUS',
        'width' => '10%',
        'name' => 'stic_employment_status_c',
    ),
    'title' => array(
        'type' => 'varchar',
        'label' => 'LBL_TITLE',
        'width' => '10%',
        'default' => false,
        'name' => 'title',
    ),
    'department' => array(
        'type' => 'varchar',
        'label' => 'LBL_DEPARTMENT',
        'width' => '10%',
        'default' => false,
    ),
    'stic_total_annual_donations_c' => array(
        'type' => 'currency',
        'default' => false,
        'label' => 'LBL_STIC_TOTAL_ANNUAL_DONATIONS',
        'currency_format' => true,
        'width' => '10%',
        'name' => 'stic_total_annual_donations_c',
    ),
    'stic_182_excluded_c' => array(
        'type' => 'bool',
        'default' => false,
        'label' => 'LBL_STIC_182_EXCLUDED',
        'width' => '10%',
        'name' => 'stic_182_excluded_c',
    ),
    'stic_182_error_c' => array(
        'type' => 'bool',
        'default' => false,
        'label' => 'LBL_STIC_182_ERROR',
        'width' => '10%',
        'name' => 'stic_182_error_c',
    ),
    'do_not_call' => array(
        'type' => 'bool',
        'default' => false,
        'label' => 'LBL_DO_NOT_CALL',
        'width' => '10%',
    ),
    'stic_do_not_send_postal_mail_c' => array(
        'type' => 'bool',
        'default' => false,
        'label' => 'LBL_STIC_DO_NOT_SEND_POSTAL_MAIL',
        'width' => '10%',
        'name' => 'stic_do_not_send_postal_mail_c',
    ),
    'stic_postal_mail_return_reason_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
        'width' => '10%',
        'name' => 'stic_postal_mail_return_reason_c',
    ),
    'campaign_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CAMPAIGN',
        'id' => 'CAMPAIGN_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'campaign_name',
    ),
    'lawful_basis' => array(
        'type' => 'multienum',
        'label' => 'LBL_LAWFUL_BASIS',
        'width' => '10%',
        'default' => false,
        'name' => 'lawful_basis',
    ),
    'date_reviewed' => array(
        'type' => 'date',
        'label' => 'LBL_DATE_REVIEWED',
        'width' => '10%',
        'default' => false,
        'name' => 'date_reviewed',
    ),
    'lawful_basis_source' => array(
        'type' => 'enum',
        'label' => 'LBL_LAWFUL_BASIS_SOURCE',
        'width' => '10%',
        'default' => false,
        'name' => 'lawful_basis_source',
    ),
    'stic_primary_address_type_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_PRIMARY_ADDRESS_TYPE',
        'width' => '10%',
        'name' => 'stic_primary_address_type_c',
    ),
    'primary_address_street' => array(
        'type' => 'varchar',
        'label' => 'LBL_PRIMARY_ADDRESS_STREET',
        'width' => '10%',
        'default' => false,
        'name' => 'primary_address_street',
    ),
    'primary_address_postalcode' => array(
        'type' => 'varchar',
        'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
        'width' => '10%',
        'default' => false,
        'name' => 'primary_address_postalcode',
    ),
    'primary_address_city' => array(
        'type' => 'varchar',
        'label' => 'LBL_PRIMARY_ADDRESS_CITY',
        'width' => '10%',
        'default' => false,
        'name' => 'primary_address_city',
    ),
    'stic_primary_address_county_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_PRIMARY_ADDRESS_COUNTY',
        'width' => '10%',
        'name' => 'stic_primary_address_county_c',
    ),
    'primary_address_state' => array(
        'type' => 'enum',
        'default' => false,
        'label' => 'LBL_PRIMARY_ADDRESS_STATE',
        'width' => '10%',
        'name' => 'primary_address_state',
    ),
    'stic_primary_address_region_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_PRIMARY_ADDRESS_REGION',
        'width' => '10%',
        'name' => 'stic_primary_address_region_c',
    ),
    'primary_address_country' => array(
        'type' => 'varchar',
        'label' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
        'width' => '10%',
        'default' => false,
        'name' => 'primary_address_country',
    ),
    'jjwg_maps_address_c' => array(
        'type' => 'varchar',
        'default' => false,
        'label' => 'LBL_JJWG_MAPS_ADDRESS',
        'width' => '10%',
        'name' => 'jjwg_maps_address_c',
    ),
    'jjwg_maps_geocode_status_c' => array(
        'type' => 'varchar',
        'default' => false,
        'label' => 'LBL_JJWG_MAPS_GEOCODE_STATUS',
        'width' => '10%',
        'name' => 'jjwg_maps_geocode_status_c',
    ),
    'jjwg_maps_lat_c' => array(
        'type' => 'float',
        'default' => false,
        'label' => 'LBL_JJWG_MAPS_LAT',
        'width' => '10%',
        'name' => 'jjwg_maps_lat_c',
    ),
    'jjwg_maps_lng_c' => array(
        'type' => 'float',
        'default' => false,
        'label' => 'LBL_JJWG_MAPS_LNG',
        'width' => '10%',
        'name' => 'jjwg_maps_lng_c',
    ),
    'stic_alt_address_type_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_ALT_ADDRESS_TYPE',
        'width' => '10%',
        'name' => 'stic_alt_address_type_c',
    ),
    'alt_address_street' => array(
        'type' => 'varchar',
        'label' => 'LBL_ALT_ADDRESS_STREET',
        'width' => '10%',
        'default' => false,
        'name' => 'alt_address_street',
    ),
    'alt_address_postalcode' => array(
        'type' => 'varchar',
        'label' => 'LBL_ALT_ADDRESS_POSTALCODE',
        'width' => '10%',
        'default' => false,
        'name' => 'alt_address_postalcode',
    ),
    'alt_address_city' => array(
        'type' => 'varchar',
        'label' => 'LBL_ALT_ADDRESS_CITY',
        'width' => '10%',
        'default' => false,
        'name' => 'alt_address_city',
    ),
    'stic_alt_address_county_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_ALT_ADDRESS_COUNTY',
        'width' => '10%',
        'name' => 'stic_alt_address_county_c',
    ),
    'alt_address_state' => array(
        'type' => 'enum',
        'default' => false,
        'label' => 'LBL_ALT_ADDRESS_STATE',
        'width' => '10%',
    ),
    'stic_alt_address_region_c' => array(
        'type' => 'enum',
        'default' => false,
        'studio' => 'visible',
        'label' => 'LBL_STIC_ALT_ADDRESS_REGION',
        'width' => '10%',
        'name' => 'stic_alt_address_region_c',
    ),
    'alt_address_country' => array(
        'type' => 'varchar',
        'label' => 'LBL_ALT_ADDRESS_COUNTRY',
        'width' => '10%',
        'default' => false,
        'name' => 'alt_address_country',
    ),
    'created_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
        'name' => 'created_by_name',
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
        'name' => 'date_entered',
    ),
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'modified_by_name',
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
);
// END STIC-Custom 