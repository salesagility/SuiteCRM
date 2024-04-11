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

$module_name = 'stic_Custom_Views';
$listViewDefs[$module_name] =
array(
    'NAME' => array(
        'width' => '32%',
        'label' => 'LBL_NAME',
        'default' => true,
        'link' => true,
    ),
    'CUSTOMIZATION_NAME' => array(
        'width' => '10%',
        'studio' => 'visible',
        'label' => 'LBL_CUSTOMIZATION_NAME',
        'default' => true,
    ),
    'VIEW_MODULE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_VIEW_MODULE',
        'width' => '10%',
        'default' => true,
    ),
    'VIEW_TYPE' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_VIEW_TYPE',
        'width' => '10%',
        'default' => true,
    ),
    'STATUS' => array(
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'USER_TYPE' => array(
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_USER_TYPE',
        'width' => '10%',
    ),
    'ROLES' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_ROLES',
        'width' => '10%',
        'default' => true,
    ),
    'SECURITY_GROUPS' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_SECURITY_GROUPS',
        'width' => '10%',
        'default' => true,
    ),
    'ROLES_EXCLUDE' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_ROLES_EXCLUDE',
        'width' => '10%',
        'default' => true,
    ),
    'SECURITY_GROUPS_EXCLUDE' => array(
        'type' => 'multienum',
        'studio' => 'visible',
        'label' => 'LBL_SECURITY_GROUPS_EXCLUDE',
        'width' => '10%',
        'default' => true,
    ),
    'ASSIGNED_USER_NAME' => array(
        'width' => '9%',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true,
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
    'DATE_ENTERED' => array(
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => false,
    ),
);
