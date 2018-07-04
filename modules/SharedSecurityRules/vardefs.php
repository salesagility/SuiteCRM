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

$dictionary['SharedSecurityRules'] = array(
    'table' => 'sharedsecurityrules',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => array (
        'flow_module' =>
            array(
                'required' => true,
                'name' => 'flow_module',
                'vname' => 'LBL_FLOW_MODULE',
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
                'options' => 'sa_moduleList',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'status' =>
            array(
                'required' => false,
                'name' => 'status',
                'vname' => 'LBL_STATUS',
                'type' => 'enum',
                'massupdate' => 1,
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
                'options' => 'sa_status_list',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'run' =>
            array(
                'required' => false,
                'name' => 'run',
                'vname' => 'LBL_RUN_WHEN',
                'type' => 'enum',
                'massupdate' => 1,
                'default' => 'true',
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
                'options' => 'run_when_dom',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'condition_lines' =>
            array(
                'required' => false,
                'name' => 'condition_lines',
                'vname' => 'LBL_CONDITION_LINES',
                'type' => 'function',
                'source' => 'non-db',
                'massupdate' => 0,
                'importable' => 'false',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => 0,
                'audited' => false,
                'reportable' => false,
                'inline_edit' => false,
                'function' =>
                    array(
                        'name' => 'display_condition_lines',
                        'returns' => 'html',
                        'include' => 'modules/SharedSecurityRulesConditions/fieldsLines.php'
                    ),
            ),
        'action_lines' =>
            array(
                'required' => false,
                'name' => 'action_lines',
                'vname' => 'LBL_ACTION_LINES',
                'type' => 'function',
                'source' => 'non-db',
                'massupdate' => 0,
                'importable' => 'false',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => 0,
                'audited' => false,
                'reportable' => false,
                'inline_edit' => false,
                'function' =>
                    array(
                        'name' => 'display_action_lines',
                        'returns' => 'html',
                        'include' => 'modules/SharedSecurityRulesActions/actionLines.php'
                    ),
            ),
        'sharedsecurityrulesactions' =>
            array(
                'name' => 'sharedsecurityrulesactions',
                'type' => 'link',
                'relationship' => 'sharedsecurityrules_sharedsecurityrulesactions',
                'module' => 'SharedSecurityRulesActions',
                'bean_name' => 'sharedsecurityrulesactions',
                'source' => 'non-db',
            ),
        'sharedsecurityrulesconditions' =>
            array(
                'name' => 'sharedsecurityrulesconditions',
                'type' => 'link',
                'relationship' => 'sharedsecurityrules_sharedsecurityrulesconditions',
                'module' => 'SharedSecurityRulesConditions',
                'bean_name' => 'sharedsecurityrulesconditions',
                'source' => 'non-db',
            ),

),
    'relationships' => array (
        'sharedsecurityrules_sharedsecurityrulesactions' =>
            array(
                'lhs_module' => 'SharedSecurityRules',
                'lhs_table' => 'sharedsecurityrules',
                'lhs_key' => 'id',
                'rhs_module' => 'SharedSecurityRulesActions',
                'rhs_table' => 'sharedsecurityrulesactions',
                'rhs_key' => 'sa_shared_security_rules_id',
                'relationship_type' => 'one-to-many',
            ),
        'sharedsecurityrules_sharedsecurityrulesconditions' =>
            array(
                'lhs_module' => 'SharedSecurityRules',
                'lhs_table' => 'sharedsecurityrules',
                'lhs_key' => 'id',
                'rhs_module' => 'SharedSecurityRulesConditions',
                'rhs_table' => 'sharedsecurityrulesconditions',
                'rhs_key' => 'sa_shared_sec_rules_id',
                'relationship_type' => 'one-to-many',
            ),
),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('SharedSecurityRules', 'SharedSecurityRules', array('basic','assignable','security_groups'));