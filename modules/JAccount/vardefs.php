<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$dictionary['JAccount'] = array(
    'table' => 'jaccount',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array (
        'contact_id' =>
            array(
                'required' => false,
                'name' => 'contact_id',
                'vname' => 'LBL_AUTHOR_USER_ID',
                'type' => 'id',
                'massupdate' => 0,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => 0,
                'audited' => false,
                'reportable' => false,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => 36,
                'size' => '20',
            ),
        'email1' =>
            array(
                'name' => 'email1',
                'vname' => 'LBL_JOOMLA_EMAIL1',
                'type' => 'varchar',
                'len' => '255',
                'importable' => 'false',
                'studio' => 'true',
            ),
        'portal_url' =>
            array(
                'name' => 'portal_url',
                'vname' => 'LBL_JOOMLA_EMAIL1',
                'type' => 'varchar',
                'len' => '255',
                'importable' => 'false',
                'studio' => 'true',
            ),

        'joomla_account_id' =>
            array(
                'name' => 'joomla_account_id',
                'vname' => 'LBL_JOOMLA_ACCOUNT_ID',
                'type' => 'varchar',
                'len' => '255',
                'importable' => 'false',
                'studio' => 'true',
            ),
        'portal_account_disabled' =>
            array(
                'name' => 'portal_account_disabled',
                'vname' => 'LBL_PORTAL_ACCOUNT_DISABLED',
                'type' => 'bool',
                'importable' => 'false',
                'studio' => 'false',
            ),
        'joomla_account_access' =>
            array(
                'name' => 'joomla_account_access',
                'vname' => 'LBL_JOOMLA_ACCOUNT_ACCESS',
                'type' => 'varchar',
                'source' => 'non-db',
                'len' => '255',
                'importable' => 'false',
                'studio' => 'false',
            ),
        'portal_user_type' =>
            array(
                'name' => 'portal_user_type',
                'vname' => 'LBL_PORTAL_USER_TYPE',
                'type' => 'enum',
                'options' => 'contact_portal_user_type_dom',
                'len' => '100',
                'default' => 'Single',
            ),
),
    'indices' => array(
        array(
            'name' => 'idx_unique_jaccount',
            'type' => 'unique',
            'fields' => array('contact_id', 'portal_url', 'deleted')
        ),
    ),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('JAccount', 'JAccount', array('basic','assignable','security_groups'));
