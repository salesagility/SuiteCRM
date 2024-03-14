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
$dictionary["Email"]["audited"] = true;
$dictionary["Email"]["fields"]["stic_job_applications_activities_emails"] = array (
    'name' => 'stic_job_applications_activities_emails',
    'type' => 'link',
    'relationship' => 'stic_job_applications_activities_emails',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_APPLICATIONS_ACTIVITIES_EMAILS_FROM_STIC_JOB_APPLICATIONS_TITLE',
);
  
$dictionary["Email"]["fields"]["stic_job_offers_activities_emails"] = array (
    'name' => 'stic_job_offers_activities_emails',
    'type' => 'link',
    'relationship' => 'stic_job_offers_activities_emails',
    'source' => 'non-db',
    'vname' => 'LBL_STIC_JOB_OFFERS_ACTIVITIES_EMAILS_FROM_STIC_JOB_OFFERS_TITLE',
);

$dictionary["Email"]["fields"]["name"]["link"] = true;
$dictionary["Email"]["fields"]["parent_name"]["inline_edit"] = 0;

$dictionary["Email"]['unified_search_default_enabled'] = false;