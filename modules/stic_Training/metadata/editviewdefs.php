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
$module_name = 'stic_Training';
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
            'LBL_DEFAULT_PANEL' => array(
                0 => array(
                    0 => 'name',
                    1 => 'assigned_user_name',
                ),
                1 => array(
                    0 => array(
                        'name' => 'stic_training_contacts_name',
                    ),
                    1 => array(
                        'name' => 'country',
                        'studio' => 'visible',
                        'label' => 'LBL_COUNTRY ',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'level',
                        'studio' => 'visible',
                        'label' => 'LBL_LEVEL',
                    ),
                    1 => array(
                        'name' => 'course_year',
                        'studio' => 'visible',
                        'label' => 'LBL_COURSE_YEAR',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'status',
                        'studio' => 'visible',
                        'label' => 'LBL_STATUS',
                    ),
                    1 => array(
                        'name' => 'stic_training_accounts_name',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ),
                    1 => array(
                        'name' => 'end_date',
                        'label' => 'LBL_END_DATE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'scope',
                        'studio' => 'visible',
                        'label' => 'LBL_SCOPE',
                    ),
                    1 => array(
                        'name' => 'qualification',
                        'label' => 'LBL_QUALIFICATION',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'formal',
                        'studio' => 'visible',
                        'label' => 'LBL_FORMAL',
                    ),
                    1 => array(
                        'name' => 'accredited',
                        'studio' => 'visible',
                        'label' => 'LBL_ACCREDITED',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'grant_training',
                        'studio' => 'visible',
                        'label' => 'LBL_GRANT_TRAINING',
                    ),
                    1 => array(
                        'name' => 'previous',
                        'studio' => 'visible',
                        'label' => 'LBL_PREVIOUS',
                    ),
                ),
                8 => array(
                    0 => array(
                        'name' => 'grant_amount',
                        'studio' => 'visible',
                        'label' => 'LBL_GRANT_AMOUNT',
                    ),
                    1 => array(
                        'name' => 'certification',
                        'studio' => 'visible',
                        'label' => 'LBL_CERTIFICATION',
                    ),
                ),
                9 => array(
                    0 => array(
                        'name' => 'amount',
                        'studio' => 'visible',
                        'label' => 'LBL_AMOUNT',
                    ),
                    1 => array(
                        'name' => 'stic_training_stic_registrations_name',
                    ),
                ),
                10 => array(
                    0 => 'description',
                ),
            ),
        ),
    ),
);
