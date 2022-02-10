<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_name = '<module_name>';
$searchFields[$module_name] = array(
    'name' => array('query_type' => 'default'),
    'account_type' => array(
        'query_type' => 'default',
        'options' => 'account_type_dom',
        'template_var' => 'ACCOUNT_TYPE_OPTIONS'
    ),
    'industry' => array('query_type' => 'default', 'options' => 'industry_dom', 'template_var' => 'INDUSTRY_OPTIONS'),
    'annual_revenue' => array('query_type' => 'default'),
    'address_street' => array(
        'query_type' => 'default',
        'db_field' => array('billing_address_street', 'shipping_address_street')
    ),
    'address_city' => array(
        'query_type' => 'default',
        'db_field' => array('billing_address_city', 'shipping_address_city')
    ),
    'address_state' => array(
        'query_type' => 'default',
        'db_field' => array('billing_address_state', 'shipping_address_state')
    ),
    'address_postalcode' => array(
        'query_type' => 'default',
        'db_field' => array('billing_address_postalcode', 'shipping_address_postalcode')
    ),
    'address_country' => array(
        'query_type' => 'default',
        'db_field' => array('billing_address_country', 'shipping_address_country')
    ),
    'rating' => array('query_type' => 'default'),
    'phone' => array('query_type' => 'default', 'db_field' => array('phone_office')),
    'email' => array(
        'query_type' => 'default',
        'operator' => 'subquery',
        'subquery' => 'SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address LIKE',
        'db_field' => array(
            'id',
        ),
        'vname' => 'LBL_ANY_EMAIL',
    ),
    'website' => array('query_type' => 'default'),
    'ownership' => array('query_type' => 'default'),
    'employees' => array('query_type' => 'default'),
    'ticker_symbol' => array('query_type' => 'default'),
    'current_user_only' => array(
        'query_type' => 'default',
        'db_field' => array('assigned_user_id'),
        'my_items' => true,
        'vname' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool'
    ),
    'assigned_user_id' => array('query_type' => 'default'),

    //Range Search Support
    'range_date_entered' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
    'start_range_date_entered' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'end_range_date_entered' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'range_date_modified' => array('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
    'start_range_date_modified' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    'end_range_date_modified' => array(
        'query_type' => 'default',
        'enable_range_search' => true,
        'is_date_field' => true
    ),
    //Range Search Support
);
