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

$module_name = 'stic_Grants';
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
            'useTabs' => false,
            'tabDefs' => array(
                'LBL_DEFAULT_PANEL' => array(
                    'newTab' => false,
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
                        'name' => 'amount',
                        'label' => 'LBL_AMOUNT',
                    ),
                    1 => array(
                        'name' => 'percentage',
                        'label' => 'LBL_PERCENTAGE',
                    ),
                ),
                2 => array(
                    0 => array(
                        'name' => 'returned_amount',
                        'label' => 'LBL_RETURNED_AMOUNT',
                    ),
                    1 => array(
                        'name' => 'periodicity',
                        'studio' => 'visible',
                        'label' => 'LBL_PERIODICITY',
                    ),
                ),
                3 => array(
                    0 => array(
                        'name' => 'type',
                        'studio' => 'visible',
                        'label' => 'LBL_TYPE',
                    ),
                    1 => array(
                        'name' => 'subtype',
                        'studio' => 'visible',
                        'label' => 'LBL_SUBTYPE',
                    ),
                ),
                4 => array(
                    0 => array(
                        'name' => 'start_date',
                        'label' => 'LBL_START_DATE',
                    ),
                    1 => array(
                        'name' => 'renovation_date',
                        'label' => 'LBL_RENOVATION_DATE',
                    ),
                ),
                5 => array(
                    0 => array(
                        'name' => 'expected_end_date',
                        'label' => 'LBL_EXPECTED_END_DATE',
                    ),
                    1 => array(
                        'name' => 'end_date',
                        'label' => 'LBL_END_DATE',
                    ),
                ),
                6 => array(
                    0 => array(
                        'name' => 'stic_grants_contacts_name',
                    ),
                    1 => array(
                        'name' => 'stic_grants_stic_families_name',
                    ),
                ),
                7 => array(
                    0 => array(
                        'name' => 'stic_grants_opportunities_name',
                    ),
                    1 => array(
                        'name' => 'stic_grants_project_name',
                    ),
                ),
                8 => array(
                    0 => array(
                        'name' => 'stic_grants_accounts_name',
                    ),
                    1 => array(
                    ),
                ),
                9 => array(
                    0 => 'description',
                ),
            ),
        ),
    ),
);
