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
// $searchdefs ['Leads'] =
//     array(
//         'layout' =>
//             array(
//                 'basic_search' =>
//                     array(
//                         0 =>
//                             array(
//                                 'name' => 'search_name',
//                                 'label' => 'LBL_NAME',
//                                 'type' => 'name',
//                             ),
//                         1 =>
//                             array(
//                                 'name' => 'current_user_only',
//                                 'label' => 'LBL_CURRENT_USER_FILTER',
//                                 'type' => 'bool',
//                             ),
//                         array(
//                             'name' => 'open_only',
//                             'label' => 'LBL_OPEN_ITEMS',
//                             'type' => 'bool',
//                             'default' => false,
//                             'width' => '10%'
//                         ),
//                         array('name' => 'favorites_only', 'label' => 'LBL_FAVORITES_FILTER', 'type' => 'bool',),
//                     ),
//                 'advanced_search' =>
//                     array(
//                         'first_name' =>
//                             array(
//                                 'name' => 'first_name',
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
//                         'phone' =>
//                             array(
//                                 'name' => 'phone',
//                                 'label' => 'LBL_ANY_PHONE',
//                                 'type' => 'name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'last_name' =>
//                             array(
//                                 'name' => 'last_name',
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
//                         'account_name' =>
//                             array(
//                                 'name' => 'account_name',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'primary_address_country' =>
//                             array(
//                                 'name' => 'primary_address_country',
//                                 'label' => 'LBL_COUNTRY',
//                                 'type' => 'name',
//                                 'options' => 'countries_dom',
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
//                         'status' =>
//                             array(
//                                 'name' => 'status',
//                                 'default' => true,
//                                 'width' => '10%',
//                             ),
//                         'lead_source' =>
//                             array(
//                                 'name' => 'lead_source',
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
//     );

$searchdefs['Leads'] =
array(
    'layout' => array(
        'basic_search' => array(
            'search_name' => array(
                'name' => 'search_name',
                'label' => 'LBL_NAME',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'status' => array(
                'name' => 'status',
                'default' => true,
                'width' => '10%',
            ),
            'email' => array(
                'name' => 'email',
                'label' => 'LBL_ANY_EMAIL',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'phone_mobile' => array(
                'type' => 'phone',
                'label' => 'LBL_MOBILE_PHONE',
                'width' => '10%',
                'default' => true,
                'name' => 'phone_mobile',
            ),
            'phone_home' => array(
                'type' => 'phone',
                'label' => 'LBL_HOME_PHONE',
                'width' => '10%',
                'default' => true,
                'name' => 'phone_home',
            ),
            'assigned_user_id' => array(
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
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'first_name' => array(
                'name' => 'first_name',
                'default' => true,
                'width' => '10%',
            ),
            'last_name' => array(
                'name' => 'last_name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_identification_type_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_IDENTIFICATION_TYPE',
                'width' => '10%',
                'name' => 'stic_identification_type_c',
            ),
            'stic_identification_number_c' => array(
                'studio' => 'visible',
                'type' => 'varchar',
                'default' => true,
                'label' => 'LBL_STIC_IDENTIFICATION_NUMBER',
                'width' => '10%',
                'name' => 'stic_identification_number_c',
            ),
            'status' => array(
                'name' => 'status',
                'default' => true,
                'width' => '10%',
            ),
            'phone' => array(
                'name' => 'phone',
                'label' => 'LBL_ANY_PHONE',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'email' => array(
                'name' => 'email',
                'label' => 'LBL_ANY_EMAIL',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'assigned_user_id' => array(
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
            'stic_gender_c' => array(
                'studio' => 'visible',
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_STIC_GENDER',
                'width' => '10%',
                'name' => 'stic_gender_c',
            ),
            'stic_language_c' => array(
                'studio' => 'visible',
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_STIC_LANGUAGE',
                'width' => '10%',
                'name' => 'stic_language_c',
            ),
            'stic_referral_agent_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_REFERRAL_AGENT',
                'width' => '10%',
                'name' => 'stic_referral_agent_c',
            ),
            'stic_acquisition_channel_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_ACQUISITION_CHANNEL',
                'width' => '10%',
                'name' => 'stic_acquisition_channel_c',
            ),
            'birthdate' => array(
                'type' => 'date',
                'label' => 'LBL_BIRTHDATE',
                'width' => '10%',
                'default' => true,
                'name' => 'birthdate',
            ),
            'lead_source' => array(
                'name' => 'lead_source',
                'default' => true,
                'width' => '10%',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'account_name' => array(
                'name' => 'account_name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_employment_status_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_EMPLOYMENT_STATUS',
                'width' => '10%',
                'name' => 'stic_employment_status_c',
            ),
            'stic_professional_sector_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_PROFESSIONAL_SECTOR',
                'width' => '10%',
                'name' => 'stic_professional_sector_c',
            ),
            'stic_professional_sector_other_c' => array(
                'type' => 'varchar',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_PROFESSIONAL_SECTOR_OTHER',
                'width' => '10%',
                'name' => 'stic_professional_sector_other_c',
            ),
            'title' => array(
                'type' => 'varchar',
                'label' => 'LBL_TITLE',
                'width' => '10%',
                'default' => true,
                'name' => 'title',
            ),
            'department' => array(
                'type' => 'varchar',
                'label' => 'LBL_DEPARTMENT',
                'width' => '10%',
                'default' => true,
                'name' => 'department',
            ),
            'primary_address_postalcode' => array(
                'type' => 'varchar',
                'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                'width' => '10%',
                'default' => true,
                'name' => 'primary_address_postalcode',
            ),
            'stic_primary_address_type_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_PRIMARY_ADDRESS_TYPE',
                'width' => '10%',
                'name' => 'stic_primary_address_type_c',
            ),
            'address_street' => array(
                'name' => 'address_street',
                'label' => 'LBL_ANY_ADDRESS',
                'type' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'stic_primary_address_county_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_PRIMARY_ADDRESS_COUNTY',
                'width' => '10%',
                'name' => 'stic_primary_address_county_c',
            ),
            'primary_address_state' => array(
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                'width' => '10%',
                'name' => 'primary_address_state',
            ),
            'stic_primary_address_region_c' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_STIC_PRIMARY_ADDRESS_REGION',
                'width' => '10%',
                'name' => 'stic_primary_address_region_c',
            ),
            'primary_address_country' => array(
                'name' => 'primary_address_country',
                'label' => 'LBL_COUNTRY',
                'type' => 'name',
                'options' => 'countries_dom',
                'default' => true,
                'width' => '10%',
            ),
            'stic_do_not_send_postal_mail_c' => array(
                'default' => true,
                'studio' => 'visible',
                'type' => 'bool',
                'label' => 'LBL_STIC_DO_NOT_SEND_POSTAL_MAIL',
                'width' => '10%',
                'name' => 'stic_do_not_send_postal_mail_c',
            ),
            'do_not_call' => array(
                'type' => 'bool',
                'default' => true,
                'label' => 'LBL_DO_NOT_CALL',
                'width' => '10%',
                'name' => 'do_not_call',
            ),
            'stic_postal_mail_return_reason_c' => array(
                'type' => 'enum',
                'default' => true,
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
                'default' => true,
                'name' => 'campaign_name',
            ),
            'lawful_basis' => array(
                'type' => 'multienum',
                'label' => 'LBL_LAWFUL_BASIS',
                'width' => '10%',
                'default' => true,
                'name' => 'lawful_basis',
            ),
            'lawful_basis_source' => array(
                'type' => 'enum',
                'label' => 'LBL_LAWFUL_BASIS_SOURCE',
                'width' => '10%',
                'default' => true,
                'name' => 'lawful_basis_source',
            ),
            'date_reviewed' => array(
                'type' => 'date',
                'label' => 'LBL_DATE_REVIEWED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_reviewed',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
// END STIC-Custom

if ($configurator->isConfirmOptInEnabled() || $configurator->isOptInEnabled()) {
    $searchdefs['Leads']['layout']['advanced_search']['optinprimary'] =
        array(
            'name' => 'optinprimary',
            'label' => 'LBL_OPT_IN_FLAG_PRIMARY',
            'type' => 'enum',
            'options' => $app_list_strings['email_confirmed_opt_in_dom'],
            'default' => true,
            'width' => '10%',
        );
}
