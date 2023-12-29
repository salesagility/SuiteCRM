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
    'DetailView' => array(
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
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                ),
                'hideAudit' => true,
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
                'LBL_STIC_PANEL_RECORD_DETAILS' => array(
                    'newTab' => true,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => true,
        ),
        'panels' => array(
            'lbl_default_panel' => array(
                0 => array(
                    0 => 'name',
                    1 => array(
                        'name' => 'assigned_user_name',
                        'label' => 'LBL_ASSIGNED_USER_ID',
                    ),
                ),
                1 => array(
                    0 => 'status',
                    1 => '',
                ),
                2 => array(
                    0 => 'date_start',
                    1 => 'date_finish',
                ),
                3 => array(
                    0 => 'priority',
                    1 => 'percent_complete',
                ),
                4 => array(
                    0 => array(
                        'name' => 'project_name',
                        'customCode' => '<a href="index.php?module=Project&action=DetailView&record={$fields.project_id.value}">{$fields.project_name.value}&nbsp;</a>',
                        'label' => 'LBL_PARENT_ID',
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
                        'name' => 'predecessors',
                        'label' => 'LBL_PREDECESSORS',
                    ),
                    1 => array(
                        'name' => 'relationship_type',
                        'studio' => 'visible',
                        'label' => 'LBL_RELATIONSHIP_TYPE',
                    ),
                ),
                2 => array(
                    0 => 'order_number',
                    1 => array(
                        'name' => 'milestone_flag',
                        'label' => 'LBL_MILESTONE_FLAG',
                    ),
                ),
                3 => array(
                    0 => 'utilization',
                    1 => '',
                ),
                4 => array(
                    0 => array(
                        'name' => 'duration',
                        'label' => 'LBL_DURATION',
                    ),
                    1 => array(
                        'name' => 'duration_unit',
                        'label' => 'LBL_DURATION_UNIT',
                    ),
                ),
            ),
            'lbl_stic_panel_record_details' => array(
                0 => array(
                    0 => array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                    ),
                    1 => array(
                        'name' => 'date_entered',
                        'customCode' => '{$fields.date_entered.value}',
                        'label' => 'LBL_DATE_ENTERED',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'modified_by_name',
                        'label' => 'LBL_MODIFIED_NAME',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'customCode' => '{$fields.date_modified.value}',
                        'label' => 'LBL_DATE_MODIFIED',
                    ),
                ),
            ),
        ),
    ),
);
