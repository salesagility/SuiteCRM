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
$dashletData['CallsDashlet']['searchFields'] = array(
    'direction' => array(
        'default' => '',
    ),
    'status' => array(
        'default' => '',
    ),
    'date_start' => array(
        'default' => '',
    ),
    'contact_name' => array(
        'default' => '',
    ),
    'assigned_user_id' => array(
        'default' => '',
    ),
);
$dashletData['CallsDashlet']['columns'] = array(
    'name' => array(
        'width' => '40%',
        'label' => 'LBL_SUBJECT',
        'link' => true,
        'default' => true,
        'name' => 'name',
    ),
    'direction' => array(
        'width' => '10%',
        'label' => 'LBL_DIRECTION',
        'name' => 'direction',
        'default' => true,
    ),
    'status' => array(
        'width' => '8%',
        'label' => 'LBL_STATUS',
        'default' => true,
        'name' => 'status',
    ),
    'date_start' => array(
        'width' => '15%',
        'label' => 'LBL_DATE',
        'default' => true,
        'related_fields' => array(
            0 => 'time_start',
        ),
        'name' => 'date_start',
    ),
    'parent_name' => array(
        'width' => '29%',
        'label' => 'LBL_LIST_RELATED_TO',
        'sortable' => false,
        'dynamic_module' => 'PARENT_TYPE',
        'link' => true,
        'id' => 'PARENT_ID',
        'ACLTag' => 'PARENT',
        'related_fields' => array(
            0 => 'parent_id',
            1 => 'parent_type',
        ),
        'default' => true,
        'name' => 'parent_name',
    ),
    'assigned_user_name' => array(
        'width' => '8%',
        'label' => 'LBL_LIST_ASSIGNED_USER',
        'name' => 'assigned_user_name',
        'default' => true,
    ),
    'duration_hours' => array(
        'type' => 'int',
        'label' => 'LBL_DURATION_HOURS',
        'width' => '10%',
        'default' => false,
    ),
    'duration_minutes' => array(
        'type' => 'int',
        'label' => 'LBL_DURATION_MINUTES',
        'width' => '10%',
        'default' => false,
    ),
    'description' => array(
        'type' => 'text',
        'label' => 'LBL_DESCRIPTION',
        'sortable' => false,
        'width' => '10%',
        'default' => false,
        'name' => 'description',
    ),
    'date_end' => array(
        'type' => 'datetimecombo',
        'label' => 'LBL_DATE_END',
        'width' => '10%',
        'default' => false,
        'name' => 'date_end',
    ),
    'contact_name' => array(
        'type' => 'relate',
        'link' => true,
        'studio' => array(
            'required' => false,
            'listview' => true,
            'visible' => false,
        ),
        'label' => 'LBL_CONTACT_NAME',
        'id' => 'CONTACT_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'contact_name',
    ),
    'duration' => array(
        'width' => '10%',
        'label' => 'LBL_DURATION',
        'sortable' => false,
        'related_fields' => array(
            0 => 'duration_hours',
            1 => 'duration_minutes',
        ),
        'name' => 'duration',
        'default' => false,
    ),
    'set_complete' => array(
        'width' => '5%',
        'label' => 'LBL_LIST_CLOSE',
        'default' => false,
        'sortable' => false,
        'related_fields' => array(
            0 => 'status',
            1 => 'recurring_source',
        ),
        'name' => 'set_complete',
    ),
    'accept_status' => array(
        'type' => 'varchar',
        'label' => 'LBL_ACCEPT_STATUS',
        'width' => '10%',
        'default' => false,
        'name' => 'accept_status',
    ),
    'set_accept_links' => array(
        'width' => '10%',
        'label' => 'Accept?',
        'sortable' => false,
        'related_fields' => array(
            0 => 'status',
        ),
        'default' => false,
        'name' => 'set_accept_links',
    ),
    'reschedule_count' => array(
        'type' => 'varchar',
        'studio' => 'visible',
        'label' => 'LBL_RESCHEDULE_COUNT',
        'width' => '10%',
        'default' => false,
        'name' => 'reschedule_count',
    ),
    'reschedule_history' => array(
        'type' => 'varchar',
        'studio' => 'visible',
        'label' => 'LBL_RESCHEDULE_HISTORY',
        'width' => '10%',
        'default' => false,
        'name' => 'reschedule_history',
    ),
    'created_by' => array(
        'width' => '8%',
        'label' => 'LBL_CREATED',
        'name' => 'created_by',
        'default' => false,
    ),
    'date_entered' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_ENTERED',
        'name' => 'date_entered',
        'default' => false,
    ),
    'modified_by_name' => array(
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_MODIFIED_NAME',
        'id' => 'MODIFIED_USER_ID',
        'width' => '10%',
        'default' => false,
        'name' => 'modified_by_name',
    ),
    'date_modified' => array(
        'width' => '15%',
        'label' => 'LBL_DATE_MODIFIED',
        'name' => 'date_modified',
        'default' => false,
    ),
);
