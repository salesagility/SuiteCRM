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

$layout_defs['Documents']['subpanel_setup']['opportunities']['override_subpanel_name'] = 'SticDefault';
$layout_defs['Documents']['subpanel_setup']['contacts']['override_subpanel_name'] = 'SticDefault';
$layout_defs['Documents']['subpanel_setup']['accounts']['override_subpanel_name'] = 'SticDefault';

$layout_defs["Documents"]["subpanel_setup"]['leads'] = array(
    'order' => 100,
    'module' => 'Leads',
    'subpanel_name' => 'SticDefault',
    'sort_order' => 'asc',
    'sort_by' => 'name',
    'title_key' => 'LBL_LEADS_DOCUMENTS_1_FROM_LEADS_TITLE',
    'get_subpanel_data' => 'leads_documents_1',
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

$layout_defs["Documents"]["subpanel_setup"]['stic_job_applications_documents'] = array(
    'order' => 100,
    'module' => 'stic_Job_Applications',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'start_date',
    'title_key' => 'LBL_STIC_JOB_APPLICATIONS_DOCUMENTS_FROM_STIC_JOB_APPLICATIONS_TITLE',
    'get_subpanel_data' => 'stic_job_applications_documents',
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

$layout_defs["Documents"]["subpanel_setup"]['stic_job_offers_documents'] = array(
    'order' => 100,
    'module' => 'stic_Job_Offers',
    'subpanel_name' => 'default',
    'sort_order' => 'desc',
    'sort_by' => 'process_end_date',
    'title_key' => 'LBL_STIC_JOB_OFFERS_DOCUMENTS_FROM_STIC_JOB_OFFERS_TITLE',
    'get_subpanel_data' => 'stic_job_offers_documents',
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

$layout_defs["Documents"]["subpanel_setup"]['prospects_documents_1'] = array(
    'order' => 100,
    'module' => 'Prospects',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_PROSPECTS_DOCUMENTS_1_FROM_PROSPECTS_TITLE',
    'get_subpanel_data' => 'prospects_documents_1',
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

$layout_defs["Documents"]["subpanel_setup"]['stic_group_opportunities_documents_1'] = array (
    'order' => 100,
    'module' => 'stic_Group_Opportunities',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_STIC_GROUP_OPPORTUNITIES_DOCUMENTS_1_FROM_STIC_GROUP_OPPORTUNITIES_TITLE',
    'get_subpanel_data' => 'stic_group_opportunities_documents_1',
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

// Subpanels default sorting
$layout_defs['Documents']['subpanel_setup']['accounts']['sort_order'] = 'asc';
$layout_defs['Documents']['subpanel_setup']['accounts']['sort_by'] = 'name';
$layout_defs['Documents']['subpanel_setup']['contacts']['sort_order'] = 'asc';
$layout_defs['Documents']['subpanel_setup']['contacts']['sort_by'] = 'last_name, first_name';
$layout_defs['Documents']['subpanel_setup']['leads']['sort_order'] = 'asc';
$layout_defs['Documents']['subpanel_setup']['leads']['sort_by'] = 'last_name, first_name';
$layout_defs['Documents']['subpanel_setup']['opportunities']['sort_order'] = 'desc';
$layout_defs['Documents']['subpanel_setup']['opportunities']['sort_by'] = 'stic_presentation_date_c';
