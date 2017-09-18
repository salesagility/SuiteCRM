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

$vardefs = array(
    'fields' => array(
        $_object_name . '_number' => array(
            'name' => $_object_name . '_number',
            'vname' => 'LBL_NUMBER',
            'type' => 'int',
            'readonly' => true,
            'len' => 11,
            'required' => true,
            'auto_increment' => true,
            'unified_search' => true,
            'full_text_search' => array('boost' => 3),
            'comment' => 'Visual unique identifier',
            'duplicate_merge' => 'disabled',
            'disable_num_format' => true,
            'studio' => array('quickcreate' => false),
            'inline_edit' => false,
        ),

        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_SUBJECT',
            'type' => 'name',
            'link' => true,
            'dbType' => 'varchar',
            'len' => 255,
            'audited' => true,
            'unified_search' => true,
            'full_text_search' => array('boost' => 3),
            'comment' => 'The short description of the bug',
            'merge_filter' => 'selected',
            'required' => true,
            'importable' => 'required',

        ),
        'type' => array(
            'name' => 'type',
            'vname' => 'LBL_TYPE',
            'type' => 'enum',
            'options' => strtolower($object_name) . '_type_dom',
            'len' => 255,
            'comment' => 'The type of issue (ex: issue, feature)',
            'merge_filter' => 'enabled',
        ),

        'status' => array(
            'name' => 'status',
            'vname' => 'LBL_STATUS',
            'type' => 'enum',
            'options' => strtolower($object_name) . '_status_dom',
            'len' => 100,
            'audited' => true,
            'comment' => 'The status of the issue',
            'merge_filter' => 'enabled',

        ),

        'priority' => array(
            'name' => 'priority',
            'vname' => 'LBL_PRIORITY',
            'type' => 'enum',
            'options' => strtolower($object_name) . '_priority_dom',
            'len' => 100,
            'audited' => true,
            'comment' => 'An indication of the priorty of the issue',
            'merge_filter' => 'enabled',

        ),

        'resolution' => array(
            'name' => 'resolution',
            'vname' => 'LBL_RESOLUTION',
            'type' => 'enum',
            'options' => strtolower($object_name) . '_resolution_dom',
            'len' => 255,
            'audited' => true,
            'comment' => 'An indication of how the issue was resolved',
            'merge_filter' => 'enabled',

        ),

        //not in cases.
        'work_log' => array(
            'name' => 'work_log',
            'vname' => 'LBL_WORK_LOG',
            'type' => 'text',
            'comment' => 'Free-form text used to denote activities of interest'
        ),

    ),
    'indices' => array(
        'number' => array(
            'name' => strtolower($module) . 'numk',
            'type' => 'unique',
            'fields' => array($_object_name . '_number')
        )
    ),

);
