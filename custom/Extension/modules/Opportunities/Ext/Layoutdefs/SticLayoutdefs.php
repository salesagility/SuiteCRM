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

 // Participants subpanel
 $layout_defs["Opportunities"]["subpanel_setup"]['stic_group_opportunities_opportunities'] = array (
    'order' => 100,
    'module' => 'stic_Group_Opportunities',
    'subpanel_name' => 'ForOpportunities',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_STIC_GROUP_OPPORTUNITIES_OPPORTUNITIES_FROM_STIC_GROUP_OPPORTUNITIES_TITLE',
    'get_subpanel_data' => 'stic_group_opportunities_opportunities',
    'top_buttons' => 
    array (
      0 => 
      array (
        'widget_class' => 'SubPanelTopButtonQuickCreate',
      ),
      1 => 
      array (
        'widget_class' => 'SubPanelTopSelectButton',
        'mode' => 'MultiSelect',
      ),
    ),
  );

$layout_defs['Opportunities']['subpanel_setup']['accounts']['override_subpanel_name'] = 'SticDefault';
$layout_defs['Opportunities']['subpanel_setup']['leads']['override_subpanel_name'] = 'SticDefault';

// Subpanels default sorting
$layout_defs['Opportunities']['subpanel_setup']['activities']['sort_order'] = 'asc';
$layout_defs['Opportunities']['subpanel_setup']['activities']['sort_by'] = 'date_due';
$layout_defs['Opportunities']['subpanel_setup']['history']['sort_order'] = 'desc';
$layout_defs['Opportunities']['subpanel_setup']['history']['sort_by'] = 'date_modified';
$layout_defs['Opportunities']['subpanel_setup']['contacts']['sort_order'] = 'asc';
$layout_defs['Opportunities']['subpanel_setup']['contacts']['sort_by'] = 'last_name, first_name';

// Hide SinergiaCRM unused subpanels
unset($layout_defs['Opportunities']['subpanel_setup']['project']);
unset($layout_defs['Opportunities']['subpanel_setup']['leads']);


// Grants subpanel
$layout_defs["Opportunities"]["subpanel_setup"]['stic_grants_opportunities'] = array (
    'order' => 100,
    'module' => 'stic_Grants',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_STIC_GRANTS_OPPORTUNITIES_FROM_STIC_GRANTS_TITLE',
    'get_subpanel_data' => 'stic_grants_opportunities',
    'top_buttons' => 
    array (
      0 => 
      array (
        'widget_class' => 'SubPanelTopButtonQuickCreate',
      ),
      1 => 
      array (
        'widget_class' => 'SubPanelTopSelectButton',
        'mode' => 'MultiSelect',
      ),
    ),
);

// Notifications subpanel
$layout_defs['Opportunities']['subpanel_setup']['stic_campaigns_notification'] = array(
    'order' => 100,
    'module' => 'Campaigns',
    'subpanel_name' => 'SticForNotifications',
    'sort_order' => 'asc',
    'sort_by' => 'name',
    'get_subpanel_data' => 'function:getNotificationsFromParent',
    'function_parameters' => array(
        'import_function_file' => 'custom/modules/Campaigns/SticUtils.php',
        'parent_id' => $this->_focus->id,
        'parent_type' => 'Opportunities',
        'return_as_array' => false,
    ),
    'title_key' => 'LBL_STIC_CAMPAIGNS_NOTIFICATION_FROM_OPPORTUNITIES_TITLE',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate', 
            'title' => 'LBL_NEW_BUTTON_TITLE',
        ),
    ),
);
  
