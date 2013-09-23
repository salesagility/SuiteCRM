<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


$mod_strings = array (

    'LBL_ADD_MODULE' => 'Add',
    'LBL_ADDRCITY' => 'City',
    'LBL_ADDRCOUNTRY' => 'Country',
    'LBL_ADDRCOUNTRY_ID' => 'Country Id',
    'LBL_ADDRSTATEPROV' => 'State',
    'LBL_ADMINISTRATION' => 'Connector Administration',
    'LBL_ADMINISTRATION_MAIN' => 'Connector Settings',
    'LBL_AVAILABLE' => 'Available',
    'LBL_BACK' => '< Back',
    'LBL_COMPANY_ID' => 'Company Id',
	'LBL_CONFIRM_CONTINUE_SAVE' => 'Some required fields have been left blank.  Proceed to save changes?',
    'LBL_CONNECTOR' => 'Connector',
    'LBL_CONNECTOR_FIELDS' => 'Connector Fields',
    'LBL_DATA' => 'Data',
    'LBL_DEFAULT' => 'Default',
    'LBL_DELETE_MAPPING_ENTRY' => 'Are you sure you want to delete this entry?',
    'LBL_DISABLED' => 'Disabled',
    'LBL_DUNS' => 'DUNS',
    'LBL_EMPTY_BEANS' => 'No matches were found for your search criteria.',
    'LBL_ENABLED' => 'Enabled',
    'LBL_EXTERNAL' => 'Enable users to create external account records to this connector.',
    'LBL_EXTERNAL_SET_PROPERTIES' => ' In order to use this connector, the properties should also be set in the Set Connector Properties settings page.',
    'LBL_FINSALES' => 'Finsales',
    'LBL_MARKET_CAP' => 'Market Cap',
    'LBL_MERGE' => 'Merge',
    'LBL_MODIFY_DISPLAY_TITLE' => 'Enable Connectors',
    'LBL_MODIFY_DISPLAY_DESC' => 'Select which modules are enabled for each connector.',
    'LBL_MODIFY_DISPLAY_PAGE_TITLE' => 'Connector Settings: Enable Connectors',
    'LBL_MODULE_FIELDS' => 'Module Fields',
    'LBL_MODIFY_MAPPING_TITLE' => 'Map Connector Fields',
    'LBL_MODIFY_MAPPING_DESC' => 'Map connector fields to module fields in order to determine what connector data can be viewed and merged into the module records.',
    'LBL_MODIFY_MAPPING_PAGE_TITLE' => 'Connector Settings: Map Connector Fields',
    'LBL_MODIFY_PROPERTIES_TITLE' => 'Set Connector Properties',
    'LBL_MODIFY_PROPERTIES_DESC' => 'Configure the properties for each connector, including URLs and API keys.',
    'LBL_MODIFY_PROPERTIES_PAGE_TITLE' => 'Connector Settings: Set Connector Properties',
    'LBL_MODIFY_SEARCH_TITLE' => 'Manage Connector Search',
	'LBL_MODIFY_SEARCH' => 'Search',
    'LBL_MODIFY_SEARCH_DESC' => 'Select the connector fields to use to search for data for each module.',
    'LBL_MODIFY_SEARCH_PAGE_TITLE' => 'Connector Settings: Manage Connector Search',
	'LBL_MODULE_NAME' => 'Connectors',
    'LBL_NO_PROPERTIES' => 'There are no configurable properties for this connector.',
    'LBL_PARENT_DUNS' => 'Parent DUNS',
    'LBL_PREVIOUS' => '< Back',
    'LBL_QUOTE' => 'Quote',
    'LBL_RECNAME' => 'Company Name',
    'LBL_RESET_TO_DEFAULT' => 'Reset to Default',
    'LBL_RESET_TO_DEFAULT_CONFIRM' => 'Are you sure you want to reset to the default configuration?',
    'LBL_RESET_BUTTON_TITLE' => 'Reset',
	'LBL_RESULT_LIST' => 'Data List',
    'LBL_RUN_WIZARD' => 'Run Wizard',
    'LBL_SAVE' => 'Save',
	'LBL_SEARCHING_BUTTON_LABEL' => 'Searching...',
    'LBL_SHOW_IN_LISTVIEW' => 'Show In Merge Listview',
    'LBL_SMART_COPY' => 'Smart Copy',
    'LBL_SUMMARY' => 'Summary',
    'LBL_STEP1' => 'Search and View Data',
    'LBL_STEP2' => 'Merge Records with',
    'LBL_TEST_SOURCE' => 'Test Connector',
    'LBL_TEST_SOURCE_FAILED' => 'Test Failed',
    'LBL_TEST_SOURCE_RUNNING' => 'Performing Test...',
    'LBL_TEST_SOURCE_SUCCESS' => 'Test Successful',
    'LBL_TITLE' => 'Data Merge',
    'LBL_ULTIMATE_PARENT_DUNS' => 'Ultimate Parent DUNS',

    'ERROR_RECORD_NOT_SELECTED' => 'Error: Please select a record from the list before proceeding.',
    'ERROR_EMPTY_WRAPPER' => 'Error: Unable to retrieve wrapper instance for the source [{$source_id}]',
    'ERROR_EMPTY_SOURCE_ID' => 'Error: Source Id not specified or empty.',
    'ERROR_EMPTY_RECORD_ID' => 'Error: Record Id not specified or empty.',
    'ERROR_NO_ADDITIONAL_DETAIL' => 'Error: No additional details were found for the record.',
    'ERROR_NO_SEARCHDEFS_DEFINED' => 'No modules have been enabled for this connector.  Select a module for this connector in the Enable Connectors page.',
    'ERROR_NO_SEARCHDEFS_MAPPED' => 'Error: There are no connectors enabled that have search fields defined.',
    'ERROR_NO_SOURCEDEFS_FILE' => 'Error: No sourcedefs.php file could be found.',
    'ERROR_NO_SOURCEDEFS_SPECIFIED' => 'Error: No sources were specified from which to retrieve data.',
    'ERROR_NO_CONNECTOR_DISPLAY_CONFIG_FILE' => 'Error: There are no connectors mapped to this module.',
    'ERROR_NO_SEARCHDEFS_MAPPING' => 'Error: There are no search fields defined for the module and connector.  Please contact the system administrator.',
    'ERROR_NO_FIELDS_MAPPED' => 'Error: You must map at least one Connector field to a module field for each module entry.',
    'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Error: There are no module fields that have been mapped for display in the results.  Please contact the system administrator.',
	'LBL_INFO_INLINE' => 'Info' /*for 508 compliance fix*/,
	'LBL_CLOSE' => 'Close' /*for 508 compliance fix*/,
);

?>