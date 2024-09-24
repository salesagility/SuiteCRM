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

$layout_defs["stic_Events"]["subpanel_setup"]['stic_registrations_stic_events'] = array(
    'order' => 100,
    'module' => 'stic_Registrations',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'registration_date',
    'title_key' => 'LBL_STIC_REGISTRATIONS_STIC_EVENTS_FROM_STIC_REGISTRATIONS_TITLE',
    'get_subpanel_data' => 'stic_registrations_stic_events',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        // 1 =>
        // array (
        //   'widget_class' => 'SubPanelTopSelectButton',
        //   'mode' => 'MultiSelect',
        // ),
    ),
);
$layout_defs["stic_Events"]["subpanel_setup"]['stic_sessions_stic_events'] = array(
    'order' => 100,
    'module' => 'stic_Sessions',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_SESSIONS_STIC_EVENTS_FROM_STIC_SESSIONS_TITLE',
    'get_subpanel_data' => 'stic_sessions_stic_events',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        // 1 =>
        // array (
        //   'widget_class' => 'SubPanelTopSelectButton',
        //   'mode' => 'MultiSelect',
        // ),
    ),
);
$layout_defs['stic_Events']['subpanel_setup']['securitygroups'] = array(
    'top_buttons' => array(array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'SecurityGroups', 'mode' => 'MultiSelect')),
    'order' => 900,
    'sort_by' => 'name',
    'sort_order' => 'asc',
    'module' => 'SecurityGroups',
    'refresh_page' => 1,
    'subpanel_name' => 'default',
    'get_subpanel_data' => 'SecurityGroups',
    'add_subpanel_data' => 'securitygroup_id',
    'title_key' => 'LBL_SECURITYGROUPS_SUBPANEL_TITLE',
);
// Notifications subpanel
$layout_defs['stic_Events']['subpanel_setup']['stic_campaigns_notification'] = array(
    'order' => 100,
    'module' => 'Campaigns',
    'subpanel_name' => 'SticForNotifications',
    'sort_order' => 'asc',
    'sort_by' => 'name',
    'get_subpanel_data' => 'function:getNotificationsFromParent',
    'function_parameters' => array(
        'import_function_file' => 'custom/modules/Campaigns/SticUtils.php',
        'parent_id' => $this->_focus->id,
        'parent_type' => 'stic_Events',
        'return_as_array' => false,
    ),
    'title_key' => 'LBL_STIC_CAMPAIGNS_NOTIFICATION_FROM_STIC_EVENTS_TITLE',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate', 
            'title' => 'LBL_NEW_BUTTON_TITLE',
        ),
    ),
);