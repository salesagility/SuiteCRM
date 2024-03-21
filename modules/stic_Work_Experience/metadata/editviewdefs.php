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

$module_name = 'stic_Work_Experience';
$viewdefs[$module_name] =
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
            'useTabs' => false,
            'tabDefs' => array(
                'LBL_DEFAULT_PANEL' => array(
                    'newTab' => false,
                    'panelDefault' => 'expanded',
                ),
            ),
            'syncDetailEditViews' => false,
        ),
        'panels' => array(
            'lbl_default_panel' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'stic_work_experience_contacts_name',
                    ),
                    1 => array(
                        'name' => 'stic_work_experience_accounts_name',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'position',
                        'label' => 'LBL_POSITION',
                    ),
                    1 => array(
                        'name' => 'position_type',
                        'studio' => 'visible',
                        'label' => 'LBL_POSITION_TYPE',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'sector',
                        'studio' => 'visible',
                        'label' => 'LBL_SECTOR',
                    ),
                    1 => array(
                        'name' => 'subsector',
                        'studio' => 'visible',
                        'label' => 'LBL_SUBSECTOR',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'contract_type',
                        'studio' => 'visible',
                        'label' => 'LBL_CONTRACT_TYPE',
                    ),
                    1 => array(
                        'name' => 'workday_type',
                        'studio' => 'visible',
                        'label' => 'LBL_WORKDAY_TYPE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ),
                    1 => array(
                        'name' => 'end_date',
                        'label' => 'LBL_END_DATE',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'schedule',
                        'label' => 'LBL_SCHEDULE',
                    ),
                    1 => array(
                        'name' => 'achieved',
                        'label' => 'LBL_ACHIEVED',
                    ),
                ),
                7 => array(
                    0 => array(
                    ),
                    1 => array(
                        'name' => 'stic_work_experience_stic_job_applications_name',
                    ),
                ),
                8 => array(
                    0 => 'description',
                ),
            ),
        ),
    ),
);
