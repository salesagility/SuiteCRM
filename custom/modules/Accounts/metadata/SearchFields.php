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
// created: 2020-06-12 17:22:51
$searchFields['Accounts'] = array(
    'name' => array(
        'query_type' => 'default',
    ),
    'address_street' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'billing_address_street',
            1 => 'shipping_address_street',
        ),
    ),
    'address_city' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'billing_address_city',
            1 => 'shipping_address_city',
        ),
        'vname' => 'LBL_CITY',
    ),
    'address_state' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'billing_address_state',
            1 => 'shipping_address_state',
        ),
        'vname' => 'LBL_STATE',
    ),
    'address_postalcode' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'billing_address_postalcode',
            1 => 'shipping_address_postalcode',
        ),
        'vname' => 'LBL_POSTAL_CODE',
    ),
    'address_country' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'billing_address_country',
            1 => 'shipping_address_country',
        ),
        'vname' => 'LBL_COUNTRY',
    ),
    'rating' => array(
        'query_type' => 'default',
    ),
    'phone' => array(
        'query_type' => 'default',
        'db_field' => array(
            0 => 'phone_office',
        ),
        'vname' => 'LBL_ANY_PHONE',
    ),
    'email' => array(
        'query_type' => 'default',
        'operator' => 'subquery',
        'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
        'db_field' => array(
            0 => 'id',
        ),
        'vname' => 'LBL_ANY_EMAIL',
    ),
    'website' => array(
        'query_type' => 'default',
    ),
    'employees' => array(
        'query_type' => 'default',
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
    'range_stic_total_annual_donations_c' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
    ),
    'start_range_stic_total_annual_donations_c' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
    ),
    'end_range_stic_total_annual_donations_c' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
    ),
    'favorites_only' => array(
        'query_type' => 'format',
        'operator' => 'subquery',
        'checked_only' => true,
        'subquery' => 'SELECT favorites.parent_id FROM favorites
                      WHERE favorites.deleted = 0
                          and favorites.parent_type = \'Accounts\'
                          and favorites.assigned_user_id = \'{1}\'',
        'db_field' => array(
            0 => 'id',
        ),
    ),
);
