<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
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

global $current_user;

$dashletData['MyProjectTaskDashlet']['searchFields'] = [
    'date_entered' => ['default' => ''],
    'priority' => ['default' => ''],
    'date_start' => ['default' => ''],
    'date_finish' => ['default' => ''],
    'assigned_user_id' => ['type' => 'assigned_user_name',
        'label' => 'LBL_ASSIGNED_TO',
        'default' => $current_user->name],
];
$dashletData['MyProjectTaskDashlet']['columns'] = [
    'name' => [
        'width' => '30%',
        'label' => 'LBL_NAME',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ],
    'project_name' => [
        'width' => '30%',
        'label' => 'LBL_PROJECT_NAME',
        'related_fields' => [
            0 => 'project_id',
        ],
        'name' => 'project_name',
        'default' => true,
    ],
    'date_start' => [
        'width' => '15%',
        'label' => 'LBL_DATE_START',
        'default' => true,
        'name' => 'date_start',
    ],
    'status' => [
        'type' => 'enum',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
    ],
    'percent_complete' => [
        'width' => '10%',
        'label' => 'LBL_PERCENT_COMPLETE',
        'default' => true,
        'name' => 'percent_complete',
    ],
    'date_finish' => [
        'width' => '15%',
        'label' => 'LBL_DATE_FINISH',
        'default' => true,
        'name' => 'date_finish',
    ],
    'time_start' => [
        'width' => '15%',
        'label' => 'LBL_TIME_START',
        'name' => 'time_start',
        'default' => false,
    ],
    'priority' => [
        'width' => '15%',
        'label' => 'LBL_PRIORITY',
        'default' => false,
        'name' => 'priority',
    ],
    'time_finish' => [
        'width' => '15%',
        'label' => 'LBL_TIME_FINISH',
        'name' => 'time_finish',
        'default' => false,
    ],
    'milestone_flag' => [
        'width' => '10%',
        'label' => 'LBL_MILESTONE_FLAG',
        'name' => 'milestone_flag',
        'default' => false,
    ],
    'date_entered' => [
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'name' => 'date_entered',
        'default' => false,
    ],
    'date_modified' => [
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ],
    'created_by' => [
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ],
    'assigned_user_name' => [
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => false,
    ],
];
