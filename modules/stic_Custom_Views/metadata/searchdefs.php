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
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'view_module' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_VIEW_MODULE',
                'width' => '10%',
                'default' => true,
                'name' => 'view_module',
            ),
            'view_type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_VIEW_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'view_type',
            ),
            'status' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
                'width' => '10%',
                'default' => true,
                'name' => 'status',
            ),
            'user_type' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_USER_TYPE',
                'width' => '10%',
                'name' => 'user_type',
            ),
            'roles' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_ROLES',
                'width' => '10%',
                'default' => true,
                'name' => 'roles',
            ),
            'security_groups' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_SECURITY_GROUPS',
                'width' => '10%',
                'default' => true,
                'name' => 'security_groups',
            ),
            'roles_exclude' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_ROLES_EXCLUDE',
                'width' => '10%',
                'default' => true,
                'name' => 'roles',
            ),
            'security_groups_exclude' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_SECURITY_GROUPS_EXCLUDE',
                'width' => '10%',
                'default' => true,
                'name' => 'security_groups',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
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
            'view_module' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_VIEW_MODULE',
                'width' => '10%',
                'default' => true,
                'name' => 'view_module',
            ),
            'user_type' => array(
                'type' => 'enum',
                'default' => true,
                'studio' => 'visible',
                'label' => 'LBL_USER_TYPE',
                'width' => '10%',
                'name' => 'user_type',
            ),
            'roles' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_ROLES',
                'width' => '10%',
                'default' => true,
                'name' => 'roles',
            ),
            'security_groups' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_SECURITY_GROUPS',
                'width' => '10%',
                'default' => true,
                'name' => 'security_groups',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
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
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
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
