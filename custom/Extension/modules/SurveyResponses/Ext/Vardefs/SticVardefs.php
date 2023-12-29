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

// STIC AAM 20210609 - There is a bug in SuiteCRM core that doesn't display the contact/account in the ListView
// It seems that these relationships definition are missing in the vardef. Defining them solves the issue
// STIC#290
$dictionary["SurveyResponses"]["relationships"]["surveyresponses_contacts"] = array(
  'rhs_module'        => 'SurveyResponses',
  'rhs_table'         => 'surveyresponses',
  'rhs_key'           => 'contact_id',
  'lhs_module'        => 'Contacts',
  'lhs_table'         => 'contacts',
  'lhs_key'           => 'id',
  'relationship_type' => 'one-to-many',
);

$dictionary["SurveyResponses"]["relationships"]["surveyresponses_accounts"] = array(
  'rhs_module'        => 'SurveyResponses',
  'rhs_table'         => 'surveyresponses',
  'rhs_key'           => 'account_id',
  'lhs_module'        => 'Accounts',
  'lhs_table'         => 'accounts',
  'lhs_key'           => 'id',
  'relationship_type' => 'one-to-many',
);

$dictionary['SurveyResponses']['fields']['survey_name']['required'] = 1;

$dictionary['SurveyResponses']['fields']['description']['rows'] = '2'; // Make textarea fields shorter
$dictionary['SurveyResponses']['fields']['description']['massupdate'] = 0;
