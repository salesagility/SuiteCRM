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
$popupMeta = array(
    'moduleMain' => 'Account',
    'varName' => 'ACCOUNT',
    'orderBy' => 'name',
    'whereClauses' => array(
        'name' => 'accounts.name',
        'email' => 'accounts.email',
        'stic_category_c' => 'accounts_cstm.stic_category_c',
        'stic_subcategory_c' => 'accounts_cstm.stic_subcategory_c',
        'phone_alternate' => 'accounts.phone_alternate',
        'phone_office' => 'accounts.phone_office',
        'assigned_user_name' => 'accounts.assigned_user_name',
        'created_by_name' => 'accounts.created_by_name',
        'date_entered' => 'accounts.date_entered',
        'modified_by_name' => 'accounts.modified_by_name',
        'date_modified' => 'accounts.date_modified',
        'stic_relationship_type_c' => 'accounts_cstm.stic_relationship_type_c',
        'stic_identification_number_c' => 'accounts_cstm.stic_identification_number_c',
        'stic_language_c' => 'accounts_cstm.stic_language_c',
        'stic_billing_address_type_c' => 'accounts_cstm.stic_billing_address_type_c',
        'billing_address_street' => 'accounts.billing_address_street',
        'billing_address_postalcode' => 'accounts.billing_address_postalcode',
        'billing_address_city' => 'accounts.billing_address_city',
        'stic_billing_address_county_c' => 'accounts_cstm.stic_billing_address_county_c',
        'stic_billing_address_region_c' => 'accounts_cstm.stic_billing_address_region_c',
        'billing_address_state' => 'accounts.billing_address_state',
        'billing_address_country' => 'accounts.billing_address_country',
        'campaign_name' => 'accounts.campaign_name',
        'stic_total_annual_donations_c' => 'accounts_cstm.stic_total_annual_donations_c',
        'parent_name' => 'accounts.parent_name',
    ),
    'searchInputs' => array(
        0 => 'name',
        7 => 'email',
        9 => 'stic_category_c',
        10 => 'stic_subcategory_c',
        11 => 'phone_alternate',
        12 => 'phone_office',
        13 => 'assigned_user_name',
        14 => 'created_by_name',
        15 => 'date_entered',
        16 => 'modified_by_name',
        17 => 'date_modified',
        18 => 'stic_relationship_type_c',
        19 => 'stic_identification_number_c',
        20 => 'stic_language_c',
        21 => 'stic_billing_address_type_c',
        22 => 'billing_address_street',
        23 => 'billing_address_postalcode',
        24 => 'billing_address_city',
        25 => 'stic_billing_address_county_c',
        26 => 'stic_billing_address_region_c',
        27 => 'billing_address_state',
        28 => 'billing_address_country',
        29 => 'campaign_name',
        30 => 'stic_total_annual_donations_c',
        31 => 'parent_name',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'stic_relationship_type_c' => array(
            'type' => 'multienum',
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
            'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'stic_relationship_type_c',
        ),
        'stic_category_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_CATEGORY',
            'width' => '10%',
            'name' => 'stic_category_c',
        ),
        'stic_subcategory_c' => array(
            'type' => 'dynamicenum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_SUBCATEGORY',
            'width' => '10%',
            'name' => 'stic_subcategory_c',
        ),
        'phone_alternate' => array(
            'type' => 'phone',
            'label' => 'LBL_PHONE_ALT',
            'width' => '10%',
            'name' => 'phone_alternate',
        ),
        'phone_office' => array(
            'type' => 'phone',
            'label' => 'LBL_PHONE_OFFICE',
            'width' => '10%',
            'name' => 'phone_office',
        ),
        'email' => array(
            'name' => 'email',
            'width' => '10%',
        ),
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'name' => 'assigned_user_name',
        ),
        'stic_identification_number_c' => array(
            'type' => 'varchar',
            'studio' => 'visible',
            'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
            'width' => '10%',
            'name' => 'stic_identification_number_c',
        ),
        'parent_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_MEMBER_OF',
            'id' => 'PARENT_ID',
            'width' => '10%',
            'name' => 'parent_name',
        ),
        'stic_language_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_LANGUAGE',
            'width' => '10%',
            'name' => 'stic_language_c',
        ),
        'stic_billing_address_type_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_BILLING_ADDRESS_TYPE',
            'width' => '10%',
            'name' => 'stic_billing_address_type_c',
        ),
        'billing_address_street' => array(
            'type' => 'varchar',
            'label' => 'LBL_BILLING_ADDRESS_STREET',
            'width' => '10%',
            'name' => 'billing_address_street',
        ),
        'billing_address_postalcode' => array(
            'type' => 'varchar',
            'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
            'width' => '10%',
            'name' => 'billing_address_postalcode',
        ),
        'billing_address_city' => array(
            'name' => 'billing_address_city',
            'width' => '10%',
        ),
        'stic_billing_address_county_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_BILLING_ADDRESS_COUNTY',
            'width' => '10%',
            'name' => 'stic_billing_address_county_c',
        ),
        'stic_billing_address_region_c' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_STIC_BILLING_ADDRESS_REGION',
            'width' => '10%',
            'name' => 'stic_billing_address_region_c',
        ),
        'billing_address_state' => array(
            'name' => 'billing_address_state',
            'width' => '10%',
        ),
        'billing_address_country' => array(
            'name' => 'billing_address_country',
            'width' => '10%',
        ),
        'campaign_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_CAMPAIGN',
            'id' => 'CAMPAIGN_ID',
            'width' => '10%',
            'name' => 'campaign_name',
        ),
        'stic_total_annual_donations_c' => array(
            'type' => 'decimal',
            'studio' => array(
                'editview' => false,
                'quickcreate' => false,
            ),
            'label' => 'LBL_STIC_TOTAL_ANNUAL_DONATIONS',
            'width' => '10%',
            'name' => 'stic_total_annual_donations_c',
        ),
        'created_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_CREATED',
            'id' => 'CREATED_BY',
            'width' => '10%',
            'name' => 'created_by_name',
        ),
        'date_entered' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'name' => 'date_entered',
        ),
        'modified_by_name' => array(
            'type' => 'relate',
            'link' => true,
            'label' => 'LBL_MODIFIED_NAME',
            'id' => 'MODIFIED_USER_ID',
            'width' => '10%',
            'name' => 'modified_by_name',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'name' => 'date_modified',
        ),
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '40%',
            'label' => 'LBL_LIST_ACCOUNT_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ),
        'STIC_ACRONYM_C' => array(
            'type' => 'varchar',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STIC_ACRONYM',
            'width' => '10%',
        ),
        'STIC_RELATIONSHIP_TYPE_C' => array(
            'type' => 'multienum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'stic_relationship_type_c',
        ),
        'STIC_CATEGORY_C' => array(
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STIC_CATEGORY',
            'width' => '10%',
            'name' => 'stic_category_c',
        ),
        'STIC_SUBCATEGORY_C' => array(
            'type' => 'dynamicenum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_STIC_SUBCATEGORY',
            'width' => '10%',
            'name' => 'stic_subcategory_c',
        ),
        'PHONE_OFFICE' => array(
            'type' => 'phone',
            'label' => 'LBL_PHONE_OFFICE',
            'width' => '10%',
            'default' => true,
            'name' => 'phone_office',
        ),
        'EMAIL1' => array(
            'type' => 'varchar',
            'studio' => array(
                'editField' => true,
                'searchview' => false,
            ),
            'label' => 'LBL_EMAIL',
            'width' => '10%',
            'default' => true,
            'name' => 'email1',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '2%',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'default' => true,
            'name' => 'assigned_user_name',
        ),
    ),
);
