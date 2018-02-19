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

$dictionary['OAuth2Tokens'] = [
    'table' => 'oauth2tokens',
    'audited' => false,
    'comment' => 'Provides tokens for security services',
    'fields' => [
        'id' => [
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
            'inline_edit' => false,
        ],
        'token_is_revoked' => [
            'name' => 'token_is_revoked',
            'vname' => 'LBL_TOKEN_IS_REVOKED',
            'type' => 'bool',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
        ],
        'token_type' => [
            'name' => 'token_type',
            'vname' => 'LBL_ACCESS_TOKEN_TYPE',
            'type' => 'varchar',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
            'inline_edit' => false,
        ],
        'access_token_expires' => [
            'name' => 'access_token_expires',
            'vname' => 'LBL_ACCESS_TOKEN_EXPIRES',
            'type' => 'datetime',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
            'inline_edit' => false,
        ],
        'access_token' => [
            'name' => 'access_token',
            'vname' => 'LBL_ACCESS_TOKEN',
            'type' => 'varchar',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
            'len' => '4000',
            'inline_edit' => false,
        ],
        'refresh_token' => [
            'name' => 'refresh_token',
            'vname' => 'LBL_REFRESH_TOKEN',
            'type' => 'varchar',
            'required' => false,
            'reportable' => false,
            'api-visible' => false,
            'len' => '4000',
            'inline_edit' => false,
        ],
        'refresh_token_expires' => [
            'name' => 'refresh_token_expires',
            'vname' => 'LBL_REFRESH_TOKEN_EXPIRES',
            'type' => 'datetime',
            'required' => false,
            'reportable' => false,
            'api-visible' => false,
            'inline_edit' => false,
        ],
        'grant_type' => [
            'name' => 'grant_type',
            'vname' => 'LBL_GRANT_TYPE',
            'type' => 'enum',
            'options' => 'oauth_grant_type_dom',
            'default' => 'Password Grant',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
            'inline_edit' => false,
        ],
        'state' => [
            'name' => 'state',
            'vname' => 'LBL_STATE',
            'type' => 'varchar',
            'required' => false,
            'reportable' => false,
            'api-visible' => false,
            'len' => '1024',
            'inline_edit' => false,
        ],
        'client' => [
            'name' => 'client',
            'vname' => 'LBL_CLIENT',
            'type' => 'varchar',
            'required' => true,
            'reportable' => false,
            'api-visible' => false,
            'len' => '1024',
            'inline_edit' => false,
        ],
    ],
    'optimistic_locking' => true,
];
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef(
    'OAuth2Tokens',
    'OAuth2Tokens',
    [
        'default',

    ]
);
