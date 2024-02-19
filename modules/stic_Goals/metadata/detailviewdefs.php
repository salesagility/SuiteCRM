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
$module_name = 'stic_Goals';
$viewdefs[$module_name] =
array(
    'DetailView' => array(
        'templateMeta' => array(
            'form' => array(
                'buttons' => array(
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                    3 => 'FIND_DUPLICATES',
                ),
            ),
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
                'LBL_PANEL_RECORD_DETAILS' => array(
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
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'stic_goals_contacts_name',
                    ),
                    1 => array(
                        'name' => 'stic_goals_stic_assessments_name',
                        'label' => 'LBL_STIC_GOALS_STIC_ASSESSMENTS_FROM_STIC_ASSESSMENTS_TITLE',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'stic_goals_stic_registrations_name',
                    ),
                    1 => array(
                        'name' => 'stic_goals_project_name',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                    1 => array(
                        'name' => 'level',
                        'studio' => 'visible',
                        'label' => 'LBL_LEVEL',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'origin',
                        'studio' => 'visible',
                        'label' => 'LBL_ORIGIN',
                    ),
                    1 => array(
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'expected_end_date',
                        'label' => 'LBL_EXPECTED_END_DATE',
                    ),
                    1 => array(
                        'name' => 'actual_end_date',
                        'label' => 'LBL_ACTUAL_END_DATE',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'area',
                        'studio' => 'visible',
                        'label' => 'LBL_AREA',
                    ),
                    1 => array(
                        'name' => 'subarea',
                        'studio' => 'visible',
                        'label' => 'LBL_SUBAREA',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'follow_up',
                        'studio' => 'visible',
                        'label' => 'LBL_FOLLOW_UP',
                    ),
                    1 => 'description',
                ),
            ),
            'lbl_panel_record_details' => array(
                0 => array(
                    0 => array(
                        'name' => 'created_by_name',
                        'label' => 'LBL_CREATED',
                        
                    ),
                    1 => array(
                        'name' => 'date_entered',
                        'comment' => 'Date record created',
                        'label' => 'LBL_DATE_ENTERED',
                        'customCode' => '{$fields.date_entered.value}',
                    ),
                ),
                1 => array(
                    0 => array(
                        'name' => 'modified_by_name',
                        'label' => 'LBL_MODIFIED_NAME',
                    ),
                    1 => array(
                        'name' => 'date_modified',
                        'comment' => 'Date record last modified',
                        'label' => 'LBL_DATE_MODIFIED',
                        'customCode' => '{$fields.date_modified.value}',
                    ),
                ),
            ),
        ),
    ),
);

?>