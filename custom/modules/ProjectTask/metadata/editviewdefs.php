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
$viewdefs['ProjectTask'] =
array(
    'EditView' => array(
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
            'includes' => array(
                0 => array(
                    'file' => 'modules/ProjectTask/ProjectTask.js',
                ),
            ),
            'useTabs' => true,
            'tabDefs' => array(
                'LBL_DEFAULT_PANEL' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
                'LBL_PANEL_TIMELINE' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => false,
        ),
        'panels' => array(
            'lbl_default_panel' => array(
                0 => array(
                    0 => array(
                        'name' => 'name',
                        'label' => 'LBL_NAME',
                    ),
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'status',
                        'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
                    ),
                    1 => '',
                ),
                2 => array(
                    0 => array(
                        'name' => 'date_start',
                    ),
                    1 => array(
                        'name' => 'date_finish',
                    ),
                ),
                3 => array(
                    0 => 'priority',
                    1 => array(
                        'name' => 'percent_complete',
                        'customCode' => '<input type="text" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" size="30" value="{$fields.percent_complete.value}" title="" tabindex="0" onChange="update_status(this.value);" /></tr>',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'project_name',
                        'label' => 'LBL_PROJECT_NAME',
                    ),
                    1 => 'task_number',
                ),
                5 => array(
                    0 => array(
                        'name' => 'description',
                    ),
                ),
            ),
            'LBL_PANEL_TIMELINE' => array(
                0 => array(
                    0 => 'estimated_effort',
                    1 => array(
                        'name' => 'actual_effort',
                        'label' => 'LBL_ACTUAL_EFFORT',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'relationship_type',
                        'studio' => 'visible',
                        'label' => 'LBL_RELATIONSHIP_TYPE',
                    ),
                    1 => 'utilization',
                ),
                2 => array(
                    0 => 'order_number',
                    1 => 'milestone_flag',
                ),
            ),
        ),
    ),
);
