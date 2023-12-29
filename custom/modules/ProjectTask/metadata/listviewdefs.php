<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
$listViewDefs ['ProjectTask'] = 
array (
  'NAME' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'sortable' => true,
  ),
  'PROJECT_NAME' => 
  array (
    'width' => '25%',
    'label' => 'LBL_PROJECT_NAME',
    'id' => 'PROJECT_ID',
    'link' => true,
    'default' => true,
    'sortable' => true,
    'module' => 'Project',
    'ACLTag' => 'PROJECT',
    'related_fields' => 
    array (
      0 => 'project_id',
    ),
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_START' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_START',
    'default' => true,
    'sortable' => true,
  ),
  'DATE_FINISH' => 
  array (
    'width' => '10%',
    'label' => 'LBL_DATE_FINISH',
    'default' => true,
    'sortable' => true,
  ),
  'PRIORITY' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_PRIORITY',
    'default' => true,
    'sortable' => true,
  ),
  'PERCENT_COMPLETE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_PERCENT_COMPLETE',
    'default' => true,
    'sortable' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_LIST_ASSIGNED_USER_ID',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'UTILIZATION' => 
  array (
    'type' => 'int',
    'default' => false,
    'label' => 'LBL_UTILIZATION',
    'width' => '10%',
  ),
  'ACTUAL_EFFORT' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ACTUAL_EFFORT',
    'width' => '10%',
    'default' => false,
  ),
  'ESTIMATED_EFFORT' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ESTIMATED_EFFORT',
    'width' => '10%',
    'default' => false,
  ),
  'TASK_NUMBER' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TASK_NUMBER',
    'width' => '10%',
    'default' => false,
  ),
  'ORDER_NUMBER' => 
  array (
    'type' => 'int',
    'default' => false,
    'label' => 'LBL_ORDER_NUMBER',
    'width' => '10%',
  ),
  'PARENT_TASK_ID' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PARENT_TASK_ID',
    'width' => '10%',
    'default' => false,
  ),
  'DURATION_UNIT' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DURATION_UNIT',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'DURATION' => 
  array (
    'type' => 'int',
    'label' => 'LBL_DURATION',
    'width' => '10%',
    'default' => false,
  ),
  'PREDECESSORS' => 
  array (
    'type' => 'text',
    'label' => 'LBL_PREDECESSORS',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'PROJECT_TASK_ID' => 
  array (
    'type' => 'int',
    'label' => 'LBL_PROJECT_TASK_ID',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => false,
  ),
  'RELATIONSHIP_TYPE' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_RELATIONSHIP_TYPE',
    'width' => '10%',
    'default' => false,
  ),
  'DATE_DUE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_DATE_DUE',
    'width' => '10%',
    'default' => false,
  ),
  'MODIFIED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_MODIFIED_NAME',
    'id' => 'MODIFIED_USER_ID',
    'width' => '10%',
    'default' => false,
  ),
  'TIME_START' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TIME_START',
    'width' => '10%',
    'default' => false,
  ),
  'TIME_FINISH' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TIME_FINISH',
    'width' => '10%',
    'default' => false,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => false,
  ),
  'MILESTONE_FLAG' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_MILESTONE_FLAG',
    'width' => '10%',
    'default' => false,
  ),
  'TIME_DUE' => 
  array (
    'type' => 'time',
    'label' => 'LBL_TIME_DUE',
    'width' => '10%',
    'default' => false,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
  'ACTUAL_DURATION' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ACTUAL_DURATION',
    'width' => '10%',
    'default' => false,
  ),
);
;
?>
