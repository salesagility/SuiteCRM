<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
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
$popupMeta = [
    'moduleMain' => 'Account',
    'varName' => 'ACCOUNT',
    'orderBy' => 'name',
    'whereClauses' => [
        'name' => 'accounts.name',
        'billing_address_city' => 'accounts.billing_address_city',
        'account_type' => 'accounts.account_type',
        'industry' => 'accounts.industry',
        'billing_address_state' => 'accounts.billing_address_state',
        'billing_address_country' => 'accounts.billing_address_country',
        'email' => 'accounts.email',
        'assigned_user_id' => 'accounts.assigned_user_id',
    ],
    'searchInputs' => [
        0 => 'name',
        1 => 'billing_address_city',
        3 => 'account_type',
        4 => 'industry',
        5 => 'billing_address_state',
        6 => 'billing_address_country',
        7 => 'email',
        8 => 'assigned_user_id',
    ],
    'create' => [
        'formBase' => 'AccountFormBase.php',
        'formBaseClass' => 'AccountFormBase',
        'getFormBodyParams' => [
            0 => '',
            1 => '',
            2 => 'AccountSave',
        ],
        'createButton' => 'LNK_NEW_ACCOUNT',
    ],
    'searchdefs' => [
        'name' => [
            'name' => 'name',
            'width' => '10%',
        ],
        'account_type' => [
            'type' => 'enum',
            'label' => 'LBL_TYPE',
            'width' => '10%',
            'name' => 'account_type',
        ],
        'industry' => [
            'type' => 'enum',
            'label' => 'LBL_INDUSTRY',
            'width' => '10%',
            'name' => 'industry',
        ],
        'billing_address_city' => [
            'name' => 'billing_address_city',
            'width' => '10%',
        ],
        'billing_address_state' => [
            'name' => 'billing_address_state',
            'width' => '10%',
        ],
        'billing_address_country' => [
            'name' => 'billing_address_country',
            'width' => '10%',
        ],
        'email' => [
            'name' => 'email',
            'width' => '10%',
        ],
        'assigned_user_id' => [
            'name' => 'assigned_user_id',
            'label' => 'LBL_ASSIGNED_TO',
            'type' => 'enum',
            'function' => [
                'name' => 'get_user_array',
                'params' => [
                    0 => false,
                ],
            ],
            'width' => '10%',
        ],
    ],
    'listviewdefs' => [
        'NAME' => [
            'width' => '40%',
            'label' => 'LBL_LIST_ACCOUNT_NAME',
            'link' => true,
            'default' => true,
            'name' => 'name',
        ],
        'ACCOUNT_TYPE' => [
            'type' => 'enum',
            'label' => 'LBL_TYPE',
            'width' => '10%',
            'default' => true,
            'name' => 'account_type',
        ],
        'BILLING_ADDRESS_CITY' => [
            'width' => '10%',
            'label' => 'LBL_LIST_CITY',
            'default' => true,
            'name' => 'billing_address_city',
        ],
        'BILLING_ADDRESS_STATE' => [
            'width' => '7%',
            'label' => 'LBL_STATE',
            'default' => true,
            'name' => 'billing_address_state',
        ],
        'BILLING_ADDRESS_COUNTRY' => [
            'width' => '10%',
            'label' => 'LBL_COUNTRY',
            'default' => true,
            'name' => 'billing_address_country',
        ],
        'ASSIGNED_USER_NAME' => [
            'width' => '2%',
            'label' => 'LBL_LIST_ASSIGNED_USER',
            'default' => true,
            'name' => 'assigned_user_name',
        ],
    ],
];
