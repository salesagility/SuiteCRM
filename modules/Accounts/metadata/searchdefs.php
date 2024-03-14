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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


global $app_list_strings;
$configurator = new Configurator();

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105

// $searchdefs ['Accounts'] =
//     array(
//         'templateMeta' =>
//             array(
//                 'maxColumns' => '3',
//                 'maxColumnsBasic' => '4',
//                 'widths' =>
//                     array(
//                         'label' => '10',
//                         'field' => '30',
//                     ),
//             ),
//         'layout' =>
//             array(
//                 'basic_search' =>
//                     array(
//                         'name' =>
//                             array(
//                                 'name' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'current_user_only' =>
//                             array(
//                                 'name' => 'current_user_only',
//                                 'label' => 'LBL_CURRENT_USER_FILTER',
//                                 'type' => 'bool',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'favorites_only' => array(
//                             'name' => 'favorites_only',
//                             'label' => 'LBL_FAVORITES_FILTER',
//                             'type' => 'bool',
//                         ),
//                     ),
//                 'advanced_search' =>
//                     array(
//                         'name' =>
//                             array(
//                                 'name' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'website' =>
//                             array(
//                                 'name' => 'website',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'phone' =>
//                             array(
//                                 'name' => 'phone',
//                                 'label' => 'LBL_ANY_PHONE',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'email' =>
//                             array(
//                                 'name' => 'email',
//                                 'label' => 'LBL_ANY_EMAIL',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'address_street' =>
//                             array(
//                                 'name' => 'address_street',
//                                 'label' => 'LBL_ANY_ADDRESS',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'address_city' =>
//                             array(
//                                 'name' => 'address_city',
//                                 'label' => 'LBL_CITY',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'address_state' =>
//                             array(
//                                 'name' => 'address_state',
//                                 'label' => 'LBL_STATE',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'address_postalcode' =>
//                             array(
//                                 'name' => 'address_postalcode',
//                                 'label' => 'LBL_POSTAL_CODE',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'billing_address_country' =>
//                             array(
//                                 'name' => 'billing_address_country',
//                                 'label' => 'LBL_COUNTRY',
//                                 'type' => 'name',
//                                 'options' => 'countries_dom',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'account_type' =>
//                             array(
//                                 'name' => 'account_type',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'industry' =>
//                             array(
//                                 'name' => 'industry',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'assigned_user_id' =>
//                             array(
//                                 'name' => 'assigned_user_id',
//                                 'type' => 'enum',
//                                 'label' => 'LBL_ASSIGNED_TO',
//                                 'function' =>
//                                     array(
//                                         'name' => 'get_user_array',
//                                         'params' =>
//                                             array(
//                                                 0 => false,
//                                             ),
//                                     ),
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                     ),
//             ),
//     );

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
// END STIC-Custom

if ($configurator->isConfirmOptInEnabled() || $configurator->isOptInEnabled()) {
    $searchdefs['Accounts']['layout']['advanced_search']['optinprimary'] =
        array(
            'name' => 'optinprimary',
            'label' => 'LBL_OPT_IN_FLAG_PRIMARY',
            'type' => 'enum',
            'options' => $app_list_strings['email_confirmed_opt_in_dom'],
            'default' => true,
            'width' => '10%',
        );
}