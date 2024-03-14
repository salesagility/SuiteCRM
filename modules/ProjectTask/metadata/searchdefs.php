<?php
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
//   $searchdefs['ProjectTask'] = array(
//                     'templateMeta' => array(
//                             'maxColumns' => '3',
//                             'maxColumnsBasic' => '4',
//                             'widths' => array('label' => '10', 'field' => '30'),
//                            ),
//                     'layout' => array(
//                         'basic_search' => array(
//                             'name',
//                             array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
                            
//                         ),
//                         'advanced_search' => array(
//                             'name',
//                             array('name' => 'project_name', 'label'=>'LBL_PROJECT_NAME' ),
//                             array('name' => 'assigned_user_id', 'type' => 'enum', 'label' => 'LBL_ASSIGNED_TO', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
                            
//                         ),
//                     ),
//                );

$searchdefs['ProjectTask'] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'project_name' => array(
                'name' => 'project_name',
                'label' => 'LBL_PROJECT_NAME',
                'width' => '10%',
                'default' => true,
            ),
            'status' => array(
                'type' => 'enum',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'date_start' => array(
                'type' => 'date',
                'label' => 'LBL_DATE_START',
                'width' => '10%',
                'default' => true,
                'name' => 'date_start',
            ),
            'date_finish' => array(
                'type' => 'date',
                'label' => 'LBL_DATE_FINISH',
                'width' => '10%',
                'default' => true,
                'name' => 'date_finish',
            ),
            'priority' => array(
                'type' => 'enum',
                'label' => 'LBL_PRIORITY',
                'width' => '10%',
                'default' => true,
                'name' => 'priority',
            ),
            'percent_complete' => array(
                'type' => 'int',
                'label' => 'LBL_PERCENT_COMPLETE',
                'width' => '10%',
                'default' => true,
                'name' => 'percent_complete',
            ),
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'project_name' => array(
                'name' => 'project_name',
                'label' => 'LBL_PROJECT_NAME',
                'width' => '10%',
                'default' => true,
            ),
            'status' => array(
                'type' => 'enum',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'date_start' => array(
                'type' => 'date',
                'label' => 'LBL_DATE_START',
                'width' => '10%',
                'default' => true,
                'name' => 'date_start',
            ),
            'date_finish' => array(
                'type' => 'date',
                'label' => 'LBL_DATE_FINISH',
                'width' => '10%',
                'default' => true,
                'name' => 'date_finish',
            ),
            'priority' => array(
                'type' => 'enum',
                'label' => 'LBL_PRIORITY',
                'width' => '10%',
                'default' => true,
                'name' => 'priority',
            ),
            'percent_complete' => array(
                'type' => 'int',
                'label' => 'LBL_PERCENT_COMPLETE',
                'width' => '10%',
                'default' => true,
                'name' => 'percent_complete',
            ),
            'assigned_user_id' => array(
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
            ),
            'utilization' => array(
                'type' => 'int',
                'default' => true,
                'label' => 'LBL_UTILIZATION',
                'width' => '10%',
                'name' => 'utilization',
            ),
            'actual_effort' => array(
                'type' => 'int',
                'label' => 'LBL_ACTUAL_EFFORT',
                'width' => '10%',
                'default' => true,
                'name' => 'actual_effort',
            ),
            'estimated_effort' => array(
                'type' => 'int',
                'label' => 'LBL_ESTIMATED_EFFORT',
                'width' => '10%',
                'default' => true,
                'name' => 'estimated_effort',
            ),
            'task_number' => array(
                'type' => 'int',
                'label' => 'LBL_TASK_NUMBER',
                'width' => '10%',
                'default' => true,
                'name' => 'task_number',
            ),
            'order_number' => array(
                'type' => 'int',
                'default' => true,
                'label' => 'LBL_ORDER_NUMBER',
                'width' => '10%',
                'name' => 'order_number',
            ),
            'parent_task_id' => array(
                'type' => 'int',
                'label' => 'LBL_PARENT_TASK_ID',
                'width' => '10%',
                'default' => true,
                'name' => 'parent_task_id',
            ),
            'milestone_flag' => array(
                'type' => 'bool',
                'label' => 'LBL_MILESTONE_FLAG',
                'width' => '10%',
                'default' => true,
                'name' => 'milestone_flag',
            ),
            'date_due' => array(
                'type' => 'date',
                'label' => 'LBL_DATE_DUE',
                'width' => '10%',
                'default' => true,
                'name' => 'date_due',
            ),
            'actual_duration' => array(
                'type' => 'int',
                'label' => 'LBL_ACTUAL_DURATION',
                'width' => '10%',
                'default' => true,
                'name' => 'actual_duration',
            ),
            'duration_unit' => array(
                'type' => 'text',
                'label' => 'LBL_DURATION_UNIT',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'duration_unit',
            ),
            'time_start' => array(
                'type' => 'int',
                'label' => 'LBL_TIME_START',
                'width' => '10%',
                'default' => true,
                'name' => 'time_start',
            ),
            'duration' => array(
                'type' => 'int',
                'label' => 'LBL_DURATION',
                'width' => '10%',
                'default' => true,
                'name' => 'duration',
            ),
            'time_finish' => array(
                'type' => 'int',
                'label' => 'LBL_TIME_FINISH',
                'width' => '10%',
                'default' => true,
                'name' => 'time_finish',
            ),
            'predecessors' => array(
                'type' => 'text',
                'label' => 'LBL_PREDECESSORS',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'predecessors',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'relationship_type' => array(
                'type' => 'enum',
                'label' => 'LBL_RELATIONSHIP_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'relationship_type',
            ),
            'project_task_id' => array(
                'type' => 'int',
                'label' => 'LBL_PROJECT_TASK_ID',
                'width' => '10%',
                'default' => true,
                'name' => 'project_task_id',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED_BY',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
);
// END STIC-Custom