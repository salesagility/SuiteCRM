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
$dictionary["Note"]["audited"] = true;
$dictionary["Note"]["fields"]["stic_job_applications_activities_notes"] = array (
    'name' => 'stic_job_applications_activities_notes',
    'type' => 'link',
    'relationship' => 'stic_job_applications_activities_notes',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_APPLICATIONS_ACTIVITIES_NOTES_FROM_STIC_JOB_APPLICATIONS_TITLE',
);

$dictionary["Note"]["fields"]["stic_job_offers_activities_notes"] = array (
    'name' => 'stic_job_offers_activities_notes',
    'type' => 'link',
    'relationship' => 'stic_job_offers_activities_notes',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_OFFERS_ACTIVITIES_NOTES_FROM_STIC_JOB_OFFERS_TITLE',
);
  

$dictionary['Note']['fields']['filename']['inline_edit'] = 0;
$dictionary['Note']['fields']['parent_name']['inline_edit'] = 0;

$dictionary['Note']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
$dictionary['Note']['fields']['description']['massupdate'] = 0;

$dictionary['Note']['fields']['created_by_name']['massupdate'] = 0;
$dictionary['Note']['fields']['contact_email']['massupdate'] = 0;

$dictionary['Note']['fields']['parent_type']['inline_edit'] = false;
$dictionary['Note']['fields']['parent_name']['inline_edit'] = false;

// Enabling massupdate for core fields
// STIC#981
$dictionary['Note']['fields']['parent_name']['massupdate']='1';
$dictionary['Note']['fields']['contact_name']['massupdate']='1';
$dictionary['Note']['fields']['portal_flag']['massupdate']='1';
$dictionary['Note']['fields']['embed_flag']['massupdate']='1';
$dictionary['Note']['fields']['parent_name']['massupdate']='1';
$dictionary['Note']['fields']['contact_id']['massupdate']='1';