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

$dictionary['SharedSecurityRulesConditions'] = array(
    'table' => 'sharedsecurityrulesconditions',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array (
        'sa_shared_sec_rules_id' =>
            array (
                'required' => false,
                'name' => 'sa_shared_sec_rules_id',
                'vname' => 'LBL_SHARED_SEC_GROUP_ID',
                'type' => 'id',
                'massupdate' => 0,
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
        'condition_order' =>
            array (
                'required' => false,
                'name' => 'condition_order',
                'vname' => 'LBL_ORDER',
                'type' => 'int',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '255',
                'size' => '20',
                'enable_range_search' => false,
                'disable_num_format' => '',
            ),

        'logic_op' => array(
            'name' => 'logic_op',
            'vname' => 'LBL_LOGIC_OP',
            'type' => 'varchar',
            'default_value' => 'AND',
        ),
        'parenthesis' => array(
            'name' => 'parenthesis',
            'vname' => 'LBL_PARENTHESIS',
            'type' => 'varchar',
        ),

        'module_path' =>
            array (
                'name' => 'module_path',
                'type' => 'longtext',
                'vname' => 'LBL_MODULE_PATH',
                'isnull' => true,
            ),
        'field' =>
            array (
                'required' => false,
                'name' => 'field',
                'vname' => 'LBL_FIELD',
                'type' => 'enum',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => 100,
                'size' => '20',
                'options' => 'user_type_dom',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'operator' =>
            array (
                'required' => false,
                'name' => 'operator',
                'vname' => 'LBL_OPERATOR',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => '',
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => 100,
                'size' => '20',
                'options' => 'aow_operator_list',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'condition_operator' =>
            array (
                'required' => false,
                'name' => 'condition_operator',
                'vname' => 'LBL_OPERATOR',
                'type' => 'varchar',
                'massupdate' => 0,
                'default' => '',
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => 100,
                'size' => '20',
                'options' => '',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'value_type' =>
            array (
                'required' => false,
                'name' => 'value_type',
                'vname' => 'LBL_VALUE_TYPE',
                'type' => 'varchar',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '255',
                'size' => '20',
            ),
        'value' =>
            array (
                'required' => false,
                'name' => 'value',
                'vname' => 'LBL_VALUE',
                'type' => 'varchar',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '255',
                'size' => '20',
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
VardefManager::createVardef('SharedSecurityRulesConditions', 'SharedSecurityRulesConditions', array('basic','assignable','security_groups'));