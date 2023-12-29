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

$subpanel_layout['list_fields'] = array(
    'first_name' => array(
        'name' => 'first_name',
        'usage' => 'query_only',
    ),
    'last_name' => array(
        'name' => 'last_name',
        'usage' => 'query_only',
    ),
    'name' => array(
        'name' => 'name',
        'vname' => 'LBL_LIST_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'module' => 'Contacts',
        'width' => '43%',
    ),
    'stic_relationship_type_c' => array(
        'name' => 'stic_relationship_type_c',
        'module' => 'Contacts',
        'vname' => 'LBL_STIC_RELATIONSHIP_TYPE',
        'width' => '20%',
        'sortable' => true,
    ),
    'account_name' => array(
        'name' => 'account_name',
        'module' => 'Accounts',
        'target_record_key' => 'account_id',
        'target_module' => 'Accounts',
        'widget_class' => 'SubPanelDetailViewLink',
        'vname' => 'LBL_LIST_ACCOUNT_NAME',
        'width' => '20%',
        'sortable' => true,
    ),
    'phone_mobile' => array(
        'type' => 'phone',
        'vname' => 'LBL_MOBILE_PHONE',
        'width' => '10%',
        'default' => true,
    ),
    'phone_home' => array(
        'type' => 'phone',
        'vname' => 'LBL_HOME_PHONE',
        'width' => '10%',
        'default' => true,
    ),
    'email1' => array(
        'name' => 'email1',
        'vname' => 'LBL_LIST_EMAIL',
        'widget_class' => 'SubPanelEmailLink',
        'width' => '10%',
        'sortable' => true,
    ),
    'assigned_user_name' => array(
        'name' => 'assigned_user_name',
        'vname' => 'LBL_LIST_ASSIGNED_TO_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'target_record_key' => 'assigned_user_id',
        'target_module' => 'Employees',
        'width' => '10%',
        'default' => true,
    ),
    'edit_button' => array(
        'vname' => 'LBL_EDIT_BUTTON',
        'widget_class' => 'SubPanelEditButton',
        'module' => 'Contacts',
        'width' => '5%',
        'default' => true,
    ),
    'remove_button' => array(
        'vname' => 'LBL_REMOVE',
        'widget_class' => 'SubPanelRemoveButton',
        'module' => 'Contacts',
        'width' => '5%',
        'default' => true,
    ),
);
