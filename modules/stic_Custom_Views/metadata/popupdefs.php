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

$popupMeta = array(
    'moduleMain' => 'stic_Custom_Views',
    'varName' => 'stic_Custom_Views',
    'orderBy' => 'stic_custom_views.name',
    'whereClauses' => array(
        'name' => 'stic_custom_views.name',
    ),
    'searchInputs' => array(
        0 => 'stic_custom_views_number',
        1 => 'name',
        2 => 'priority',
        3 => 'status',
    ),
    'listviewdefs' => array(
        'NAME' => array(
            'width' => '32%',
            'label' => 'LBL_NAME',
            'default' => true,
            'link' => true,
            'name' => 'name',
        ),
        'VIEW_MODULE' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'label' => 'LBL_VIEW_MODULE',
            'width' => '10%',
            'default' => true,
            'name' => 'view_module',
        ),
        'USER_TYPE' => array(
            'type' => 'enum',
            'default' => true,
            'studio' => 'visible',
            'label' => 'LBL_USER_TYPE',
            'width' => '10%',
            'name' => 'user_type',
        ),
        'ROLES' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_ROLES',
            'width' => '10%',
            'default' => true,
            'name' => 'roles',
        ),
        'SECURITY_GROUPS' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_SECURITY_GROUPS',
            'width' => '10%',
            'default' => true,
            'name' => 'security_groups',
        ),
        'ROLES_EXCLUDE' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_ROLES_EXCLUDE',
            'width' => '10%',
            'default' => true,
            'name' => 'roles',
        ),
        'SECURITY_GROUPS_EXCLUDE' => array(
            'type' => 'multienum',
            'studio' => 'visible',
            'label' => 'LBL_SECURITY_GROUPS_EXCLUDE',
            'width' => '10%',
            'default' => true,
            'name' => 'security_groups',
        ),
        'ASSIGNED_USER_NAME' => array(
            'width' => '9%',
            'label' => 'LBL_ASSIGNED_TO_NAME',
            'module' => 'Employees',
            'id' => 'ASSIGNED_USER_ID',
            'default' => true,
            'name' => 'assigned_user_name',
        ),
    ),
);
