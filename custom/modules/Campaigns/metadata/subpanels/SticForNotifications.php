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
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$subpanel_layout = array(
    'top_buttons' => array(
        array('widget_class' => 'SubPanelTopButtonQuickCreate'),
        // array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'Campaigns'),
    ),

    'where' => '',

    'list_fields' => array(
        'name' => array(
            'name' => 'name',
            'vname' => 'LBL_LIST_CAMPAIGN_NAME',
            'widget_class' => 'SubPanelCampaignTrackDetailViewLink',
        ),
        'status' => array(
            'name' => 'status',
            'vname' => 'LBL_LIST_STATUS',
        ),
        'start_date' => array(
            'name' => 'start_date',
            'vname' => 'LBL_LIST_START_DATE',
        ),
        'stic_notification_prospect_list_names_c' => array(
            'name' => 'stic_notification_prospect_list_names_c',
            'vname' => 'LBL_STIC_NOTIFICATION_PROSPECT_LIST_NAMES_C',
        ),
        'notification_email_template_name' => array(
            'name' => 'notification_email_template_name',
            'vname' => 'LBL_NOTIFICATION_EMAIL_TEMPLATE_NAME',
        ),
        // 'quickedit_button' => array(
        //     'vname' => 'LBL_QUICKEDIT_BUTTON',
        //     'widget_class' => 'SubPanelQuickEditButton',
        //     'module' => 'Campgains',
        // ),
        // 'remove_button' => array(
        //     'vname' => 'LBL_REMOVE',
        //     'widget_class' => 'SubPanelRemoveButton',
        //     'module' => 'Campgains',
        //     'width' => '5%',
        // ),
    ),
);
