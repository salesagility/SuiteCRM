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
// created: 2020-05-06 14:43:01
$searchFields['Leads'] = array(
    'first_name' => array(
        'query_type' => 'default',
    ),
    'last_name' => array(
        'query_type' => 'default',
    ),
    'search_name' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'first_name',
            1 => 'last_name',
        ),
        'force_unifiedsearch' => true,
    ),
    'account_name' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'leads.account_name',
        ),
    ),
    'lead_source' => array(
        'query_type' => 'default',
        'operator' => '=',
        'options' => 'lead_source_dom',
        'template_var' => 'LEAD_SOURCE_OPTIONS',
    ),
    'do_not_call' => array(
        'query_type' => 'default',
        'operator' => '=',
        'input_type' => 'checkbox',
    ),
    'phone' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'phone_mobile',
            1 => 'phone_work',
            2 => 'phone_other',
            3 => 'phone_fax',
            4 => 'phone_home',
        ),
    ),
    'email' => array(
        'query_type' => 'default',
        'operator' => 'subquery',
        'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
        'db_field' => array(
            0 => 'id',
        ),
    ),
    'optinprimary' => array(
        'type' => 'enum',
        'options' => 'email_confirmed_opt_in_dom',
        'query_type' => 'default',
        'operator' => 'subquery',
        'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND eabr.primary_address = \'1\' AND ea.confirm_opt_in LIKE',
        'db_field' => array(
            0 => 'id',
        ),
        'vname' => 'LBL_OPT_IN_FLAG_PRIMARY',
    ),
    'favorites_only' => array(
        'query_type' => 'format',
        'operator' => 'subquery',
        'checked_only' => true,
        'subquery' => 'SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = \'Leads\'
			                        and favorites.assigned_user_id = \'{1}\'',
        'db_field' => array(
            0 => 'id',
        ),
    ),
    'assistant' => array(
        'query_type' => 'default',
    ),
    'website' => array(
        'query_type' => 'default',
    ),
    'address_street' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'primary_address_street',
            1 => 'alt_address_street',
        ),
    ),
    'address_city' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'primary_address_city',
            1 => 'alt_address_city',
        ),
    ),
    'address_state' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'primary_address_state',
            1 => 'alt_address_state',
        ),
    ),
    'address_postalcode' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'primary_address_postalcode',
            1 => 'alt_address_postalcode',
        ),
    ),
    'address_country' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'primary_address_country',
            1 => 'alt_address_country',
        ),
    ),
    'current_user_only' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'assigned_user_id',
        ),
        'my_items' => true,
        'vname' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
    ),
    'assigned_user_id' => array(
        'query_type' => 'default',
    ),
    'status' => array(
        'query_type' => 'default',
        'options' => 'lead_status_dom',
        'template_var' => 'STATUS_OPTIONS',
    ),
    'open_only' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'status',
        ),
        'operator' => 'not in',
        'closed_values' => array(
            0 => 'Dead',
            1 => 'Recycled',
            2 => 'Converted',
        ),
        'type' => 'bool',
    ),
    'range_date_entered' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'start_range_date_entered' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'end_range_date_entered' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'range_date_modified' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'start_range_date_modified' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'end_range_date_modified' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'range_birthdate' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'start_range_birthdate' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'end_range_birthdate' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true,
    ),
    'favorites_only' => array(
        'query_type' => 'format',
        'operator' => 'subquery',
        'checked_only' => true,
        'subquery' => 'SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = \'Leads\'
			                        and favorites.assigned_user_id = \'{1}\'',
        'db_field' => array(
            0 => 'id',
        ),
    ),
);
