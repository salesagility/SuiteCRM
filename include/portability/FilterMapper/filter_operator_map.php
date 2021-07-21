<?php
/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a)=>FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

$filter_operator_map = [
    'default' => [
        '=' => [
            '{field}_{type}' => 'values'
        ],
        'not_equal' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '{target}'
        ],
        'between' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '{start}',
            'end_range_{field}_{type}' => '{end}'
        ],
        'greater_than' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '{target}'
        ],
        'less_than' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '{target}'
        ],
        'last_7_days' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'next_7_days' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'last_30_days' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'next_30_days' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'last_month' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'this_month' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '[{operator}]',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'next_month' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'last_year' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'this_year' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
        'next_year' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '',
            'start_range_{field}_{type}' => '',
            'end_range_{field}_{type}' => ''
        ],
    ],
    'date' => [
        '=' => [
            '{field}_{type}_range_choice' => '{operator}',
            'range_{field}_{type}' => '{target}'
        ],
        'datetime' => [
            '=' => [
                '{field}_{type}_range_choice' => '{operator}',
                'range_{field}_{type}' => '{target}'
            ],
        ]
    ]
];

$extensionPath = 'custom/application/Ext/FilterOperatorMap/filter_operator_map.ext.php';
if (file_exists($extensionPath)) {
    include($extensionPath);
}

