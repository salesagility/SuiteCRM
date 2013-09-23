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
	'LBL_MODULE_NAME' => 'Project',
	'LBL_MODULE_TITLE' => 'Projects: Home',
	'LBL_SEARCH_FORM_TITLE' => 'Project Search',
    'LBL_LIST_FORM_TITLE' => 'Project List',
    'LBL_HISTORY_TITLE' => 'History',

	'LBL_ID' => 'Id:',
	'LBL_DATE_ENTERED' => 'Date Created:',
	'LBL_DATE_MODIFIED' => 'Date Modified:',
	'LBL_ASSIGNED_USER_ID' => 'Assigned To:',
    'LBL_ASSIGNED_USER_NAME' => 'Assigned to:',
	'LBL_MODIFIED_USER_ID' => 'Modified User Id:',
	'LBL_CREATED_BY' => 'Created By:',
	'LBL_TEAM_ID' => 'Team:',
	'LBL_NAME' => 'Name:',
    'LBL_PDF_PROJECT_NAME' => 'Project Name:',
	'LBL_DESCRIPTION' => 'Description:',
	'LBL_DELETED' => 'Deleted:',
    'LBL_DATE' => 'Date:',
	'LBL_DATE_START' => 'Start Date:',
	'LBL_DATE_END' => 'End Date:',
	'LBL_PRIORITY' => 'Priority:',
    'LBL_STATUS' => 'Status:',
    'LBL_MY_PROJECTS' => 'My Projects',
    'LBL_MY_PROJECT_TASKS' => 'My Project Tasks',
    
	'LBL_TOTAL_ESTIMATED_EFFORT' => 'Total Estimated Effort (hrs):',
	'LBL_TOTAL_ACTUAL_EFFORT' => 'Total Actual Effort (hrs):',

	'LBL_LIST_NAME' => 'Name',
    'LBL_LIST_DAYS' => 'days',
	'LBL_LIST_ASSIGNED_USER_ID' => 'Assigned To',
	'LBL_LIST_TOTAL_ESTIMATED_EFFORT' => 'Total Estimated Effort (hrs)',
	'LBL_LIST_TOTAL_ACTUAL_EFFORT' => 'Total Actual Effort (hrs)',
    'LBL_LIST_UPCOMING_TASKS' => 'Upcoming Tasks (1 Week)',
    'LBL_LIST_OVERDUE_TASKS' => 'Overdue Tasks',
    'LBL_LIST_OPEN_CASES' => 'Open Cases',
    'LBL_LIST_END_DATE' => 'End Date',
    'LBL_LIST_TEAM_ID' => 'Team',
    

	'LBL_PROJECT_SUBPANEL_TITLE' => 'Projects',
	'LBL_PROJECT_TASK_SUBPANEL_TITLE' => 'Project Tasks',
	'LBL_CONTACT_SUBPANEL_TITLE' => 'Contacts',
	'LBL_ACCOUNT_SUBPANEL_TITLE' => 'Accounts',
	'LBL_OPPORTUNITY_SUBPANEL_TITLE' => 'Opportunities',
	'LBL_QUOTE_SUBPANEL_TITLE' => 'Quotes',

    // quick create label
    'LBL_NEW_FORM_TITLE' => 'New Project',

	'CONTACT_REMOVE_PROJECT_CONFIRM' => 'Are you sure you want to remove this contact from this project?',

	'LNK_NEW_PROJECT'	=> 'Create Project',
	'LNK_PROJECT_LIST'	=> 'View Project List',
	'LNK_NEW_PROJECT_TASK'	=> 'Create Project Task',
	'LNK_PROJECT_TASK_LIST'	=> 'View Project Tasks',
	
	'LBL_DEFAULT_SUBPANEL_TITLE' => 'Projects',
	'LBL_ACTIVITIES_TITLE'=>'Activities',
    'LBL_ACTIVITIES_SUBPANEL_TITLE'=>'Activities',
	'LBL_HISTORY_SUBPANEL_TITLE'=>'History',
	'LBL_QUICK_NEW_PROJECT'	=> 'New Project',
	
	'LBL_PROJECT_TASKS_SUBPANEL_TITLE' => 'Project Tasks',
	'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contacts',
	'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Accounts',
	'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Opportunities',
    'LBL_CASES_SUBPANEL_TITLE' => 'Cases',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Bugs',
    'LBL_PRODUCTS_SUBPANEL_TITLE' => 'Products',
    

    'LBL_TASK_ID' => 'ID',
    'LBL_TASK_NAME' => 'Task Name',
    'LBL_DURATION' => 'Duration',
    'LBL_ACTUAL_DURATION' => 'Actual Duration',
    'LBL_START' => 'Start',
    'LBL_FINISH' => 'Finish',
    'LBL_PREDECESSORS' => 'Predecessors',
    'LBL_PERCENT_COMPLETE' => '% Complete',
    'LBL_MORE'  => 'More...',

    'LBL_PERCENT_BUSY' => '% Busy',
    'LBL_TASK_ID_WIDGET' => 'id',
    'LBL_TASK_NAME_WIDGET' => 'description',
    'LBL_DURATION_WIDGET' => 'duration',
    'LBL_START_WIDGET' => 'date_start',
    'LBL_FINISH_WIDGET' => 'date_finish',
    'LBL_PREDECESSORS_WIDGET' => 'predecessors_',
    'LBL_PERCENT_COMPLETE_WIDGET' => 'percent_complete',
    'LBL_EDIT_PROJECT_TASKS_TITLE'=> 'Edit Project Tasks',
    
    'LBL_OPPORTUNITIES' => 'Opportunities',
	'LBL_LAST_WEEK' => 'Previous',
	'LBL_NEXT_WEEK' => 'Next',
	'LBL_PROJECTRESOURCES_SUBPANEL_TITLE' => 'Project Resources',
	'LBL_PROJECTTASK_SUBPANEL_TITLE' => 'Project Task',
	'LBL_HOLIDAYS_SUBPANEL_TITLE' => 'Holidays',
	'LBL_PROJECT_INFORMATION' => 'Project Overview',
	'LBL_EDITLAYOUT' => 'Edit Layout' /*for 508 compliance fix*/,
	'LBL_INSERTROWS' => 'Insert Rows' /*for 508 compliance fix*/,
	'LBL_PROJECT_INFORMATION' => 'Overview',

);
?>