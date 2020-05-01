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

$dashletData['MyTasksDashlet']['searchFields'] = ['name' => ['default' => ''],
    'priority' => ['default' => ''],
    'status' => ['default' => ['Not Started', 'In Progress', 'Pending Input']],
    'date_entered' => ['default' => ''],
    'date_start' => ['default' => ''],
    'date_due' => ['default' => ''],
    'assigned_user_id' => ['type' => 'assigned_user_name',
        'label' => 'LBL_ASSIGNED_TO',
        'default' => $current_user->name]];
$dashletData['MyTasksDashlet']['columns'] = ['set_complete' => ['width' => '1',
    'label' => 'LBL_LIST_CLOSE',
    'default' => true,
    'sortable' => false],
    'name' => ['width' => '40',
        'label' => 'LBL_SUBJECT',
        'link' => true,
        'default' => true],
    'parent_name' => ['width' => '30',
        'label' => 'LBL_LIST_RELATED_TO',
        'sortable' => false,
        'dynamic_module' => 'PARENT_TYPE',
        'link' => true,
        'id' => 'PARENT_ID',
        'ACLTag' => 'PARENT',
        'related_fields' => ['parent_id', 'parent_type'],
        'default' => true,
    ],
    'priority' => ['width' => '10',
        'label' => 'LBL_PRIORITY',
        'default' => true],
    'status' => ['width' => '8',
        'label' => 'LBL_STATUS',
        'default' => true],
    'date_start' => ['width' => '15',
        'label' => 'LBL_START_DATE',
        'default' => true],
    'time_start' => ['width' => '15',
        'label' => 'LBL_START_TIME',
        'default' => false],
    'date_due' => ['width' => '15',
        'label' => 'LBL_DUE_DATE',
        'default' => true],

    'date_entered' => ['width' => '15',
        'label' => 'LBL_DATE_ENTERED'],
    'date_modified' => ['width' => '15',
        'label' => 'LBL_DATE_MODIFIED'],
    'created_by' => ['width' => '8',
        'label' => $GLOBALS['app_strings']['LBL_CREATED'],
        'sortable' => false],
    'assigned_user_name' => ['width' => '8',
        'label' => 'LBL_LIST_ASSIGNED_USER'],
    'contact_name' => ['width' => '8',
        'label' => 'LBL_LIST_CONTACT',
        'link' => true,
        'id' => 'CONTACT_ID', //bug # 38712 it gave error on clicking on contacts from
        'module' => 'Contacts', //my open tasks dashlet because some of the parameters were not set
        'ACLTag' => 'CONTACT', // like id, link etc.
        'related_fields' => ['contact_id']],
];
