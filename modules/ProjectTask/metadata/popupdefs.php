<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $popupMeta = array('moduleMain' => 'ProjectTask',
//                         'varName' => 'PROJECT_TASK',
//                         'orderBy' => 'name',
//                         'whereClauses' =>
//                             array('name' => 'project_task.name'),
//                         'searchInputs' =>
//                             array('name')
//                         );

$popupMeta = array(
    'moduleMain' => 'ProjectTask',
    'varName' => 'PROJECT_TASK',
    'orderBy' => 'name',
    'whereClauses' => array(
        'name' => 'project_task.name',
        'project_name' => 'projecttask.project_name',
        'status' => 'projecttask.status',
        'date_start' => 'projecttask.date_start',
        'date_finish' => 'projecttask.date_finish',
        'priority' => 'projecttask.priority',
        'percent_complete' => 'projecttask.percent_complete',
        'assigned_user_id' => 'projecttask.assigned_user_id',
        'utilization' => 'projecttask.utilization',
        'actual_effort' => 'projecttask.actual_effort',
        'estimated_effort' => 'projecttask.estimated_effort',
        'task_number' => 'projecttask.task_number',
        'order_number' => 'projecttask.order_number',
        'parent_task_id' => 'projecttask.parent_task_id',
        'milestone_flag' => 'projecttask.milestone_flag',
        'date_due' => 'projecttask.date_due',
        'actual_duration' => 'projecttask.actual_duration',
        'duration_unit' => 'projecttask.duration_unit',
        'time_start' => 'projecttask.time_start',
        'duration' => 'projecttask.duration',
        'time_finish' => 'projecttask.time_finish',
        'predecessors' => 'projecttask.predecessors',
        'description' => 'projecttask.description',
        'relationship_type' => 'projecttask.relationship_type',
        'project_task_id' => 'projecttask.project_task_id',
        'created_by' => 'projecttask.created_by',
        'date_entered' => 'projecttask.date_entered',
        'modified_user_id' => 'projecttask.modified_user_id',
        'date_modified' => 'projecttask.date_modified',
        'current_user_only' => 'projecttask.current_user_only',
        'favorites_only' => 'projecttask.favorites_only',
    ),
    'searchInputs' => array(
        0 => 'name',
        1 => 'project_name',
        2 => 'status',
        3 => 'date_start',
        4 => 'date_finish',
        5 => 'priority',
        6 => 'percent_complete',
        7 => 'assigned_user_id',
        8 => 'utilization',
        9 => 'actual_effort',
        10 => 'estimated_effort',
        11 => 'task_number',
        12 => 'order_number',
        13 => 'parent_task_id',
        14 => 'milestone_flag',
        15 => 'date_due',
        16 => 'actual_duration',
        17 => 'duration_unit',
        18 => 'time_start',
        19 => 'duration',
        20 => 'time_finish',
        21 => 'predecessors',
        22 => 'description',
        23 => 'relationship_type',
        24 => 'project_task_id',
        25 => 'created_by',
        26 => 'date_entered',
        27 => 'modified_user_id',
        28 => 'date_modified',
        29 => 'current_user_only',
        30 => 'favorites_only',
    ),
    'searchdefs' => array(
        'name' => array(
            'name' => 'name',
            'width' => '10%',
        ),
        'project_name' => array(
            'name' => 'project_name',
            'label' => 'LBL_PROJECT_NAME',
            'width' => '10%',
        ),
        'status' => array(
            'type' => 'enum',
            'label' => 'LBL_STATUS',
            'width' => '10%',
            'name' => 'status',
        ),
        'date_start' => array(
            'type' => 'date',
            'label' => 'LBL_DATE_START',
            'width' => '10%',
            'name' => 'date_start',
        ),
        'date_finish' => array(
            'type' => 'date',
            'label' => 'LBL_DATE_FINISH',
            'width' => '10%',
            'name' => 'date_finish',
        ),
        'priority' => array(
            'type' => 'enum',
            'label' => 'LBL_PRIORITY',
            'width' => '10%',
            'name' => 'priority',
        ),
        'percent_complete' => array(
            'type' => 'int',
            'label' => 'LBL_PERCENT_COMPLETE',
            'width' => '10%',
            'name' => 'percent_complete',
        ),
        'assigned_user_id' => array(
            'name' => 'assigned_user_id',
            'type' => 'enum',
            'label' => 'LBL_ASSIGNED_TO',
            'function' => array(
                'name' => 'get_user_array',
                'params' => array(
                    0 => false,
                ),
            ),
            'width' => '10%',
        ),
        'utilization' => array(
            'type' => 'int',
            'label' => 'LBL_UTILIZATION',
            'width' => '10%',
            'name' => 'utilization',
        ),
        'actual_effort' => array(
            'type' => 'int',
            'label' => 'LBL_ACTUAL_EFFORT',
            'width' => '10%',
            'name' => 'actual_effort',
        ),
        'estimated_effort' => array(
            'type' => 'int',
            'label' => 'LBL_ESTIMATED_EFFORT',
            'width' => '10%',
            'name' => 'estimated_effort',
        ),
        'task_number' => array(
            'type' => 'int',
            'label' => 'LBL_TASK_NUMBER',
            'width' => '10%',
            'name' => 'task_number',
        ),
        'order_number' => array(
            'type' => 'int',
            'label' => 'LBL_ORDER_NUMBER',
            'width' => '10%',
            'name' => 'order_number',
        ),
        'parent_task_id' => array(
            'type' => 'int',
            'label' => 'LBL_PARENT_TASK_ID',
            'width' => '10%',
            'name' => 'parent_task_id',
        ),
        'milestone_flag' => array(
            'type' => 'bool',
            'label' => 'LBL_MILESTONE_FLAG',
            'width' => '10%',
            'name' => 'milestone_flag',
        ),
        'date_due' => array(
            'type' => 'date',
            'label' => 'LBL_DATE_DUE',
            'width' => '10%',
            'name' => 'date_due',
        ),
        'actual_duration' => array(
            'type' => 'int',
            'label' => 'LBL_ACTUAL_DURATION',
            'width' => '10%',
            'name' => 'actual_duration',
        ),
        'duration_unit' => array(
            'type' => 'text',
            'label' => 'LBL_DURATION_UNIT',
            'sortable' => false,
            'width' => '10%',
            'name' => 'duration_unit',
        ),
        'time_start' => array(
            'type' => 'int',
            'label' => 'LBL_TIME_START',
            'width' => '10%',
            'name' => 'time_start',
        ),
        'duration' => array(
            'type' => 'int',
            'label' => 'LBL_DURATION',
            'width' => '10%',
            'name' => 'duration',
        ),
        'time_finish' => array(
            'type' => 'int',
            'label' => 'LBL_TIME_FINISH',
            'width' => '10%',
            'name' => 'time_finish',
        ),
        'predecessors' => array(
            'type' => 'text',
            'label' => 'LBL_PREDECESSORS',
            'sortable' => false,
            'width' => '10%',
            'name' => 'predecessors',
        ),
        'description' => array(
            'type' => 'text',
            'label' => 'LBL_DESCRIPTION',
            'sortable' => false,
            'width' => '10%',
            'name' => 'description',
        ),
        'relationship_type' => array(
            'type' => 'enum',
            'label' => 'LBL_RELATIONSHIP_TYPE',
            'width' => '10%',
            'name' => 'relationship_type',
        ),
        'project_task_id' => array(
            'type' => 'int',
            'label' => 'LBL_PROJECT_TASK_ID',
            'width' => '10%',
            'name' => 'project_task_id',
        ),
        'created_by' => array(
            'type' => 'assigned_user_name',
            'label' => 'LBL_CREATED_BY',
            'width' => '10%',
            'name' => 'created_by',
        ),
        'date_entered' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_ENTERED',
            'width' => '10%',
            'name' => 'date_entered',
        ),
        'modified_user_id' => array(
            'type' => 'assigned_user_name',
            'label' => 'LBL_MODIFIED_USER_ID',
            'width' => '10%',
            'name' => 'modified_user_id',
        ),
        'date_modified' => array(
            'type' => 'datetime',
            'label' => 'LBL_DATE_MODIFIED',
            'width' => '10%',
            'name' => 'date_modified',
        ),
        'current_user_only' => array(
            'name' => 'current_user_only',
            'label' => 'LBL_CURRENT_USER_FILTER',
            'type' => 'bool',
            'width' => '10%',
        ),
        'favorites_only' => array(
            'name' => 'favorites_only',
            'label' => 'LBL_FAVORITES_FILTER',
            'type' => 'bool',
            'width' => '10%',
        ),
    ),
);
// END STIC-Custom