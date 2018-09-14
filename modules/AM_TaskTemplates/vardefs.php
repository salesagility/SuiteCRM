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


$dictionary['AM_TaskTemplates'] = array(
    'table' => 'am_tasktemplates',
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
                'default' => 'Not Started',
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
                'options' => 'project_task_status_options',
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
                'options' => 'project_task_priority_options',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'percent_complete' =>
            array(
                'required' => false,
                'name' => 'percent_complete',
                'vname' => 'LBL_PERCENT_COMPLETE',
                'type' => 'int',
                'massupdate' => 0,
                'default' => 0,
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
        'predecessors' =>
            array(
                'required' => false,
                'name' => 'predecessors',
                'vname' => 'LBL_PREDECESSORS',
                'type' => 'int',
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
                'enable_range_search' => false,
                'disable_num_format' => '1',
                'min' => false,
                'max' => false,
            ),
        'milestone_flag' =>
            array(
                'required' => false,
                'name' => 'milestone_flag',
                'vname' => 'LBL_MILESTONE_FLAG',
                'type' => 'bool',
                'massupdate' => 0,
                'default' => '0',
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
        'relationship_type' =>
            array(
                'required' => false,
                'name' => 'relationship_type',
                'vname' => 'LBL_RELATIONSHIP_TYPE',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => 'FS',
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
                'options' => 'relationship_type_list',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'task_number' =>
            array(
                'required' => false,
                'name' => 'task_number',
                'vname' => 'LBL_TASK_NUMBER',
                'type' => 'int',
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
                'enable_range_search' => false,
                'disable_num_format' => '1',
                'min' => false,
                'max' => false,
            ),
        'order_number' =>
            array(
                'required' => false,
                'name' => 'order_number',
                'vname' => 'LBL_ORDER_NUMBER',
                'type' => 'int',
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
                'enable_range_search' => false,
                'disable_num_format' => '',
                'min' => false,
                'max' => false,
            ),
        'estimated_effort' =>
            array(
                'required' => false,
                'name' => 'estimated_effort',
                'vname' => 'LBL_ESTIMATED_EFFORT',
                'type' => 'int',
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
                'enable_range_search' => false,
                'disable_num_format' => '1',
                'min' => false,
                'max' => false,
            ),
        'utilization' =>
            array(
                'required' => false,
                'name' => 'utilization',
                'vname' => 'LBL_UTILIZATION',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => '0',
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
                'options' => 'project_task_utilization_options',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'duration' =>
            array(
                'required' => true,
                'name' => 'duration',
                'vname' => 'LBL_DURATION',
                'type' => 'int',
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
                'enable_range_search' => false,
                'disable_num_format' => '1',
                'min' => false,
                'max' => false,
            ),
        'am_tasktemplates_am_projecttemplates' =>
            array(
                'name' => 'am_tasktemplates_am_projecttemplates',
                'type' => 'link',
                'relationship' => 'am_tasktemplates_am_projecttemplates',
                'source' => 'non-db',
                'module' => 'AM_ProjectTemplates',
                'bean_name' => 'AM_ProjectTemplates',
                'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
                'id_name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
            ),
        'am_tasktemplates_am_projecttemplates_name' =>
            array(
                'name' => 'am_tasktemplates_am_projecttemplates_name',
                'type' => 'relate',
                'source' => 'non-db',
                'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_PROJECTTEMPLATES_TITLE',
                'save' => true,
                'id_name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
                'link' => 'am_tasktemplates_am_projecttemplates',
                'table' => 'am_projecttemplates',
                'module' => 'AM_ProjectTemplates',
                'rname' => 'name',
            ),
        'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida' =>
            array(
                'name' => 'am_tasktemplates_am_projecttemplatesam_projecttemplates_ida',
                'type' => 'link',
                'relationship' => 'am_tasktemplates_am_projecttemplates',
                'source' => 'non-db',
                'reportable' => false,
                'side' => 'right',
                'vname' => 'LBL_AM_TASKTEMPLATES_AM_PROJECTTEMPLATES_FROM_AM_TASKTEMPLATES_TITLE',
            ),
    ),
    'relationships' => array(),
    'optimistic_locking' => true,
    'unified_search' => true,
);
if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AM_TaskTemplates', 'AM_TaskTemplates', array('basic', 'assignable'));
