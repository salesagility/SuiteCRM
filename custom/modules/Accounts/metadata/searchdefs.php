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
$searchdefs['Accounts'] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
    'layout' => array(
        'basic_search' => array(
            0 => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            1 => array(
                'type' => 'multienum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
                'width' => '10%',
                'name' => 'stic_relationship_type_c',
            ),
            2 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_CATEGORY',
                'width' => '10%',
                'name' => 'stic_category_c',
            ),
            3 => array(
                'type' => 'dynamicenum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_SUBCATEGORY',
                'width' => '10%',
                'name' => 'stic_subcategory_c',
            ),
            4 => array(
                'name' => 'phone',
                'label' => 'LBL_ANY_PHONE',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            5 => array(
                'type' => 'name',
                'studio' => array(
                    'visible' => false,
                    'searchview' => true,
                ),
                'label' => 'LBL_ANY_EMAIL',
                'name' => 'email',
                'default' => true,
                'width' => '10%',
            ),
            6 => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            7 => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            8 => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'width' => '10%',
                'default' => true,
            ),
        ),
        'advanced_search' => array(
            0 => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            1 => array(
                'type' => 'multienum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_RELATIONSHIP_TYPE',
                'width' => '10%',
                'name' => 'stic_relationship_type_c',
            ),
            2 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_CATEGORY',
                'width' => '10%',
                'name' => 'stic_category_c',
            ),
            3 => array(
                'type' => 'dynamicenum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_SUBCATEGORY',
                'width' => '10%',
                'name' => 'stic_subcategory_c',
            ),
            4 => array(
                'name' => 'phone',
                'label' => 'LBL_ANY_PHONE',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            5 => array(
                'name' => 'email',
                'label' => 'LBL_ANY_EMAIL',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            6 => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            7 => array(
                'type' => 'varchar',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_ACRONYM',
                'width' => '10%',
                'name' => 'stic_acronym_c',
            ),
            8 => array(
                'type' => 'varchar',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
                'width' => '10%',
                'name' => 'stic_identification_number_c',
            ),
            9 => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_MEMBER_OF',
                'id' => 'PARENT_ID',
                'width' => '10%',
                'default' => true,
                'name' => 'parent_name',
            ),
            10 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_LANGUAGE',
                'width' => '10%',
                'name' => 'stic_language_c',
            ),
            11 => array(
                'name' => 'website',
                'default' => true,
                'width' => '10%',
            ),
            12 => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_CAMPAIGN',
                'id' => 'CAMPAIGN_ID',
                'width' => '10%',
                'default' => true,
                'name' => 'campaign_name',
            ),
            13 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_BILLING_ADDRESS_TYPE',
                'width' => '10%',
                'name' => 'stic_billing_address_type_c',
            ),
            14 => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_STREET',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_street',
            ),
            15 => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_postalcode',
            ),
            16 => array(
                'type' => 'varchar',
                'label' => 'LBL_BILLING_ADDRESS_CITY',
                'width' => '10%',
                'default' => true,
                'name' => 'billing_address_city',
            ),
            17 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_BILLING_ADDRESS_COUNTY',
                'width' => '10%',
                'name' => 'stic_billing_address_county_c',
            ),
            18 => array(
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_BILLING_ADDRESS_STATE',
                'width' => '10%',
                'name' => 'billing_address_state',
            ),
            19 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_BILLING_ADDRESS_REGION',
                'width' => '10%',
                'name' => 'stic_billing_address_region_c',
            ),
            20 => array(
                'name' => 'billing_address_country',
                'label' => 'LBL_COUNTRY',
                'type' => 'name',
                'options' => 'countries_dom',
                'default' => true,
                'width' => '10%',
            ),
            21 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_SHIPPING_ADDRESS_TYPE',
                'width' => '10%',
                'name' => 'stic_shipping_address_type_c',
            ),
            22 => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_STREET',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_street',
            ),
            23 => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_postalcode',
            ),
            24 => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_CITY',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_city',
            ),
            25 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_SHIPPING_ADDRESS_COUNTY',
                'width' => '10%',
                'name' => 'stic_shipping_address_county_c',
            ),
            26 => array(
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_SHIPPING_ADDRESS_STATE',
                'width' => '10%',
                'name' => 'shipping_address_state',
            ),
            27 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_SHIPPING_ADDRESS_REGION',
                'width' => '10%',
                'name' => 'stic_shipping_address_region_c',
            ),
            28 => array(
                'type' => 'varchar',
                'label' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                'width' => '10%',
                'default' => true,
                'name' => 'shipping_address_country',
            ),
            29 => array(
                'type' => 'varchar',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_TAX_NAME',
                'width' => '10%',
                'name' => 'stic_tax_name_c',
            ),
            30 => array(
                'type' => 'decimal',
                'default' => true,
                'label' => 'LBL_STIC_TOTAL_ANNUAL_DONATIONS',
                'width' => '10%',
                'name' => 'stic_total_annual_donations_c',
            ),
            31 => array(
                'type' => 'bool',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_182_EXCLUDED',
                'width' => '10%',
                'name' => 'stic_182_excluded_c',
            ),
            32 => array(
                'type' => 'bool',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_182_ERROR',
                'width' => '10%',
                'name' => 'stic_182_error_c',
            ),
            33 => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_POSTAL_MAIL_RETURN_REASON',
                'width' => '10%',
                'name' => 'stic_postal_mail_return_reason_c',
            ),
            34 => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            35 => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            36 => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            37 => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            38 => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            39 => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            40 => array(
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'width' => '10%',
                'default' => true,
                'name' => 'favorites_only',
            ),
        ),
    ),
);