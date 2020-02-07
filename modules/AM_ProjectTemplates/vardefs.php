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

$dictionary['AM_ProjectTemplates'] = array(
    'table' => 'am_projecttemplates',
    'audited' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'name' =>
            array(
                'name' => 'name',
                'vname' => 'LBL_NAME',
                'type' => 'name',
                'link' => true,
                'dbType' => 'varchar',
                'len' => '255',
                'unified_search' => false,
                'full_text_search' =>
                    array(
                        'boost' => 3,
                    ),
                'required' => true,
                'importable' => 'required',
                'duplicate_merge' => 'disabled',
                'merge_filter' => 'disabled',
                'massupdate' => 0,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'size' => '20',
            ),
        'status' =>
            array(
                'required' => false,
                'name' => 'status',
                'vname' => 'LBL_STATUS',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => 'Draft',
                'no_default' => false,
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
                'options' => 'project_status_dom',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'priority' =>
            array(
                'required' => false,
                'name' => 'priority',
                'vname' => 'LBL_PRIORITY',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => 'High',
                'no_default' => false,
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
                'options' => 'project_priority_options',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'description' =>
            array(
                'name' => 'description',
                'vname' => 'LBL_DESCRIPTION',
                'type' => 'text',
                'comment' => 'Full text of the note',
                'rows' => '6',
                'cols' => '80',
                'required' => false,
                'massupdate' => 0,
                'no_default' => false,
                'comments' => 'Full text of the note',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'reportable' => true,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'size' => '20',
                'studio' => 'visible',
            ),
        'assigned_user_name' =>
            array(
                'name' => 'assigned_user_name',
                'link' => 'assigned_user_link',
                'vname' => 'LBL_ASSIGNED_TO_NAME',
                'rname' => 'name',
                'type' => 'relate',
                'reportable' => true,
                'source' => 'non-db',
                'table' => 'users',
                'id_name' => 'assigned_user_id',
                'module' => 'Users',
                'duplicate_merge' => 'disabled',
                'required' => false,
                'massupdate' => 0,
                'no_default' => false,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge_dom_value' => '0',
                'audited' => false,
                'unified_search' => false,
                'merge_filter' => 'disabled',
                'len' => '255',
                'size' => '20',
                'ext2' => '',
                'quicksearch' => 'enabled',
                'studio' => 'visible',
            ),
        'am_projecttemplates_project_1' =>
            array(
                'name' => 'am_projecttemplates_project_1',
                'type' => 'link',
                'relationship' => 'am_projecttemplates_project_1',
                'source' => 'non-db',
                'module' => 'Project',
                'bean_name' => 'Project',
                'side' => 'right',
                'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_PROJECT_TITLE',
            ),
        'am_tasktemplates_am_projecttemplates' =>
            array(
                'name' => 'am_tasktemplates_am_projecttemplates',
                'type' => 'link',
                'relationship' => 'am_tasktemplates_am_projecttemplates',
                'source' => 'non-db',
                'module' => 'AM_TaskTemplates',
                'bean_name' => 'AM_TaskTemplates',
                'side' => 'right',
                'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_TASKTEMPLATES_TITLE',
            ),
        'am_projecttemplates_users_1' =>
            array(
                'name' => 'am_projecttemplates_users_1',
                'type' => 'link',
                'relationship' => 'am_projecttemplates_users_1',
                'source' => 'non-db',
                'module' => 'Users',
                'bean_name' => 'User',
                'vname' => 'LBL_AM_PROJECTTEMPLATES_USERS_1_TITLE',
            ),
        'am_projecttemplates_contacts_1' =>
            array(
                'name' => 'am_projecttemplates_contacts_1',
                'type' => 'link',
                'relationship' => 'am_projecttemplates_contacts_1',
                'source' => 'non-db',
                'module' => 'Contacts',
                'bean_name' => 'Contact',
                'vname' => 'LBL_AM_PROJECTTEMPLATES_CONTACTS_1_TITLE',
            ),
        'override_business_hours' => array(
            'name' => 'override_business_hours',
            'vname' => 'LBL_OVERRIDE_BUSINESS_HOURS',
            'type' => 'bool',
            'required' => false,
            'reportable' => false,
            'default' => '0',
            'comment' => ''
        ),

    ),
    'relationships' => array(
                  
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AM_ProjectTemplates', 'AM_ProjectTemplates', array('basic', 'assignable'));
