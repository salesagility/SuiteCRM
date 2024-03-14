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
// $listViewDefs ['Meetings'] =
// array(
//   'SET_COMPLETE' =>
//   array(
//     'width' => '1%',
//     'label' => 'LBL_LIST_CLOSE',
//     'link' => true,
//     'sortable' => false,
//     'default' => true,
//     'related_fields' =>
//     array(
//       0 => 'status',
//     ),
//   ),
//   'NAME' =>
//   array(
//     'width' => '40%',
//     'label' => 'LBL_LIST_SUBJECT',
//     'link' => true,
//     'default' => true,
//   ),
//   'CONTACT_NAME' =>
//   array(
//     'width' => '20%',
//     'label' => 'LBL_LIST_CONTACT',
//     'link' => true,
//     'id' => 'CONTACT_ID',
//     'module' => 'Contacts',
//     'default' => true,
//     'ACLTag' => 'CONTACT',
//   ),
//   'PARENT_NAME' =>
//   array(
//     'width' => '20%',
//     'label' => 'LBL_LIST_RELATED_TO',
//     'dynamic_module' => 'PARENT_TYPE',
//     'id' => 'PARENT_ID',
//     'link' => true,
//     'default' => true,
//     'sortable' => false,
//     'ACLTag' => 'PARENT',
//     'related_fields' =>
//     array(
//       0 => 'parent_id',
//       1 => 'parent_type',
//     ),
//   ),
//   'DATE_START' =>
//   array(
//     'width' => '15%',
//     'label' => 'LBL_LIST_DATE',
//     'link' => false,
//     'default' => true,
//     'related_fields' =>
//     array(
//       0 => 'time_start',
//     ),
//   ),
//   'ASSIGNED_USER_NAME' =>
//   array(
//     'width' => '2%',
//     'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
//     'module' => 'Employees',
//     'id' => 'ASSIGNED_USER_ID',
//     'default' => true,
//   ),
//   'DIRECTION' =>
//   array(
//     'type' => 'enum',
//     'label' => 'LBL_LIST_DIRECTION',
//     'width' => '10%',
//     'default' => false,
//   ),
//   'STATUS' =>
//   array(
//     'width' => '10%',
//     'label' => 'LBL_LIST_STATUS',
//     'link' => false,
//     'default' => false,
//   ),
//   'DATE_ENTERED' => array(
//     'width' => '10%',
//     'label' => 'LBL_DATE_ENTERED',
//     'default' => true
//   ),
// );

$listViewDefs['Meetings'] =
array(
    'NAME' => array(
        'width' => '40%',
        'label' => 'LBL_LIST_SUBJECT',
        'link' => true,
        'default' => true,
    ),
    'STATUS' => array(
        'width' => '10%',
        'label' => 'LBL_LIST_STATUS',
        'link' => false,
        'default' => true,
    ),
    'DATE_START' => array(
        'width' => '15%',
        'label' => 'LBL_LIST_DATE',
        'link' => false,
        'default' => true,
        'related_fields' => array(
            0 => 'time_start',
        ),
    ),
    'PARENT_NAME' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true,
        'default' => true,
        'sortable' => false,
        'ACLTag' => 'PARENT',
        'related_fields' => array(
            0 => 'parent_id',
            1 => 'parent_type',
        ),
    ),
    'CONTACT_NAME' => array(
        'width' => '20%',
        'label' => 'LBL_LIST_CONTACT',
        'link' => true,
        'id' => 'CONTACT_ID',
        'module' => 'Contacts',
        'default' => true,
        'ACLTag' => 'CONTACT',
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '2%',
        'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
    ),
    'SET_COMPLETE' => array(
        'width' => '1%',
        'label' => 'LBL_LIST_CLOSE',
        'link' => true,
        'sortable' => false,
        'default' => true,
        'related_fields' => array(
            0 => 'status',
        ),
    ),
    'DATE_END' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_DATE_END',
        'width' => '10%',
        'default' => false,
    ),
    'DURATION' => array(
        'type' => 'enum',
        'label' => 'LBL_DURATION',
        'width' => '10%',
        'default' => false,
    ),
    'DIRECTION' => array(
        'type' => 'enum',
        'label' => 'LBL_LIST_DIRECTION',
        'width' => '10%',
        'default' => false,
    ),
    'LOCATION' => array(
        'type' => 'varchar',
        'label' => 'LBL_LOCATION',
        'width' => '10%',
        'default' => false,
    ),
    'SEQUENCE' => array(
        'type' => 'int',
        'default' => false,
        'label' => 'LBL_SEQUENCE',
        'width' => '10%',
    ),
    'ACCEPT_STATUS' => array(
        'type' => 'varchar',
        'label' => 'LBL_ACCEPT_STATUS',
        'width' => '10%',
        'default' => false,
    ),
    'SET_ACCEPT_LINKS' => array(
        'type' => 'varchar',
        'label' => 'LBL_ACCEPT_LINK',
        'width' => '10%',
        'default' => false,
    ),
    'DESCRIPTION' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
    ),
    'CREATED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_CREATED',
        'id' => 'CREATED_BY',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_ENTERED' => array(
        'width' => '10%',
        'label' => 'LBL_DATE_ENTERED',
        'default' => false,
    ),
    'MODIFIED_BY_NAME' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
    ),
    'DATE_MODIFIED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_MODIFIED',
        'width' => '10%',
        'default' => false,
    ),
);
// END STIC-Custom