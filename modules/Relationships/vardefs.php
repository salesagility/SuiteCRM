<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

$dictionary['Relationship'] =

    array('table' => 'relationships'
         ,'fields' => array(
            'id' =>
            array(
                'name' => 'id',
                'vname' => 'LBL_ID',
                'type' => 'id',
                'required'=>true,
            ),

            'relationship_name' =>
            array(
                'name' => 'relationship_name',
                'vname' => 'LBL_RELATIONSHIP_NAME',
                'type' => 'varchar',
                'required'=>true,
                'len' => 150,
                'importable' => 'required',
            ),
            'lhs_module' =>
            array(
                'name' => 'lhs_module',
                'vname' => 'LBL_LHS_MODULE',
                'type' => 'varchar',
                'required'=>true,
                'len' => 100
            ),
            'lhs_table' =>
            array(
                'name' => 'lhs_table',
                'vname' => 'LBL_LHS_TABLE',
                'type' => 'varchar',
                'required'=>true,
                'len' => 64
            ),
            'lhs_key' =>
            array(
                'name' => 'lhs_key',
                'vname' => 'LBL_LHS_KEY',
                'type' => 'varchar',
                'required'=>true,
                'len' => 64
            ),
            'rhs_module' =>
            array(
                'name' => 'rhs_module',
                'vname' => 'LBL_RHS_MODULE',
                'type' => 'varchar',
                'required'=>true,
                'len' => 100
            ),
            'rhs_table' =>
            array(
                'name' => 'rhs_table',
                'vname' => 'LBL_RHS_TABLE',
                'type' => 'varchar',
                'required'=>true,
                'len' => 64
            ),
            'rhs_key' =>
            array(
                'name' => 'rhs_key',
                'vname' => 'LBL_RHS_KEY',
                'type' => 'varchar',
                'required'=>true,
                'len' => 64
            ),
            'join_table' =>
            array(
                'name' => 'join_table',
                'vname' => 'LBL_JOIN_TABLE',
                'type' => 'varchar',
                'len' => 64
            ),
            'join_key_lhs' =>
            array(
                'name' => 'join_key_lhs',
                'vname' => 'LBL_JOIN_KEY_LHS',
                'type' => 'varchar',
                'len' => 64
            ),
            'join_key_rhs' =>
            array(
                'name' => 'join_key_rhs',
                'vname' => 'LBL_JOIN_KEY_RHS',
                'type' => 'varchar',
                'len' => 64
            ),
            'relationship_type' =>
            array(
                'name' => 'relationship_type',
                'vname' => 'LBL_RELATIONSHIP_TYPE',
                'type' => 'varchar',
                'len' => 64
            ),
            'relationship_role_column' =>
            array(
                'name' => 'relationship_role_column',
                'vname' => 'LBL_RELATIONSHIP_ROLE_COLUMN',
                'type' => 'varchar',
                'len' => 64
            ),
            'relationship_role_column_value' =>
            array(
                'name' => 'relationship_role_column_value',
                'vname' => 'LBL_RELATIONSHIP_ROLE_COLUMN_VALUE',
                'type' => 'varchar',
                'len' => 50
            ),
            'reverse' =>
            array(
                'name' => 'reverse',
                'vname' => 'LBL_REVERSE',
                'type' => 'bool',
                'default' => '0'
            ),
            'deleted' =>
            array(
                'name' => 'deleted',
                'vname' => 'LBL_DELETED',
                'type' => 'bool',
                'reportable'=>false,
                'default' => '0'
            ),

    )
    , 'indices' => array(
       array('name' =>'relationshippk', 'type' =>'primary', 'fields'=>array('id')),
       array('name' =>'idx_rel_name', 'type' =>'index', 'fields'=>array('relationship_name')),
    )
);
