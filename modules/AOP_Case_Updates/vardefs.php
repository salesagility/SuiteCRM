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

$dictionary['AOP_Case_Updates'] = array(
    'table' => 'aop_case_updates',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'case' => array(
            'name' => 'case',
            'type' => 'link',
            'relationship' => 'cases_aop_case_updates',
            'module' => 'Cases',
            'bean_name' => 'Case',
            'link_type' => 'one',
            'source' => 'non-db',
            'vname' => 'LBL_CASE',
            'side' => 'left',
            'id_name' => 'case_id',
        ),
        'case_name' => array(
            'name' => 'case_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_CASE_NAME',
            'save' => true,
            'id_name' => 'case_id',
            'link' => 'cases_aop_case_updates',
            'table' => 'cases',
            'module' => 'Cases',
            'rname' => 'name',
        ),
        'case_id' => array(
            'name' => 'case_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_CASE_ID',
        ),
        'contact' => array(
            'name' => 'contact',
            'type' => 'link',
            'relationship' => 'contacts_aop_case_updates',
            'module' => 'Contacts',
            'bean_name' => 'Contact',
            'source' => 'non-db',
            'vname' => 'LBL_CONTACT',
        ),
        'contact_name' => array(
            'name' => 'contact_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_CONTACT_NAME',
            'save' => true,
            'id_name' => 'contact_id',
            'link' => 'contacts_aop_case_updates',
            'table' => 'contacts',
            'module' => 'Contacts',
            'rname' => 'name',
        ),
        'contact_id' => array(
            'name' => 'contact_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_CONTACT_ID',
        ),
        'internal' => array(
                'name' => 'internal',
                'vname' => 'LBL_INTERNAL',
                'type' => 'bool',
            ),
        'notes' => array(
                'name' => 'notes',
                'type' => 'link',
                'relationship' => 'aop_case_updates_notes',
                'source' => 'non-db',
                'vname' => 'LBL_NOTES',
            ),
    ),
    'relationships' => array(
        'cases_aop_case_updates' => array(
            'lhs_module' => 'Cases',
            'lhs_table' => 'cases',
            'lhs_key' => 'id',
            'rhs_module' => 'AOP_Case_Updates',
            'rhs_table' => 'aop_case_updates',
            'rhs_key' => 'case_id',
            'relationship_type' => 'one-to-many',
        ),
        'contacts_aop_case_updates' => array(
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'AOP_Case_Updates',
            'rhs_table' => 'aop_case_updates',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
        ),
        'aop_case_updates_notes' => array(
            'lhs_module' => 'AOP_Case_Updates',
            'lhs_table' => 'aop_case_updates',
            'lhs_key' => 'id',
            'rhs_module' => 'Notes',
            'rhs_table' => 'notes',
            'rhs_key' => 'parent_id',
            'relationship_type' => 'one-to-many',
            'relationship_role_column' => 'parent_type',
            'relationship_role_column_value' => 'AOP_Case_Updates',
        ),
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('AOP_Case_Updates', 'AOP_Case_Updates', array('basic', 'assignable'));
