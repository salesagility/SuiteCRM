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

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array (
  'LBL_MODULE_NAME' => 'Bugs',
  'LBL_MODULE_TITLE' => 'Bug Tracker: Home',
  'LBL_MODULE_ID' => 'Bugs',
  'LBL_SEARCH_FORM_TITLE' => 'Bug Search',
  'LBL_LIST_FORM_TITLE' => 'Bug List',
  'LBL_NEW_FORM_TITLE' => 'New Bug',
  'LBL_CONTACT_BUG_TITLE' => 'Contact-Bug:',
  'LBL_SUBJECT' => 'Subject:',
  'LBL_BUG' => 'Bug:',
  'LBL_BUG_NUMBER' => 'Bug Number:',
  'LBL_NUMBER' => 'Number:',
  'LBL_STATUS' => 'Status:',
  'LBL_PRIORITY' => 'Priority:',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_CONTACT_NAME' => 'Contact Name:',
  'LBL_BUG_SUBJECT' => 'Bug Subject:',
  'LBL_CONTACT_ROLE' => 'Role:',
  'LBL_LIST_NUMBER' => 'Num.',
  'LBL_LIST_SUBJECT' => 'Subject',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_PRIORITY' => 'Priority',
  'LBL_LIST_RELEASE' => 'Release',
  'LBL_LIST_RESOLUTION' => 'Resolution',
  'LBL_LIST_LAST_MODIFIED' => 'Last Modified',
  'LBL_INVITEE' => 'Contacts',
  'LBL_TYPE' => 'Type:',
  'LBL_LIST_TYPE' => 'Type',
  'LBL_RESOLUTION' => 'Resolution:',
  'LBL_RELEASE' => 'Release:',
  'LNK_NEW_BUG' => 'Report Bug',
  'LNK_BUG_LIST' => 'View Bugs',
  'NTC_REMOVE_INVITEE' => 'Are you sure you want to remove this contact from the bug?',
  'NTC_REMOVE_ACCOUNT_CONFIRMATION' => 'Are you sure you want to remove this bug from this account?',
  'ERR_DELETE_RECORD' => 'You must specify a record number in order to delete the bug.',
  'LBL_LIST_MY_BUGS' => 'My Assigned Bugs',
  'LNK_IMPORT_BUGS' => 'Import Bugs',
  'LBL_FOUND_IN_RELEASE' => 'Found in Release:',
  'LBL_FIXED_IN_RELEASE' => 'Fixed in Release:',
  'LBL_LIST_FIXED_IN_RELEASE' => 'Fixed in Release',
  'LBL_WORK_LOG' => 'Work Log:',
  'LBL_SOURCE' => 'Source:',
  'LBL_PRODUCT_CATEGORY' => 'Category:',

  'LBL_CREATED_BY' => 'Created by:',
  'LBL_DATE_CREATED' => 'Create Date:',
  'LBL_MODIFIED_BY' => 'Last Modified by:',
  'LBL_DATE_LAST_MODIFIED' => 'Modify Date:',

  'LBL_LIST_EMAIL_ADDRESS' => 'Email Address',
  'LBL_LIST_CONTACT_NAME' => 'Contact Name',
  'LBL_LIST_ACCOUNT_NAME' => 'Account Name',
  'LBL_LIST_PHONE' => 'Phone',
  'NTC_DELETE_CONFIRMATION' => 'Are you sure you want to remove this contact from this bug?',

  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Bug Tracker',
  'LBL_ACTIVITIES_SUBPANEL_TITLE'=>'Activities',
  'LBL_HISTORY_SUBPANEL_TITLE'=>'History',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
  'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Accounts',
  'LBL_CASES_SUBPANEL_TITLE' => 'Cases',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projects',
  'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
  'LBL_SYSTEM_ID' => 'System ID',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigned User',
	'LBL_ASSIGNED_TO_NAME' => 'Assigned to',

	'LBL_BUG_INFORMATION' => 'Overview',

    //For export labels
	'LBL_FOUND_IN_RELEASE_NAME' => 'Found In Release Name',
    'LBL_PORTAL_VIEWABLE' => 'Portal Viewable',
    'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Assigned User Name',
    'LBL_EXPORT_ASSIGNED_USER_ID' => 'Assigned User ID',
    'LBL_EXPORT_FIXED_IN_RELEASE_NAMR' => 'Fixed in Release Name',
    'LBL_EXPORT_MODIFIED_USER_ID' => 'Modified By ID',
    'LBL_EXPORT_CREATED_BY' => 'Created By ID',


  );
?>
