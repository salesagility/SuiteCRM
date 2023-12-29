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

$subpanel_layout = array(
    'top_buttons' => '',
    'where' => '',
    'list_fields' => array(   
        'name' => array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '45%',
            'default' => true,
        ),
        'stic_goals_contacts_name' => array(
            'type' => 'relate',
            'link' => true,
            'vname' => 'LBL_STIC_GOALS_CONTACTS_FROM_CONTACTS_TITLE',
            'id' => 'STIC_GOALS_CONTACTSCONTACTS_IDA',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'Contacts',
            'target_record_key' => 'stic_goals_contactscontacts_ida',
        ),
        'origin' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'vname' => 'LBL_ORIGIN',
            'width' => '10%',
            'default' => true,
        ),
        'start_date' => array(
            'type' => 'date',
            'vname' => 'LBL_START_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'expected_end_date' => array(
            'type' => 'date',
            'vname' => 'LBL_EXPECTED_END_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'actual_end_date' => array(
            'type' => 'date',
            'vname' => 'LBL_ACTUAL_END_DATE',
            'width' => '10%',
            'default' => true,
        ),
        'area' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'vname' => 'LBL_AREA',
            'width' => '10%',
            'default' => true,
        ),
        'status' => array(
            'type' => 'enum',
            'studio' => 'visible',
            'vname' => 'LBL_STATUS',
            'width' => '10%',
            'default' => true,
        ),
        'assigned_user_name' => array(
            'link' => true,
            'type' => 'relate',
            'vname' => 'LBL_ASSIGNED_TO_NAME',
            'id' => 'ASSIGNED_USER_ID',
            'width' => '10%',
            'default' => true,
            'widget_class' => 'SubPanelDetailViewLink',
            'target_module' => 'Users',
            'target_record_key' => 'assigned_user_id',
        ),
        'edit_button' => array(
            'vname' => 'LBL_EDIT_BUTTON',
            'widget_class' => 'SubPanelEditButton',
            'module' => 'stic_Goals',
            'width' => '4%',
            'default' => true,
        ),
        'remove_button' => array(
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'module' => 'stic_Goals',
            'width' => '5%',
            'default' => true,
        ),
    ),
);