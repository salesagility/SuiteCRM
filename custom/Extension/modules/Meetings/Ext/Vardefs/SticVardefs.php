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
$dictionary["Meeting"]["audited"] = true;
$dictionary["Meeting"]["fields"]["stic_job_applications_activities_meetings"] = array (
    'name' => 'stic_job_applications_activities_meetings',
    'type' => 'link',
    'relationship' => 'stic_job_applications_activities_meetings',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_APPLICATIONS_ACTIVITIES_MEETINGS_FROM_STIC_JOB_APPLICATIONS_TITLE',
);

$dictionary["Meeting"]["fields"]["stic_job_offers_activities_meetings"] = array (
    'name' => 'stic_job_offers_activities_meetings',
    'type' => 'link',
    'relationship' => 'stic_job_offers_activities_meetings',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_OFFERS_ACTIVITIES_MEETINGS_FROM_STIC_JOB_OFFERS_TITLE',
);

$dictionary['Meeting']['fields']['email_reminder_time']['options'] = 'stic_email_reminder_time_list';

$dictionary['Meeting']['fields']['duration']['inline_edit'] = 0;
$dictionary['Meeting']['fields']['reminders']['inline_edit'] = 0;
$dictionary['Meeting']['fields']['parent_name']['inline_edit'] = 0;
$dictionary['Meeting']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
$dictionary['Meeting']['fields']['description']['massupdate'] = 0;

$dictionary['Meeting']['fields']['accept_status']['massupdate'] = 0;
$dictionary['Meeting']['fields']['set_accept_links']['massupdate'] = 0;
$dictionary['Meeting']['fields']['location']['massupdate'] = 0;
$dictionary['Meeting']['fields']['password']['massupdate'] = 0;
$dictionary['Meeting']['fields']['join_url']['massupdate'] = 0;
$dictionary['Meeting']['fields']['host_url']['massupdate'] = 0;
$dictionary['Meeting']['fields']['creator']['massupdate'] = 0;
$dictionary['Meeting']['fields']['external_id']['massupdate'] = 0;
$dictionary['Meeting']['fields']['outlook_id']['massupdate'] = 0;

$dictionary['Meeting']['fields']['parent_name']['massupdate']='1';
$dictionary['Meeting']['fields']['status']['massupdate']='1';
$dictionary['Meeting']['fields']['date_start']['massupdate']='1';