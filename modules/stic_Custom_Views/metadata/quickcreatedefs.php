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
$viewdefs[$module_name] =
array(
    'QuickCreate' => array(
        'templateMeta' => array(
            'maxColumns' => '2',
            'widths' => array(
                0 => array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 => array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'LBL_DEFAULT_PANEL' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
        ),
        'panels' => array(
            'LBL_DEFAULT_PANEL' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'view_module',
                        'studio' => 'visible',
                        'label' => 'LBL_VIEW_MODULE',
                    ),
                    1 => array(
                        'name' => 'user_type',
                        'studio' => 'visible',
                        'label' => 'LBL_USER_TYPE',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'roles',
                        'studio' => 'visible',
                        'label' => 'LBL_ROLES',
                    ),
                    1 => array(
                        'name' => 'security_groups',
                        'studio' => 'visible',
                        'label' => 'LBL_SECURITY_GROUPS',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'roles_exclude',
                        'studio' => 'visible',
                        'label' => 'LBL_ROLES_EXCLUDE',
                    ),
                    1 => array(
                        'name' => 'security_groups_exclude',
                        'studio' => 'visible',
                        'label' => 'LBL_SECURITY_GROUPS_EXCLUDE',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'description',
                        'comment' => 'Full text of the note',
                        'label' => 'LBL_DESCRIPTION',
                    ),
                ),
            ),
        ),
    ),
);
