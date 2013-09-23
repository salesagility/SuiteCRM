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
  'LBL_MODULE_NAME' => 'Tasks',
  'LBL_TASK' => 'Tasks: ',
  'LBL_MODULE_TITLE' => ' Tasks: Home',
  'LBL_SEARCH_FORM_TITLE' => ' Task Search',
  'LBL_LIST_FORM_TITLE' => ' Task List',
  'LBL_NEW_FORM_TITLE' => ' Create Task',
  'LBL_NEW_FORM_SUBJECT' => 'Subject:',
  'LBL_NEW_FORM_DUE_DATE' => 'Due Date:',
  'LBL_NEW_FORM_DUE_TIME' => 'Due Time:',
  'LBL_NEW_TIME_FORMAT' => '(24:00)',
  'LBL_LIST_CLOSE' => 'Close',
  'LBL_LIST_SUBJECT' => 'Subject',
  'LBL_LIST_CONTACT' => 'Contact',
  'LBL_LIST_PRIORITY' => 'Priority',
  'LBL_LIST_RELATED_TO' => 'Related to',
  'LBL_LIST_DUE_DATE' => 'Due Date',
  'LBL_LIST_DUE_TIME' => 'Due Time',
  'LBL_SUBJECT' => 'Subject:',
  'LBL_STATUS' => 'Status:',
  'LBL_DUE_DATE' => 'Due Date:',
  'LBL_DUE_TIME' => 'Due Time:',
  'LBL_PRIORITY' => 'Priority:',
  'LBL_COLON' => ':',
  'LBL_DUE_DATE_AND_TIME' => 'Due Date & Time:',
  'LBL_START_DATE_AND_TIME' => 'Start Date & Time:',
  'LBL_START_DATE' => 'Start Date:',
  'LBL_LIST_START_DATE' => 'Start Date',
  'LBL_START_TIME' => 'Start Time:',
  'LBL_LIST_START_TIME' => 'Start Time',
  'DATE_FORMAT' => '(yyyy-mm-dd)',
  'LBL_NONE' => 'None',
  'LBL_CONTACT' => 'Contact:',
  'LBL_EMAIL_ADDRESS' => 'Email Address:',
  'LBL_PHONE' => 'Phone:',
  'LBL_EMAIL' => 'Email Address:',
  'LBL_DESCRIPTION_INFORMATION' => 'Description Information',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_NAME' => 'Name:',
  'LBL_CONTACT_NAME' => 'Contact Name ',
  'LBL_LIST_COMPLETE' => 'Complete:',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_DATE_DUE_FLAG' => 'No Due Date',
  'LBL_DATE_START_FLAG' => 'No Start Date',
  'ERR_DELETE_RECORD' => 'You must specify a record number to delete the contact.',
  'ERR_INVALID_HOUR' => 'Please enter an hour between 0 and 24',
  'LBL_DEFAULT_PRIORITY' => 'Medium',
  'LBL_LIST_MY_TASKS' => 'My Open Tasks',
  'LNK_NEW_TASK' => 'Create Task',
  'LNK_TASK_LIST' => 'View Tasks',
  'LNK_IMPORT_TASKS' => 'Import Tasks',
  'LBL_CONTACT_FIRST_NAME'=>'Contact First Name',
  'LBL_CONTACT_LAST_NAME'=>'Contact Last Name',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assigned User',
  'LBL_ASSIGNED_TO_NAME'=>'Assigned to:',
  'LBL_LIST_DATE_MODIFIED' => 'Date Modified',
  'LBL_CONTACT_ID' => 'Contact ID:',
  'LBL_PARENT_ID' => 'Parent ID:',
  'LBL_CONTACT_PHONE' => 'Contact Phone:',
  'LBL_PARENT_NAME' => 'Parent Type:',
  'LBL_ACTIVITIES_REPORTS' => 'Activities Report',
  'LBL_TASK_INFORMATION' => 'Task Overview',
  'LBL_EDITLAYOUT' => 'Edit Layout' /*for 508 compliance fix*/,
  'LBL_TASK_INFORMATION' => 'Overview',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Notes',
  //For export labels
  'LBL_DATE_DUE' => 'Date Due',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Assigned User Name',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Assigned User ID',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modified By ID',
  'LBL_EXPORT_CREATED_BY' => 'Created By ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Related To Module',
  'LBL_EXPORT_PARENT_ID' => 'Related To ID',
  'LBL_RELATED_TO' => 'Related to:',
);


?>
