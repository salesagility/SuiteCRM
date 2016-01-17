<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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
 ********************************************************************************/

$dictionary['AOK_KnowledgeBase'] = array(
    'table' => 'aok_knowledgebase',
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
                'options' => 'aok_status_list',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'revision' =>
            array(
                'required' => false,
                'name' => 'revision',
                'vname' => 'LBL_REVISION',
                'type' => 'varchar',
                'massupdate' => 0,
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
                'len' => '255',
                'size' => '20',
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
        'additional_info' =>
            array(
                'name' => 'additional_info',
                'vname' => 'LBL_ADDITIONAL_INFO',
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
        'user_id_c' =>
            array(
                'required' => false,
                'name' => 'user_id_c',
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
        'author' =>
            array(
                'required' => true,
                'source' => 'non-db',
                'name' => 'author',
                'vname' => 'LBL_AUTHOR',
                'type' => 'relate',
                'massupdate' => 0,
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
                'len' => '255',
                'size' => '20',
                'id_name' => 'user_id_c',
                'ext2' => 'Users',
                'module' => 'Users',
                'rname' => 'name',
                'quicksearch' => 'enabled',
                'studio' => 'visible',
            ),
        'user_id1_c' =>
            array(
                'required' => false,
                'name' => 'user_id1_c',
                'vname' => 'LBL_APPROVER_USER_ID',
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
        'approver' =>
            array(
                'required' => false,
                'source' => 'non-db',
                'name' => 'approver',
                'vname' => 'LBL_APPROVER',
                'type' => 'relate',
                'massupdate' => 0,
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
                'len' => '255',
                'size' => '20',
                'id_name' => 'user_id1_c',
                'ext2' => 'Users',
                'module' => 'Users',
                'rname' => 'name',
                'quicksearch' => 'enabled',
                'studio' => 'visible',
            ),
        'aok_knowledgebase_categories' => array(
            'name' => 'aok_knowledgebase_categories',
            'type' => 'link',
            'relationship' => 'aok_knowledgebase_categories',
            'source' => 'non-db',
            'module' => 'AOK_Knowledge_Base_Categories',
            'bean_name' => false,
            'vname' => 'LBL_AOK_KB_CATEGORIES_TITLE',
        ),
    ),
    'relationships' => array(),
    'optimistic_locking' => true,
    'unified_search' => true,
);

if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOK_KnowledgeBase', 'AOK_KnowledgeBase', array('basic', 'assignable', 'security_groups'));