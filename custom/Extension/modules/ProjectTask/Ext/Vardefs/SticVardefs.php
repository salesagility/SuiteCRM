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

$dictionary['ProjectTask']['fields']['utilization']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['utilization']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['utilization']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['utilization']['min'] = 0;
$dictionary['ProjectTask']['fields']['utilization']['max'] = 100;

$dictionary['ProjectTask']['fields']['percent_complete']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['percent_complete']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['percent_complete']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['percent_complete']['min'] = false;
$dictionary['ProjectTask']['fields']['percent_complete']['max'] = false;

$dictionary['ProjectTask']['fields']['order_number']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['order_number']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['order_number']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['order_number']['min'] = false;
$dictionary['ProjectTask']['fields']['order_number']['max'] = false;

$dictionary['ProjectTask']['fields']['estimated_effort']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['estimated_effort']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['estimated_effort']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['estimated_effort']['min'] = false;
$dictionary['ProjectTask']['fields']['estimated_effort']['max'] = false;

$dictionary['ProjectTask']['fields']['duration']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['duration']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['duration']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['duration']['min'] = false;
$dictionary['ProjectTask']['fields']['duration']['max'] = false;

$dictionary['ProjectTask']['fields']['date_start']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['date_start']['massupdate'] = '1';
$dictionary['ProjectTask']['fields']['date_start']['options'] = 'date_range_search_dom';

$dictionary['ProjectTask']['fields']['date_finish']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['date_finish']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['date_finish']['options'] = 'date_range_search_dom';

$dictionary['ProjectTask']['fields']['actual_effort']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['actual_effort']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['actual_effort']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['actual_effort']['min'] = false;
$dictionary['ProjectTask']['fields']['actual_effort']['max'] = false;

$dictionary['ProjectTask']['fields']['actual_duration']['inline_edit'] = true;
$dictionary['ProjectTask']['fields']['actual_duration']['options'] = 'numeric_range_search_dom';
$dictionary['ProjectTask']['fields']['actual_duration']['enable_range_search'] = '1';
$dictionary['ProjectTask']['fields']['actual_duration']['min'] = false;
$dictionary['ProjectTask']['fields']['actual_duration']['max'] = false;

$dictionary['ProjectTask']['fields']['status']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['date_finish']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['percent_complete']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['assigned_user_id']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['priority']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['project_name']['massupdate'] = 1;
$dictionary['ProjectTask']['fields']['project_name']['required'] = true;

$dictionary['ProjectTask']['fields']['actual_duration']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['actual_effort']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['created_by_name']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['created_by']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['date_due']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['date_entered']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['date_modified']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['deleted']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['description']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['duration_unit']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['duration']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['estimated_effort']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['getUtilizationDropdown']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['milestone_flag']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['modified_by_name']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['modified_user_id']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['name']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['notes']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['order_number']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['parent_task_id']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['predecessors']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['project_id']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['project_task_id']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['relationship_type']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['task_number']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['time_due']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['time_finish']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['time_start']['massupdate'] = 0;
$dictionary['ProjectTask']['fields']['utilization']['massupdate'] = 0;
