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

// Hide subpanel for native relations
unset($layout_defs["Project"]["subpanel_setup"]['accounts']);
unset($layout_defs["Project"]["subpanel_setup"]['contacts']);
unset($layout_defs["Project"]["subpanel_setup"]['opportunities']);

$layout_defs['Project']['subpanel_setup']['project_opportunities_1'] = array(
    'order' => 100,
    'module' => 'Opportunities',
    'subpanel_name' => 'SticDefault',
    'sort_order' => 'desc',
    'sort_by' => 'stic_presentation_date_c',
    'title_key' => 'LBL_PROJECT_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE',
    'get_subpanel_data' => 'project_opportunities_1',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Project"]["subpanel_setup"]['stic_accounts_relationships_project'] = array(
    'order' => 100,
    'module' => 'stic_Accounts_Relationships',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_ACCOUNTS_RELATIONSHIPS_PROJECT_FROM_STIC_ACCOUNTS_RELATIONSHIPS_TITLE',
    'get_subpanel_data' => 'stic_accounts_relationships_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Project"]["subpanel_setup"]['stic_contacts_relationships_project'] = array(
    'order' => 100,
    'module' => 'stic_Contacts_Relationships',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_CONTACTS_RELATIONSHIPS_PROJECT_FROM_STIC_CONTACTS_RELATIONSHIPS_TITLE',
    'get_subpanel_data' => 'stic_contacts_relationships_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Project"]["subpanel_setup"]['stic_events_project'] = array(
    'order' => 100,
    'module' => 'stic_Events',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_EVENTS_PROJECT_FROM_STIC_EVENTS_TITLE',
    'get_subpanel_data' => 'stic_events_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Project"]["subpanel_setup"]['stic_payment_commitments_project'] = array(
    'order' => 100,
    'module' => 'stic_Payment_Commitments',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'first_payment_date',
    'title_key' => 'LBL_STIC_PAYMENT_COMMITMENTS_PROJECT_FROM_STIC_PAYMENT_COMMITMENTS_TITLE',
    'get_subpanel_data' => 'stic_payment_commitments_project',
    'top_buttons' => array(
        // 0 =>
        // array (
        //   'widget_class' => 'SubPanelTopButtonQuickCreate',
        // ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs['Project']['subpanel_setup']['projecttask']['override_subpanel_name'] = 'SticDefault';

$layout_defs["Project"]["subpanel_setup"]['projecttask']['top_buttons'] = array(
    0 => array(
        // Don't open quickcreate view - PR: STIC#606
        'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => array(
        'widget_class' => 'SubPanelTopSelectButton',
        'mode' => 'MultiSelect',
    ),

);

$layout_defs["Project"]["subpanel_setup"]['stic_followups_project'] = array(
    'order' => 100,
    'module' => 'stic_FollowUps',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_FOLLOWUPS_PROJECT_FROM_STIC_FOLLOWUPS_TITLE',
    'get_subpanel_data' => 'stic_followups_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

$layout_defs["Project"]["subpanel_setup"]['stic_goals_project'] = array(
    'order' => 100,
    'module' => 'stic_Goals',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_GOALS_PROJECT_FROM_STIC_GOALS_TITLE',
    'get_subpanel_data' => 'stic_goals_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

//Grants subpanel
$layout_defs["Project"]["subpanel_setup"]['stic_grants_project'] = array(
    'order' => 100,
    'module' => 'stic_Grants',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_STIC_GRANTS_PROJECT_FROM_STIC_GRANTS_TITLE',
    'get_subpanel_data' => 'stic_grants_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

// Centers subpanel
$layout_defs["Project"]["subpanel_setup"]['stic_centers_project'] = array(
    'order' => 100,
    'module' => 'stic_Centers',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'name',
    'title_key' => 'LBL_STIC_CENTERS_PROJECT_FROM_STIC_CENTERS_TITLE',
    'get_subpanel_data' => 'stic_centers_project',
    'top_buttons' => array(
        0 => array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 => array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);

// Subpanels default sorting
$layout_defs['Project']['subpanel_setup']['activities']['sort_order'] = 'asc';
$layout_defs['Project']['subpanel_setup']['activities']['sort_by'] = 'date_due';
$layout_defs['Project']['subpanel_setup']['history']['sort_order'] = 'desc';
$layout_defs['Project']['subpanel_setup']['history']['sort_by'] = 'date_modified';
$layout_defs['Project']['subpanel_setup']['projecttask']['sort_order'] = 'desc';
$layout_defs['Project']['subpanel_setup']['projecttask']['sort_by'] = 'date_start';
$layout_defs['Project']['subpanel_setup']['project_resources']['sort_order'] = 'asc';
$layout_defs['Project']['subpanel_setup']['project_resources']['sort_by'] = 'name';
