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

$layout_defs["Campaigns"]["subpanel_setup"]['stic_payment_commitments_campaigns'] = array(
    'order' => 100,
    'module' => 'stic_Payment_Commitments',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_STIC_PAYMENT_COMMITMENTS_CAMPAIGNS_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
    'get_subpanel_data' => 'stic_payment_commitments_campaigns',
    'top_buttons' => array(
        // 0 => array(
        //     'widget_class' => 'SubPanelTopButtonQuickCreate',
        // ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs['Campaigns']['subpanel_setup']['accounts']['override_subpanel_name'] = 'SticDefault';

$layout_defs['Campaigns']['subpanel_setup']['leads']['override_subpanel_name'] = 'SticDefault';

// Override button in order to avoid campaign wizard launching on EmailMarketing creation
$layout_defs['Campaigns']['subpanel_setup']['emailmarketing']['top_buttons'] = array(
    array('widget_class' => 'SubPanelTopCreateButton'),
);

// Subpanels default sorting
$layout_defs['Campaigns']['subpanel_setup']['tracked_urls']['sort_order'] = 'asc';
$layout_defs['Campaigns']['subpanel_setup']['tracked_urls']['sort_by'] = 'tracker_name';
$layout_defs['Campaigns']['subpanel_setup']['emailmarketing']['sort_order'] = 'desc';
$layout_defs['Campaigns']['subpanel_setup']['emailmarketing']['sort_by'] = 'date_start';

// Hide SinergiaCRM history subpanel because there is a bug displaying it
// STIC#624
unset($layout_defs["Campaigns"]["subpanel_setup"]['history']);