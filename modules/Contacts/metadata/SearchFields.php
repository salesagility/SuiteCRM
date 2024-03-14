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

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105
// $searchFields['Contacts'] =
//     array(
//         'first_name' => array('query_type' => 'default'),
//         'last_name' => array('query_type' => 'default'),
//         'search_name' => array(
//             'query_type' => 'default',
//             'db_field' => array('first_name', 'last_name'),
//             'force_unifiedsearch' => true
//         ),
//         'account_name' => array('query_type' => 'default', 'db_field' => array('accounts.name')),
//         'lead_source' => array(
//             'query_type' => 'default',
//             'operator' => '=',
//             'options' => 'lead_source_dom',
//             'template_var' => 'LEAD_SOURCE_OPTIONS'
//         ),
//         'do_not_call' => array('query_type' => 'default', 'input_type' => 'checkbox', 'operator' => '='),
//         'phone' => array(
//             'query_type' => 'default',
//             'db_field' => array('phone_mobile', 'phone_work', 'phone_other', 'phone_fax', 'assistant_phone', 'phone_home')
//         ),
//         'email' => array(
//             'query_type' => 'default',
//             'operator' => 'subquery',
//             'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
//             'db_field' => array(
//                 'id',
//             ),
//         ),
//         'optinprimary' =>
//             array(
//                 'type' => 'enum',
//                 'options' => 'email_confirmed_opt_in_dom',
//                 'query_type' => 'default',
//                 'operator' => 'subquery',
//                 'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND eabr.primary_address = \'1\' AND ea.confirm_opt_in LIKE',
//                 'db_field' =>
//                     array(
//                         0 => 'id',
//                     ),
//                 'vname' => 'LBL_OPT_IN_FLAG_PRIMARY',
//             ),
//         'favorites_only' => array(
//             'query_type' => 'format',
//             'operator' => 'subquery',
//             'checked_only' => true,
//             'subquery' => "SELECT favorites.parent_id FROM favorites
// 			                    WHERE favorites.deleted = 0
// 			                        and favorites.parent_type = 'Contacts'
// 			                        and favorites.assigned_user_id = '{1}'",
//             'db_field' => array('id')
//         ),
//         'assistant' => array('query_type' => 'default'),
//         'address_street' => array(
//             'query_type' => 'default',
//             'db_field' => array('primary_address_street', 'alt_address_street')
//         ),
//         'address_city' => array(
//             'query_type' => 'default',
//             'db_field' => array('primary_address_city', 'alt_address_city')
//         ),
//         'address_state' => array(
//             'query_type' => 'default',
//             'db_field' => array('primary_address_state', 'alt_address_state')
//         ),
//         'address_postalcode' => array(
//             'query_type' => 'default',
//             'db_field' => array('primary_address_postalcode', 'alt_address_postalcode')
//         ),
//         'address_country' => array(
//             'query_type' => 'default',
//             'db_field' => array('primary_address_country', 'alt_address_country')
//         ),
//         'current_user_only' => array(
//             'query_type' => 'default',
//             'db_field' => array('assigned_user_id'),
//             'my_items' => true,
//             'vname' => 'LBL_CURRENT_USER_FILTER',
//             'type' => 'bool'
//         ),
//         'assigned_user_id' => array('query_type' => 'default'),
//         'account_id' => array('query_type' => 'default', 'db_field' => array('accounts.id')),
//         'campaign_name' => array('query_type' => 'default'),
//         //Range Search Support
//         'range_date_entered' => array(
//             'query_type' => 'default',
//             'enable_range_search' => true,
//             'is_date_field' => true
//         ),
//         'start_range_date_entered' => array(
//             'query_type' => 'default',
//             'enable_range_search' => true,
//             'is_date_field' => true
//         ),
//         'end_range_date_entered' => array(
//             'query_type' => 'default',
//             'enable_range_search' => true,
//             'is_date_field' => true
//         ),
//         'range_date_modified' => array(
//             'query_type' => 'default',
//             'enable_range_search' => true,
//             'is_date_field' => true
//         ),
//         'start_range_date_modified' => array(
//             'query_type' => 'default',
//             'enable_range_search' => true,
//             'is_date_field' => true
//         ),
//         'end_range_date_modified' => array(
//             'query_type' => 'default',
//             'enable_range_search' => true,
//             'is_date_field' => true
//         ),
//         //Range Search Support
//     );

$searchFields['Contacts'] = array (
    'first_name' => 
    array (
      'query_type' => 'default',
    ),
    'last_name' => 
    array (
      'query_type' => 'default',
    ),
    'search_name' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'first_name',
        1 => 'last_name',
      ),
      'force_unifiedsearch' => true,
    ),
    'account_name' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'accounts.name',
      ),
    ),
    'lead_source' => 
    array (
      'query_type' => 'default',
      'operator' => '=',
      'options' => 'lead_source_dom',
      'template_var' => 'LEAD_SOURCE_OPTIONS',
    ),
    'do_not_call' => 
    array (
      'query_type' => 'default',
      'input_type' => 'checkbox',
      'operator' => '=',
    ),
    'phone' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'phone_mobile',
        1 => 'phone_work',
        2 => 'phone_other',
        3 => 'phone_fax',
        4 => 'assistant_phone',
        5 => 'phone_home',
      ),
    ),
    'email' => 
    array (
      'query_type' => 'default',
      'operator' => 'subquery',
      'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
      'db_field' => 
      array (
        0 => 'id',
      ),
    ),
    'optinprimary' => 
    array (
      'type' => 'enum',
      'options' => 'email_confirmed_opt_in_dom',
      'query_type' => 'default',
      'operator' => 'subquery',
      'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND eabr.primary_address = \'1\' AND ea.confirm_opt_in LIKE',
      'db_field' => 
      array (
        0 => 'id',
      ),
      'vname' => 'LBL_OPT_IN_FLAG_PRIMARY',
    ),
    'favorites_only' => 
    array (
      'query_type' => 'format',
      'operator' => 'subquery',
      'checked_only' => true,
      'subquery' => 'SELECT favorites.parent_id FROM favorites
                                  WHERE favorites.deleted = 0
                                      and favorites.parent_type = \'Contacts\'
                                      and favorites.assigned_user_id = \'{1}\'',
      'db_field' => 
      array (
        0 => 'id',
      ),
    ),
    'assistant' => 
    array (
      'query_type' => 'default',
    ),
    'address_street' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'primary_address_street',
        1 => 'alt_address_street',
      ),
    ),
    'address_city' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'primary_address_city',
        1 => 'alt_address_city',
      ),
    ),
    'address_state' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'primary_address_state',
        1 => 'alt_address_state',
      ),
    ),
    'address_postalcode' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'primary_address_postalcode',
        1 => 'alt_address_postalcode',
      ),
    ),
    'address_country' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'primary_address_country',
        1 => 'alt_address_country',
      ),
    ),
    'current_user_only' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'assigned_user_id',
      ),
      'my_items' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
      'type' => 'bool',
    ),
    'assigned_user_id' => 
    array (
      'query_type' => 'default',
    ),
    'account_id' => 
    array (
      'query_type' => 'default',
      'db_field' => 
      array (
        0 => 'accounts.id',
      ),
    ),
    'campaign_name' => 
    array (
      'query_type' => 'default',
    ),
    'range_date_entered' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_date_entered' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_date_entered' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_date_modified' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_date_modified' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_date_modified' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_age_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'start_range_stic_age_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'end_range_stic_age_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'range_birthdate' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_birthdate' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_birthdate' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_date_reviewed' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'start_range_date_reviewed' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'end_range_date_reviewed' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
      'is_date_field' => true,
    ),
    'range_stic_total_annual_donations_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'start_range_stic_total_annual_donations_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
    'end_range_stic_total_annual_donations_c' => 
    array (
      'query_type' => 'default',
      'enable_range_search' => true,
    ),
);
// END STIC-Custom 