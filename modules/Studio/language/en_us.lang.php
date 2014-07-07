<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/






$mod_strings = array (
'LBL_EDIT_LAYOUT'=>'Edit Layout',
'LBL_EDIT_ROWS'=>'Edit Rows',
'LBL_EDIT_COLUMNS'=>'Edit Columns',
'LBL_EDIT_LABELS'=>'Edit Labels',
'LBL_EDIT_FIELDS'=>'Edit Custom Fields',
'LBL_ADD_FIELDS'=>'Add Custom Fields',
'LBL_DISPLAY_HTML'=>'Display HTML Code',
'LBL_SELECT_FILE'=> 'Select File',
'LBL_SAVE_LAYOUT'=> 'Save Layout',
'LBL_SELECT_A_SUBPANEL' => 'Select a Subpanel',
'LBL_SELECT_SUBPANEL' => 'Select Subpanel',
'LBL_MODULE_TITLE' => 'Studio',
'LBL_TOOLBOX' => 'Toolbox',
'LBL_STAGING_AREA' => 'Staging Area (drag and drop items here)',
'LBL_SUGAR_FIELDS_STAGE' => 'Sugar Fields (click items to add to staging area)',
'LBL_SUGAR_BIN_STAGE' => 'Sugar Bin (click items to add to staging area)',
'LBL_VIEW_SUGAR_FIELDS' => 'View Sugar Fields',
'LBL_VIEW_SUGAR_BIN' => 'View Sugar Bin',
'LBL_FAILED_TO_SAVE' => 'Failed To Save',
'LBL_CONFIRM_UNSAVE' => 'Any changes will go unsaved. Are you sure you would like to continue?',
'LBL_PUBLISHING' => 'Publishing ...',
'LBL_PUBLISHED' => 'Published',
'LBL_FAILED_PUBLISHED' => 'Failed to Publish',
'LBL_DROP_HERE' => '[Drop Here]',

//CUSTOM FIELDS
'LBL_NAME'=>'Name',
'LBL_LABEL'=>'Label',
'LBL_MASS_UPDATE'=>'Mass Update',
'LBL_AUDITED'=>'Audit',
'LBL_CUSTOM_MODULE'=>'Module',
'LBL_DEFAULT_VALUE'=>'Default Value',
'LBL_REQUIRED'=>'Required',
'LBL_DATA_TYPE'=>'Type',


'LBL_HISTORY'=>'History',

//WIZARDS
//STUDIO WIZARD
'LBL_SW_WELCOME'=>'<h2>Welcome to Studio!</h2><br> What would you like to do today?<br><b> Please select from the options below.</b>',
'LBL_SW_EDIT_MODULE'=>'Edit a Module',
'LBL_SW_EDIT_DROPDOWNS'=>'Edit Drop Downs',
'LBL_SW_EDIT_TABS'=>'Configure Tabs',
'LBL_SW_RENAME_TABS'=>'Rename Tabs',
'LBL_SW_EDIT_GROUPTABS'=>'Configure Group Tabs',
'LBL_SW_EDIT_PORTAL'=>'Edit Portal',
'LBL_SW_EDIT_WORKFLOW'=>'Edit Workflow',
'LBL_SW_REPAIR_CUSTOMFIELDS'=>'Repair Custom Fields',
'LBL_SW_MIGRATE_CUSTOMFIELDS'=>'Migrate Custom Fields',


//SELECT MODULE WIZARD
'LBL_SMW_WELCOME'=>'<h2>Welcome to Studio!</h2><br><b>Please select a module from below.',

//SELECT MODULE ACTION
'LBL_SMA_WELCOME'=>'<h2>Edit a Module</h2>What do you want to do with that module?<br><b>Please select what action you would like to take.',
'LBL_SMA_EDIT_CUSTOMFIELDS'=>'Edit Custom Fields',
'LBL_SMA_EDIT_LAYOUT'=>'Edit Layout',
'LBL_SMA_EDIT_LABELS' =>'Edit Labels',

//Manager Backups History
'LBL_MB_PREVIEW'=>'Preview',
'LBL_MB_RESTORE'=>'Restore',
'LBL_MB_DELETE'=>'Delete',
'LBL_MB_COMPARE'=>'Compare',
'LBL_MB_WELCOME'=> '<h2>History</h2><br> History allows you to view previously deployed editions of the file you are currently working on. You can compare and restore previous versions. If you do restore a file it will become your working file. You must deploy it before it is visible by everyone else.<br> What would you like to do today?<br><b> Please select from the options below.</b>',

//EDIT DROP DOWNS
'LBL_ED_CREATE_DROPDOWN'=> 'Create a Drop Down',
'LBL_ED_WELCOME'=>'<h2>Drop Down Editor</h2><br><b>You can either edit an existing drop down or create a new drop down.',
'LBL_DROPDOWN_NAME' => 'Dropdown Name:',
'LBL_DROPDOWN_LANGUAGE' => 'Dropdown Language:',
'LBL_TABGROUP_LANGUAGE' => 'Language:',

//EDIT CUSTOM FIELDS
'LBL_EC_WELCOME'=>'<h2>Custom Field Editor</h2><br><b>You can either view and edit an existing custom field, create a new custom field or clean the custom field cache.',
'LBL_EC_VIEW_CUSTOMFIELDS'=> 'View Custom Fields',
'LBL_EC_CREATE_CUSTOMFIELD'=>'Create Custom Field',
'LBL_EC_CLEAR_CACHE'=>'Clear Cache',

//SELECT MODULE
'LBL_SM_WELCOME'=> '<h2>History</h2><br><b>Please select the file you would like to view.</b>',
//END WIZARDS

//DROP DOWN EDITOR
'LBL_DD_DISPALYVALUE'=>'Display Value',
'LBL_DD_DATABASEVALUE'=>'Database Value',
'LBL_DD_ALL'=>'All',

//BUTTONS
'LBL_BTN_SAVE'=>'Save',
'LBL_BTN_CANCEL'=>'Cancel',
'LBL_BTN_SAVEPUBLISH'=>'Save & Deploy',
'LBL_BTN_HISTORY'=>'History',
'LBL_BTN_NEXT'=>'Next',
'LBL_BTN_BACK'=>'Back',
'LBL_BTN_ADDCOLS'=>'Add Columns',
'LBL_BTN_ADDROWS'=>'Add Rows',
'LBL_BTN_UNDO'=>'Undo',
'LBL_BTN_REDO'=>'Redo',
'LBL_BTN_ADDCUSTOMFIELD'=>'Add Custom Field',
'LBL_BTN_TABINDEX'=>'Edit Tabbing Order',

//TABS
'LBL_TAB_SUBTABS'=>'Sub Tabs',
'LBL_MODULES'=>'Modules',
//nsingh: begin bug#15095 fix
'LBL_MODULE_NAME' => 'Administration',
'LBL_CONFIGURE_GROUP_TABS' => 'Configure Module Menu Filters',
 //end bug #15095 fix
'LBL_GROUP_TAB_WELCOME'=>'The filters below will be displayed in the More list in the module menu for users to use to view groups of modules within the menu. Drag and drop modules to and from the filters. Note: Empty filters will not be displayed in the menu.',
'LBL_RENAME_TAB_WELCOME'=>'Click on any tab\'s Display Value in the table below to rename the tab.',
'LBL_DELETE_MODULE'=>'Remove&nbsp;module<br />from&nbsp;filter',
'LBL_DISPLAY_OTHER_TAB_HELP' => 'Select to display the "Other" tab in the navigation bar.  By default, the "Other" tab displays any modules not already included in other groups.',
'LBL_TAB_GROUP_LANGUAGE_HELP' => 'Select an available language, edit the Group labels and click Save & Deploy to apply the labels in the selected language.',
'LBL_ADD_GROUP'=>'Add Filter',
'LBL_NEW_GROUP'=>'New Group',
'LBL_RENAME_TABS'=>'Rename Modules',
'LBL_DISPLAY_OTHER_TAB' => 'Display \'Other\' Tab',

//LIST VIEW EDITOR
'LBL_DEFAULT'=>'Default',
'LBL_ADDITIONAL'=>'Additional',
'LBL_AVAILABLE'=>'Available',
'LBL_LISTVIEW_DESCRIPTION'=>'There are three columns displayed below. The default column contains the fields that are displayed in a list view by default, the additional column contains fields that a user may choose to use for creating a custom view, and the available columns are columns availabe for you as an admin to either add to the default or additional columns for use by users but are currently not used.',
'LBL_LISTVIEW_EDIT'=>'List View Editor',

//ERRORS
'ERROR_ALREADY_EXISTS'=> 'Error: Field Already Exists',
'ERROR_INVALID_KEY_VALUE'=> "Error: Invalid Key Value: [']",

//SUGAR PORTAL
'LBL_SW_SUGARPORTAL'=>'Sugar Portal',
'LBL_SMP_WELCOME'=>' Please select a module you would like to edit from the list below',
'LBL_SP_WELCOME'=>'Welcome to Studio for Sugar Portal. You can either choose to edit modules here or sync to a portal instance.<br> Please choose from the list below.',
'LBL_SP_SYNC'=>'Portal Sync',
'LBL_SYNCP_WELCOME'=>'Please enter the url to the portal instance you wish to update then press the Go button.<br> This will bring up a prompt for your user name and password.<br> Please enter your Sugar user name and password and press the Begin Sync button.',
'LBL_LISTVIEWP_DESCRIPTION'=>'There are two columns below: Default which are the fields that will be displayed and Available which are the fields that are not displayed, but are available for displaying. Just drag the fields between the two columns. You can also reorder the items in a column by dragging and dropping them.',
'LBL_SP_STYLESHEET'=>'Upload a Style Sheet',
'LBL_SP_UPLOADSTYLE'=>'Click on the browse button and select a style sheet from your computer to upload.<br> The next time you sync down to portal it will bring down the style sheet along with it.',
'LBL_SP_UPLOADED'=> 'Uploaded',
'ERROR_SP_UPLOADED'=>'Please ensure that you are uploading a css style sheet.',
'LBL_SP_PREVIEW'=>'Here is a preview of what your style sheet will look like',

	'LBL_SAVE' => 'Save' /*for 508 compliance fix*/,
	'LBL_UNDO' => 'Undo' /*for 508 compliance fix*/,
	'LBL_REDO' => 'Redo' /*for 508 compliance fix*/,
	'LBL_INLINE' => 'Inline' /*for 508 compliance fix*/,
	'LBL_DELETE' => 'Delete' /*for 508 compliance fix*/,
	'LBL_ADD_FIELD' => 'Add Field' /*for 508 compliance fix*/,
	'LBL_MAXIMIZE' => 'Maximize' /*for 508 compliance fix*/,
	'LBL_MINIMIZE' => 'Minimize' /*for 508 compliance fix*/,
	'LBL_PUBLISH' => 'Publish' /*for 508 compliance fix*/,
	'LBL_ADDROWS' => 'Add Rows' /*for 508 compliance fix*/,
	'LBL_ADDFIELD' => 'Add Field' /*for 508 compliance fix*/,
	'LBL_EDIT' => 'Edit' /*for 508 compliance fix*/,

'LBL_LANGUAGE_TOOLTIP' => 'Select the language to edit.',
'LBL_SINGULAR' => 'Singular Label',
'LBL_PLURAL' => 'Plural Label',
'LBL_RENAME_MOD_SAVE_HELP' => 'Click <b>Save</b> to apply the changes.'

);
?>