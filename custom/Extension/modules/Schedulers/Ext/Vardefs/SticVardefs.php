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
// created: 2020-02-14 18:03:12
$dictionary["Scheduler"]["fields"]["stic_validation_actions_schedulers"] = array (
  'name' => 'stic_validation_actions_schedulers',
  'type' => 'link',
  'relationship' => 'stic_validation_actions_schedulers',
  'source' => 'non-db',
  'module' => 'stic_Validation_Actions',
  'bean_name' => 'stic_Validation_Actions',
  'vname' => 'LBL_STIC_VALIDATION_ACTIONS_SCHEDULERS_FROM_STIC_VALIDATION_ACTIONS_TITLE',
);

$dictionary["Scheduler"]["fields"]["last_run"]["inline_edit"] = 0;
$dictionary["Scheduler"]["fields"]["last_run"]["options"] = 'date_range_search_dom';
$dictionary["Scheduler"]["fields"]["last_run"]["enable_range_search"] = 1;
$dictionary["Scheduler"]["fields"]["last_run"]["massupdate"] = 1;

$dictionary["Scheduler"]["fields"]["date_time_start_advanced_date"]["inline_edit"] = 0;
$dictionary["Scheduler"]["fields"]["job_interval"]["inline_edit"] = 0;
$dictionary["Scheduler"]["fields"]["date_time_start"]["options"] = 'date_range_search_dom';
$dictionary["Scheduler"]["fields"]["date_time_start"]["enable_range_search"] = 1;
$dictionary["Scheduler"]["fields"]["date_time_start"]["massupdate"] = 1;
$dictionary["Scheduler"]["fields"]["date_time_end"]["options"] = 'date_range_search_dom';
$dictionary["Scheduler"]["fields"]["date_time_end"]["enable_range_search"] = 1;
$dictionary["Scheduler"]["fields"]["date_time_end"]["massupdate"] = 1;
$dictionary["Scheduler"]["fields"]["date_entered"]["options"] = 'date_range_search_dom';
$dictionary["Scheduler"]["fields"]["date_entered"]["enable_range_search"] = 1;
$dictionary["Scheduler"]["fields"]["date_modified"]["options"] = 'date_range_search_dom';
$dictionary["Scheduler"]["fields"]["date_modified"]["enable_range_search"] = 1;

$dictionary["Scheduler"]["fields"]["catch_up"]["massupdate"] = 1;
$dictionary["Scheduler"]["fields"]["adv_interval"]["massupdate"] = 1;
$dictionary["Scheduler"]["fields"]["status"]["massupdate"] = 1;
$dictionary["Scheduler"]["fields"]["job_function"]["massupdate"] = 1;

