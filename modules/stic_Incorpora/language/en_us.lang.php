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

$mod_strings = array (
    'LBL_ASSIGNED_TO_ID' => 'Assigned to (ID)',
    'LBL_ASSIGNED_TO_NAME' => 'Assigned to',
    'LBL_ASSIGNED_TO' => 'Assigned to',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigned to',
    'LBL_LIST_ASSIGNED_USER' => 'Assigned to',
    'LBL_CREATED' => 'Created By',
    'LBL_CREATED_USER' => 'Created By',
    'LBL_CREATED_ID' => 'Created By (ID)',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_NAME' => 'Modified By',
    'LBL_MODIFIED_USER' => 'Modified By',
    'LBL_MODIFIED_ID' => 'Modified By (ID)',
    'LBL_SECURITYGROUPS' => 'Security Groups',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Security Groups',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DELETED' => 'Deleted',
    'LBL_NAME' => 'Name',
    'LBL_LIST_NAME' => 'Name',
    'LBL_EDIT_BUTTON' => 'Edit',
    'LBL_REMOVE' => 'Remove',
    'LBL_LIST_FORM_TITLE' => 'Incorpora',
    'LBL_MODULE_NAME' => 'Incorpora',
    'LBL_MODULE_TITLE' => 'Incorpora',
    'LBL_HOMEPAGE_TITLE' => 'Incorpora',
    'LNK_NEW_RECORD' => 'Incorpora',
    'LNK_LIST' => 'Incorpora',
    'LNK_IMPORT_STIC_INCORPORA' => 'Incorpora',
    'LBL_SEARCH_FORM_TITLE' => 'Incorpora',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'View History',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
    'LBL_STIC_INCORPORA_SUBPANEL_TITLE' => 'Incorpora',
    'LBL_NEW_FORM_TITLE' => 'Incorpora',
    'LBL_EXECUTE_BUTTON' => 'Execute',
    'LBL_SYNCOPTIONS_TITLE' => 'Synchronization with Incorpora',
    'LBL_SUMMARY_TITLE' => 'Involved records',
    'LBL_SUMMARY_CRM_IDS' => 'Selected',
    'LBL_SUMMARY_INC_IDS' => 'Selected with Incorpora ID',
    'LBL_SUMMARY_NO_INC_IDS' => 'Selected without Incorpora ID',
    'LBL_SUMMARY_SUCCESSFUL' => 'Successfully synchronized',
    'LBL_SUMMARY_FAILED' => 'Synchronized with errors',
    'LBL_SYNCOPTIONS_INCORPORA_CONNECTION_PARAMS' => 'Incorpora login parameters',
    'LBL_SYNCOPTIONS_INCORPORA_CONNECTION_PARAMS_HELP' => 'Connection parameters might be set in the User profile.',
    'LBL_SYNCOPTIONS_INCORPORA_OPTION_TEST' => 'Check the box to synchronize with Incorpora TEST intranet',
    'LBL_SYNCOPTIONS_INCORPORA_REFERENCE_GROUP' => 'Reference group',
    'LBL_SYNCOPTIONS_INCORPORA_REFERENCE_ENTITY' => 'Reference entity',
    'LBL_SYNCOPTIONS_INCORPORA_REFERENCE_OFFICER' => 'Reference officer',
    'LBL_SYNCOPTIONS_INCORPORA_USER' => 'User ID',
    'LBL_SYNCOPTIONS_INCORPORA_PASSWORD' => 'Password',
    'LBL_SYNCOPTIONS_SELECT' => 'Select a synchronization option',
    'LBL_SYNCOPTIONS_CRM_INC' => '1 - Create records in Incorpora from SinergiaCRM (without Incorpora ID)',
    'LBL_SYNCOPTIONS_CRM_EDIT_INC' => '2 - Update records in Incorpora from SinergiaCRM (with Incorpora ID)',
    'LBL_SYNCOPTIONS_INC_CRM' => '3 - Retrieve records from Incorpora to SinergiaCRM (with Incorpora ID)',
    'LBL_SYNCOPTIONS_SELECT_OVERRIDE_OPTION' => 'Overwritting options:',
    'LBL_SYNCOPTIONS_INC_CRM_OVERRIDE' => 'a - Overwrite all SinergiaCRM fields with data retrieved from Incorpora.',
    'LBL_SYNCOPTIONS_INC_CRM_NOT_OVERRIDE' => 'b - Do not overwrite SinergiaCRM fields, just fill the empty ones.',
    'LBL_SYNCOPTIONS_CRM_INC_HELP' => "This option will create a new record in Incorpora if all Incorpora required fields are set and, in contacts and accounts, the identification number (NIF/NIE/CIF) does not previously exist in Incorpora. If the identification number already exists, Incorpora will send back its own ID and SinergiaCRM will save it in 'Incorpora ID' field. No changes will be done in Incorpora.",
    'LBL_SYNCOPTIONS_SELECT_OVERRIDE_OPTION_HELP' => "", 
    'LBL_RESULTS_TITLE' => 'Synchronization with Incorpora results',
    'LBL_RESULTS_INCORPORA_CONNECTION_TITLE' => 'Incorpora connection error',
    'LBL_RESULTS_INCORPORA_CONNECTION' => 'Connection log',
    'LBL_RESULTS_LOG_TITLE' => 'Synchronization log',
    'LBL_RESULTS_ERRORS_LOG' => "Result info (provided by Incorpora + SinergiaCRM)",
    'LBL_RESULTS_INCORPORA_MISSING_SETTINGS' => 'Missing values: ',
    'LBL_RESULTS_INCORPORA_API_ERROR' => "Incorpora error: ",
    'LBL_RESULTS_SYNC_RECORD_WITHOUT_INCORPORA_ID' => 'The record does not have an Incorpora ID.',
    'LBL_RESULTS_NEW_RECORD_WITH_INCORPORA_ID' => 'This record already has an Incorpora ID, so it will not be created in Incorpora.',
    'LBL_RESULTS_NEW_RECORD_ALREADY_EXISTS' => "As the record already exists in Incorpora, Incorpora ID has been added to the CRM record: ",
    'LBL_RESULTS_DATAPARSER_MISMATCH_RELATED_INCORPORA_ID' => "Job offer data have been downloaded but Incorpora ID of the related account in the CRM does not match the downloaded Incorpora ID. If necessary, you may manually correct the account Incorpora ID: ",
    'LBL_RESULTS_DATAPARSER_MISSING_RELATED_RECORD' => 'Job offer data have been downloaded, but in the CRM there is no relationship with any account: ',
    'LBL_RESULTS_DATAPARSER_RELATED_RECORD_WITHOUT_INCORPORA_ID' => 'The account related to the job offer does not have an Incorpora ID: ',
    'LBL_RESULTS_DATAPARSER_NO_LOCATION_ID' => 'There is no location with these values: ',
    'LBL_RESULTS_DATAPARSER_LIST_NOT_SET' => "The dropdown list isn't properly set in the field definition: ",
    'LBL_RESULTS_DATAPARSER_INCORPORA_ERROR_NOT_DEFINED' => 'Undefined Incorpora error. Please, try the same action in Incorpora platform.',
    'LBL_RESULTS_GET_RECORD_SUCCESS' => 'The record has been successfully downloaded from Incorpora to SinergiaCRM.',
);
