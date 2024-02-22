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

$module_name = 'stic_Journal';
$searchdefs[$module_name] =
array(
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),
            'journal_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_JOURNAL_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'journal_date',
            ),
            'turn' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TURN',
                'width' => '10%',
                'default' => true,
                'name' => 'turn',
            ),
            'stic_journal_stic_centers_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_CENTERS_TITLE',
                'id' => 'STIC_JOURNAL_STIC_CENTERSSTIC_CENTERS_IDA',
                'width' => '10%',
                'default' => true,
                'name' => 'stic_journal_stic_centers_name',
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
                'width' => '10%',
                'default' => true,
            ),
            'current_user_only' => array(
                'name' => 'current_user_only',
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
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
            'type' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TYPE',
                'width' => '10%',
                'default' => true,
                'name' => 'type',
            ),
            'journal_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_JOURNAL_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'journal_date',
            ),
            'turn' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TURN',
                'width' => '10%',
                'default' => true,
                'name' => 'turn',
            ),
            'stic_journal_stic_centers_name' => array(
                'type' => 'relate',
                'link' => true,
                'label' => 'LBL_STIC_JOURNAL_STIC_CENTERS_FROM_STIC_CENTERS_TITLE',
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_JOURNAL_STIC_CENTERSSTIC_CENTERS_IDA',
                'name' => 'stic_journal_stic_centers_name',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'task' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_TASK',
                'width' => '10%',
                'default' => true,
                'name' => 'task',
            ),
            'task_start_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_TASK_START_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'task_start_date',
            ),
            'task_end_date' => array(
                'type' => 'datetimecombo',
                'label' => 'LBL_TASK_END_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'task_end_date',
            ),
            'task_scope' => array(
                'type' => 'multienum',
                'studio' => 'visible',
                'label' => 'LBL_TASK_SCOPE',
                'width' => '10%',
                'default' => true,
                'name' => 'task_scope',
            ),
            'task_fulfillment' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_TASK_FULFILLMENT',
                'width' => '10%',
                'default' => true,
                'name' => 'task_fulfillment',
            ),
            'task_description' => array(
                'type' => 'text',
                'studio' => 'visible',
                'label' => 'LBL_TASK_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'task_description',
            ),
            'infringement_seriousness' => array(
                'type' => 'enum',
                'studio' => 'visible',
                'label' => 'LBL_INFRINGEMENT_SERIOUSNESS',
                'width' => '10%',
                'default' => true,
                'name' => 'infringement_seriousness',
            ),
            'infringement_description' => array(
                'type' => 'text',
                'studio' => 'visible',
                'label' => 'LBL_INFRINGEMENT_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'infringement_description',
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
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
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
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
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
