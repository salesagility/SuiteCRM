<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 *
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 * @author SalesAgility <info@salesagility.com>
 */
$viewdefs['AOW_WorkFlow'] =
    [
        'DetailView' => [
            'templateMeta' => [
                'form' => [
                    'buttons' => [
                        0 => 'EDIT',
                        1 => 'DUPLICATE',
                        2 => 'DELETE',
                        3 => 'FIND_DUPLICATES',
                    ],
                ],
                'maxColumns' => '2',
                'widths' => [
                    0 => [
                        'label' => '10',
                        'field' => '30',
                    ],
                    1 => [
                        'label' => '10',
                        'field' => '30',
                    ],
                ],
                'useTabs' => false,
                'tabDefs' => [
                    'DEFAULT' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                    'CONDITIONS' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                    'ACTIONS' => [
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                    ],
                ],
            ],
            'panels' => [
                'default' => [
                    0 => [
                        0 => 'name',
                        1 => 'assigned_user_name',
                    ],
                    1 => [
                        0 => [
                            'name' => 'flow_module',
                            'studio' => 'visible',
                            'label' => 'LBL_FLOW_MODULE',
                        ],
                        1 => [
                            'name' => 'status',
                            'studio' => 'visible',
                            'label' => 'LBL_STATUS',
                        ],
                    ],
                    2 => [
                        0 => [
                            'name' => 'run_when',
                            'label' => 'LBL_RUN_WHEN',
                        ],
                        1 => [
                            'name' => 'flow_run_on',
                            'studio' => 'visible',
                            'label' => 'LBL_FLOW_RUN_ON',
                        ],
                    ],
                    3 => [
                        0 => [
                            'name' => 'multiple_runs',
                            'label' => 'LBL_MULTIPLE_RUNS',
                        ],
                    ],
                    4 => [
                        0 => 'description',
                    ],
                    5 => [
                        0 => [
                            'name' => 'date_entered',
                            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
                            'label' => 'LBL_DATE_ENTERED',
                        ],
                        1 => [
                            'name' => 'date_modified',
                            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
                            'label' => 'LBL_DATE_MODIFIED',
                        ],
                    ],
                ],
                'LBL_CONDITION_LINES' => [
                    0 => [
                        0 => 'condition_lines',
                    ],
                ],
                'LBL_ACTION_LINES' => [
                    0 => [
                        0 => 'action_lines',
                    ],
                ],
            ],
        ],
    ];
