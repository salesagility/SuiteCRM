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
$dictionary["Task"]["audited"] = true;
$dictionary["Task"]["fields"]["stic_job_applications_activities_tasks"] = array (
    'name' => 'stic_job_applications_activities_tasks',
    'type' => 'link',
    'relationship' => 'stic_job_applications_activities_tasks',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_APPLICATIONS_ACTIVITIES_TASKS_FROM_STIC_JOB_APPLICATIONS_TITLE',
);

$dictionary["Task"]["fields"]["stic_job_offers_activities_tasks"] = array (
    'name' => 'stic_job_offers_activities_tasks',
    'type' => 'link',
    'relationship' => 'stic_job_offers_activities_tasks',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_OFFERS_ACTIVITIES_TASKS_FROM_STIC_JOB_OFFERS_TITLE',
);  

$dictionary['Task']['fields']['parent_name']['inline_edit'] = 0; // Make textarea fields shorter

$dictionary['Task']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
$dictionary['Task']['fields']['description']['massupdate'] = 0;

$dictionary['Task']['fields']['contact_email']['massupdate'] = 0;

// Enabling massupdate for core fields
// STIC#981
$dictionary['Task']['fields']['parent_name']['massupdate']='1';
$dictionary['Task']['fields']['status']['massupdate']='1';
$dictionary['Task']['fields']['date_start']['massupdate']='1';
$dictionary['Task']['fields']['date_due']['massupdate']='1';
$dictionary['Task']['fields']['contact_name']['massupdate']='1';
$dictionary['Task']['fields']['priority']['massupdate']='1';

$dictionary['Task']['unified_search_default_enabled'] = true;