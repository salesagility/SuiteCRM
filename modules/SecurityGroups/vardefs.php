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

$dictionary['SecurityGroup'] = array(
    'table' => 'securitygroups',
    'audited' => true,
    'fields' => array(
        'noninheritable' =>
            array(
                'name' => 'noninheritable',
                'vname' => 'LBL_NONINHERITABLE',
                'type' => 'bool',
                'reportable' => false,
                'comment' => 'Indicator for whether a group can be inherited by a record'
            ),

        'users' => array(
            'name' => 'users',
            'type' => 'link',
            'relationship' => 'securitygroups_users',
            'source' => 'non-db',
            'vname' => 'LBL_USERS',
        ),
        'aclroles' => array(
            'name' => 'aclroles',
            'type' => 'link',
            'relationship' => 'securitygroups_acl_roles',
            'source' => 'non-db',
            'vname' => 'LBL_ROLES',
        ),

        /** related editable fields with Users module */
        'securitygroup_noninher_fields' => array(
            'name' => 'securitygroup_noninher_fields',
            'rname' => 'id',
            'relationship_fields' => array(
                'id' => 'securitygroup_noninherit_id',
                'noninheritable' => 'securitygroup_noninheritable',
                'primary_group' => 'securitygroup_primary_group'
            ),
            'vname' => 'LBL_USER_NAME',
            'type' => 'relate',
            'link' => 'users',
            'link_type' => 'relationship_info',
            'source' => 'non-db',
            'Importable' => false,
            'duplicate_merge' => 'disabled',
        ),
        'securitygroup_noninherit_id' => array(
            'name' => 'securitygroup_noninherit_id',
            'type' => 'varchar',
            'source' => 'non-db',
            'vname' => 'LBL_securitygroup_noninherit_id',
        ),
        'securitygroup_noninheritable' => array(
            'name' => 'securitygroup_noninheritable',
            'type' => 'bool',
            'source' => 'non-db',
            'vname' => 'LBL_SECURITYGROUP_NONINHERITABLE',
        ),
        'securitygroup_primary_group' => array(
            'name' => 'securitygroup_primary_group',
            'type' => 'bool',
            'source' => 'non-db',
            'vname' => 'LBL_PRIMARY_GROUP',
        ),

    ),
    'relationships' => array(),
    'optimistic_lock' => true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('SecurityGroups', 'SecurityGroup', array('basic', 'assignable'));
?>