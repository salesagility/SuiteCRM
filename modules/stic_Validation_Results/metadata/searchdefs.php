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

$module_name = 'stic_Validation_Results';
$searchdefs[$module_name] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'maxColumnsBasic' => '4',
        'widths' => array(
            'label' => '10',
            'field' => '30',
        ),
    ),
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'execution_date' => array(
                'type' => 'datetime',
                'studio' => array(
                    'editview' => false,
                    'quickcreate' => false,
                ),
                'label' => 'LBL_EXECUTION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'execution_date',
            ),
            'validation_action' => array(
                'type' => 'relate',
                'studio' => array(
                    'editview' => false,
                    'quickcreate' => false,
                ),
                'label' => 'LBL_VALIDATION_ACTION',
                'id' => 'STIC_VALIDATION_ACTIONS_ID_C',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'validation_action',
            ),
            'parent_name' => array(
                'type' => 'parent',
                'label' => 'LBL_FLEX_RELATE',
                'width' => '10%',
                'default' => true,
                'name' => 'parent_name',
            ),
            'reviewed' => array(
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_REVIEWED',
                'width' => '10%',
                'name' => 'reviewed',
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
        ),
        'advanced_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'width' => '10%',
            ),
            'execution_date' => array(
                'type' => 'datetime',
                'label' => 'LBL_EXECUTION_DATE',
                'width' => '10%',
                'default' => true,
                'name' => 'execution_date',
            ),
            'validation_action' => array(
                'type' => 'relate',
                'studio' => array(
                    'editview' => false,
                    'quickcreate' => false,
                ),
                'label' => 'LBL_VALIDATION_ACTION',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'id' => 'STIC_VALIDATION_ACTIONS_ID_C',
                'name' => 'validation_action',
            ),
            'parent_name' => array(
                'type' => 'parent',
                'label' => 'LBL_FLEX_RELATE',
                'width' => '10%',
                'default' => true,
                'name' => 'parent_name',
            ),
            'reviewed' => array(
                'type' => 'enum',
                'default' => true,
                'label' => 'LBL_REVIEWED',
                'width' => '10%',
                'name' => 'reviewed',
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
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'scheduler' => array(
                'type' => 'relate',
                'studio' => array(
                    'editview' => false,
                    'quickcreate' => false,
                ),
                'label' => 'LBL_SCHEDULER',
                'id' => 'SCHEDULERS_ID_C',
                'link' => true,
                'width' => '10%',
                'default' => true,
                'name' => 'scheduler',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_entered',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'date_modified',
            ),
            'created_by' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
            ),
            'modified_user_id' => array(
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
            ),
            'current_user_only' => array(
                'label' => 'LBL_CURRENT_USER_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
                'name' => 'current_user_only',
            ),
        ),
    ),
);
