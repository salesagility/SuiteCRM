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
    'name' => array(
        'vname' => 'LBL_LIST_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'sort_order' => 'asc',
        'sort_by' => 'last_name',
        'module' => 'Leads',
        'width' => '20%',
        'default' => true,
    ),
    'status' => array(
        'type' => 'enum',
        'vname' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
    ),
    'email1' => array(
        'vname' => 'LBL_LIST_EMAIL',
        'width' => '10%',
        'widget_class' => 'SubPanelEmailLink',
        'default' => true,
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
        'module' => 'Leads',
        'width' => '4%',
        'default' => true,
    ),
    'remove_button' => array(
        'vname' => 'LBL_REMOVE',
        'widget_class' => 'SubPanelRemoveButton',
        'module' => 'Leads',
        'width' => '4%',
        'default' => true,
    ),
    'first_name' => array(
        'usage' => 'query_only',
    ),
    'last_name' => array(
        'usage' => 'query_only',
    ),
    'salutation' => array(
        'name' => 'salutation',
        'usage' => 'query_only',
    ),
);
