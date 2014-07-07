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

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/

$mod_strings = array(
	'DESC_MODULES_INSTALLED'					=> 'The following modules have been installed:',
	'DESC_MODULES_QUEUED'						=> 'The following modules are ready to be installed:',

	'ERR_UW_CANNOT_DETERMINE_GROUP'				=> 'Cannot determine Group',
	'ERR_UW_CANNOT_DETERMINE_USER'				=> 'Cannot determine Owner',
	'ERR_UW_CONFIG_WRITE'						=> 'Error updating config.php with new version information.',
	'ERR_UW_CONFIG'								=> 'Please make your config.php file writable and reload this page.',
	'ERR_UW_DIR_NOT_WRITABLE'					=> 'Directory not writable',
	'ERR_UW_FILE_NOT_COPIED'					=> 'File not copied',
	'ERR_UW_FILE_NOT_DELETED'					=> 'Problem removing package ',
	'ERR_UW_FILE_NOT_READABLE'					=> 'File could not be read.',
	'ERR_UW_FILE_NOT_WRITABLE'					=> 'File cannot be moved or written to',
	'ERR_UW_FLAVOR_2'							=> 'Upgrade Flavor: ',
	'ERR_UW_FLAVOR'								=> 'SuiteCRM System Flavor: ',
	'ERR_UW_LOG_FILE_UNWRITABLE'				=> './upgradeWizard.log could not be created/written to.  Please fix permissions on your SuiteCRM directory.',
	'ERR_UW_MBSTRING_FUNC_OVERLOAD'				=> 'mbstring.func_overload set to a value higher than 1.  Please change this in your php.ini and restart the web server.',
	'ERR_UW_MYSQL_VERSION'						=> 'SuiteCRM requires MySQL version 4.1.2 or newer.  Found: ',
	'ERR_UW_OCI8_VERSION'				        => 'Your version of Oracle is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported Oracle Versions. Current version: ',
	'ERR_UW_NO_FILE_UPLOADED'					=> 'Please specify a file and try again!',
	'ERR_UW_NO_FILES'							=> 'An error occurred, no files were found to check.',
	'ERR_UW_NO_MANIFEST'						=> 'The zip file is missing a manifest.php file.  Cannot proceed.',
	'ERR_UW_NO_VIEW'							=> 'Invalid view specified.',
	'ERR_UW_NO_VIEW2'							=> 'View not defined.  Please go to the Administration home to navigate to this page.',
	'ERR_UW_NOT_VALID_UPLOAD'					=> 'Not valid upload.',
	'ERR_UW_NO_CREATE_TMP_DIR'					=> 'Could not create the temp directory. Check file permissions.',
	'ERR_UW_ONLY_PATCHES'						=> 'You can only upload patches on this page.',
	'ERR_UW_PREFLIGHT_ERRORS'					=> 'Errors Found During Preflight Check',
	'ERR_UW_UPLOAD_ERR'							=> 'There was an error uploading the file, please try again!<br>\n',
	'ERR_UW_VERSION'							=> 'SuiteCRM System Version: ',
	'ERR_UW_WRONG_TYPE'							=> 'This page is not for running ',
	'ERR_UW_PHP_FILE_ERRORS'					=> array(
													1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
													2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
													3 => 'The uploaded file was only partially uploaded.',
													4 => 'No file was uploaded.',
													5 => 'Unknown error.',
													6 => 'Missing a temporary folder.',
													7 => 'Failed to write file to disk.',
													8 => 'File upload stopped by extension.',
),
	'LBL_BUTTON_BACK'							=> '< Back',
	'LBL_BUTTON_CANCEL'							=> 'Cancel',
	'LBL_BUTTON_DELETE'							=> 'Delete Package',
	'LBL_BUTTON_DONE'							=> 'Done',
	'LBL_BUTTON_EXIT'							=> 'Exit',
	'LBL_BUTTON_INSTALL'						=> 'Preflight Upgrade',
	'LBL_BUTTON_NEXT'							=> 'Next >',
	'LBL_BUTTON_RECHECK'						=> 'Recheck',
	'LBL_BUTTON_RESTART'						=> 'Restart',

	'LBL_UPLOAD_UPGRADE'						=> 'Upload Upgrade Package ',
	'LBL_UPLOAD_FILE_NOT_FOUND'					=> 'Upload file not found',
	'LBL_UW_BACKUP_FILES_EXIST_TITLE'			=> 'File Backup',
	'LBL_UW_BACKUP_FILES_EXIST'					=> 'Backed-up files from this upgrade can be found in',
	'LBL_UW_BACKUP'								=> 'File BACKUP',
	'LBL_UW_CANCEL_DESC'						=> 'The upgrade has been cancelled. Any temporary files that were copied and any upgrade files that were uploaded have been deleted.',
	'LBL_UW_CHARSET_SCHEMA_CHANGE'				=> 'Character Set Schema Changes',
	'LBL_UW_CHECK_ALL'							=> 'Check All',
	'LBL_UW_CHECKLIST'							=> 'Upgrade Steps',
	'LBL_UW_COMMIT_ADD_TASK_DESC_1'				=> "Backups of Overwritten Files are in the following directory: \n",
	'LBL_UW_COMMIT_ADD_TASK_DESC_2'				=> "Manually merge the following files:\n",
	'LBL_UW_COMMIT_ADD_TASK_NAME'				=> 'Upgrade Process: Manually Merge Files',
	'LBL_UW_COMMIT_ADD_TASK_OVERVIEW'			=> 'Please use whichever diff method is most familiar to you to merge these files.  Until this is complete, your SuiteCRM installation will be in an uncertain state, and the upgrade incomplete.',
	'LBL_UW_COMPLETE'							=> 'Complete',
	'LBL_UW_CONTINUE_CONFIRMATION'              => 'This new version of SuiteCRM contains new license agreement.  Would you like to continue?',
	'LBL_UW_COMPLIANCE_ALL_OK'					=> 'All System Settings Requirements Satisfied',
	'LBL_UW_COMPLIANCE_CALLTIME'				=> 'PHP Setting: Call Time Pass By Reference',
	'LBL_UW_COMPLIANCE_CURL'					=> 'cURL Module',
	'LBL_UW_COMPLIANCE_IMAP'					=> 'IMAP Module',
	'LBL_UW_COMPLIANCE_MBSTRING'				=> 'MBStrings Module',
	'LBL_UW_COMPLIANCE_MBSTRING_FUNC_OVERLOAD'	=> 'MBStrings mbstring.func_overload Parameter',
	'LBL_UW_COMPLIANCE_MEMORY'					=> 'PHP Setting: Memory Limit',
    'LBL_UW_COMPLIANCE_STREAM'                  => 'PHP Setting: Stream',
	'LBL_UW_COMPLIANCE_MSSQL_MAGIC_QUOTES'		=> 'MS SQL Server & PHP Magic Quotes GPC',
	'LBL_UW_COMPLIANCE_MYSQL'					=> 'Minimum MySQL Version',
    'LBL_UW_COMPLIANCE_DB'                      => 'Minimum Database Version',
	'LBL_UW_COMPLIANCE_PHP_INI'					=> 'Location of php.ini',
	'LBL_UW_COMPLIANCE_PHP_VERSION'				=> 'Minimum PHP Version',
	'LBL_UW_COMPLIANCE_SAFEMODE'				=> 'PHP Setting: Safe Mode',
	'LBL_UW_COMPLIANCE_TITLE'					=> 'Server Settings Check',
	'LBL_UW_COMPLIANCE_TITLE2'					=> 'Detected Settings',
	'LBL_UW_COMPLIANCE_XML'						=> 'XML Parsing',
	'LBL_UW_COMPLIANCE_ZIPARCHIVE'				=> 'Zip Support',
	'LBL_UW_COMPLIANCE_PCRE_VERSION'			=> 'PCRE Version',

	'LBL_UW_COPIED_FILES_TITLE'					=> 'Files Copied Successfully',
	'LBL_UW_CUSTOM_TABLE_SCHEMA_CHANGE'			=> 'Custom Table Schema Changes',

	'LBL_UW_DB_CHOICE1'							=> 'Upgrade Wizard Runs SQL',
	'LBL_UW_DB_CHOICE2'							=> 'Manual SQL Queries',
	'LBL_UW_DB_INSERT_FAILED'					=> 'INSERT failed - compared results differ',
	'LBL_UW_DB_ISSUES_PERMS'					=> 'Database Privileges',
	'LBL_UW_DB_ISSUES'							=> 'Database Issues',
	'LBL_UW_DB_METHOD'							=> 'Database Update Method',
	'LBL_UW_DB_NO_ADD_COLUMN'					=> 'ALTER TABLE [table] ADD COLUMN [column]',
	'LBL_UW_DB_NO_CHANGE_COLUMN'				=> 'ALTER TABLE [table] CHANGE COLUMN [column]',
	'LBL_UW_DB_NO_CREATE'						=> 'CREATE TABLE [table]',
	'LBL_UW_DB_NO_DELETE'						=> 'DELETE FROM [table]',
	'LBL_UW_DB_NO_DROP_COLUMN'					=> 'ALTER TABLE [table] DROP COLUMN [column]',
	'LBL_UW_DB_NO_DROP_TABLE'					=> 'DROP TABLE [table]',
	'LBL_UW_DB_NO_ERRORS'						=> 'All Privileges Available',
	'LBL_UW_DB_NO_INSERT'						=> 'INSERT INTO [table]',
	'LBL_UW_DB_NO_SELECT'						=> 'SELECT [x] FROM [table]',
	'LBL_UW_DB_NO_UPDATE'						=> 'UPDATE [table]',
	'LBL_UW_DB_PERMS'							=> 'Necessary Privilege',

	'LBL_UW_DESC_MODULES_INSTALLED'				=> 'The following upgrade packages have been installed:',
	'LBL_UW_END_DESC'							=> 'The system has been upgraded.',
	'LBL_UW_END_DESC2'							=> 'If you have chosen to manually run any steps such as file merges or SQL queries, please do this now.  Your system will be in an unstable state until those steps are completed.',
	'LBL_UW_END_LOGOUT_PRE'						=> 'The upgrade is complete.',
	'LBL_UW_END_LOGOUT_PRE2'					=> 'Click Done to exit the Upgrade Wizard.',
	'LBL_UW_END_LOGOUT'							=> 'If you plan to apply another upgrade package using the Upgrade Wizard, log out and log back in prior to doing so.',
	'LBL_UW_END_LOGOUT2'						=> 'Logout',
	'LBL_UW_REPAIR_INDEX'						=> 'For database performance improvements, please run the <a href="index.php?module=Administration&action=RepairIndex" target="_blank">Repair Index</a> script.',

	'LBL_UW_FILE_DELETED'						=> " has been removed.<br>",
	'LBL_UW_FILE_GROUP'							=> 'Group',
	'LBL_UW_FILE_ISSUES_PERMS'					=> 'File Permissions',
	'LBL_UW_FILE_ISSUES'						=> 'File Issues',
	'LBL_UW_FILE_NEEDS_DIFF'					=> 'File Requires Manual Diff',
	'LBL_UW_FILE_NO_ERRORS'						=> '<b>All Files Writable</b>',
	'LBL_UW_FILE_OWNER'							=> 'Owner',
	'LBL_UW_FILE_PERMS'							=> 'Permissions',
	'LBL_UW_FILE_UPLOADED'						=> ' has been uploaded',
	'LBL_UW_FILE'								=> 'File Name',
	'LBL_UW_FILES_QUEUED'						=> 'The following upgrade packages are ready to be installed:',
	'LBL_UW_FILES_REMOVED'						=> "The following files will be removed from the system:<br>\n",
	'LBL_UW_NEXT_TO_UPLOAD'						=> "<b>Click Next to upload upgrade packages.</b>",
	'LBL_UW_FROZEN'								=> 'Upload a package before continuing.',
	'LBL_UW_HIDE_DETAILS'						=> 'Hide Details',
	'LBL_UW_IN_PROGRESS'						=> 'In Progress',
	'LBL_UW_INCLUDING'							=> 'Including',
	'LBL_UW_INCOMPLETE'							=> 'Incomplete',
	'LBL_UW_INSTALL'							=> 'File INSTALL',
	'LBL_UW_MANUAL_MERGE'						=> 'File Merge',
	'LBL_UW_MODULE_READY_UNINSTALL'				=> "Module is ready to be uninstalled.  Click \"Commit\" to proceed with uninstallation.<br>\n",
	'LBL_UW_MODULE_READY'						=> "Module is ready to be installed.  Click \"Commit\" to proceed with installation.",
	'LBL_UW_NO_INSTALLED_UPGRADES'				=> 'No recorded Upgrades detected.',
	'LBL_UW_NONE'								=> 'None',
	'LBL_UW_NOT_AVAILABLE'						=> 'Not available',
	'LBL_UW_OVERWRITE_DESC'						=> "All changed files will be overwritten, including any code customizations and template changes you have made. Are you sure you want to proceed?",
	'LBL_UW_OVERWRITE_FILES_CHOICE1'			=> 'Overwrite All Files',
	'LBL_UW_OVERWRITE_FILES_CHOICE2'			=> 'Manual Merge - Preserve All',
	'LBL_UW_OVERWRITE_FILES'					=> 'Merge Method',
	'LBL_UW_PATCH_READY'						=> 'The patch is ready to proceed. Click the "Commit" button below to complete the upgrade process.',
	'LBL_UW_PATCH_READY2'						=> '<h2>Notice: Customized Layouts Found</h2><br />The following file(s) have new fields or modified screen layouts applied via the Studio. The patch you are about to install also contains changes to the file(s). For <u>each file</u> you may:<br><ul><li>[<b>Default</b>] Retain your version by leaving the checkbox blank. The patch modifications will be ignored.</li>or<li>Accept the updated files by selecting the checkbox. Your layouts will need to be re-applied via Studio.</li></ul>',

	'LBL_UW_PREFLIGHT_ADD_TASK'					=> 'Create Task Item for Manual Merge?',
	'LBL_UW_PREFLIGHT_COMPLETE'					=> 'Preflight Check',
	'LBL_UW_PREFLIGHT_DIFF'						=> 'Differentiated ',
	'LBL_UW_PREFLIGHT_EMAIL_REMINDER'			=> 'Email Yourself a Reminder for Manual Merge?',
	'LBL_UW_PREFLIGHT_FILES_DESC'				=> 'The files listed below have been modified.  Uncheck items that require a manual merge. <i>Any detected layout changes are automatically unchecked; checkmark any that should be overwritten.',
	'LBL_UW_PREFLIGHT_NO_DIFFS'					=> 'No Manual File Merge Required.',
	'LBL_UW_PREFLIGHT_NOT_NEEDED'				=> 'Not needed.',
	'LBL_UW_PREFLIGHT_PRESERVE_FILES'			=> 'Auto-preserved Files:',
	'LBL_UW_PREFLIGHT_TESTS_PASSED'				=> 'All preflight tests have passed.',
	'LBL_UW_PREFLIGHT_TESTS_PASSED2'			=> 'Click Next to copy the upgraded files to the system.',
	'LBL_UW_PREFLIGHT_TESTS_PASSED3'			=> '<b>Note: </b> The rest of the upgrade process is mandatory, and clicking Next will require you to complete the process. If you do not wish to proceed, click the Cancel button.',
	'LBL_UW_PREFLIGHT_TOGGLE_ALL'				=> 'Toggle All Files',

	'LBL_UW_REBUILD_TITLE'						=> 'Rebuild Result',
	'LBL_UW_SCHEMA_CHANGE'						=> 'Schema Changes',

	'LBL_UW_SHOW_COMPLIANCE'					=> 'Show Detected Settings',
	'LBL_UW_SHOW_DB_PERMS'						=> 'Show Missing Database Permissions',
	'LBL_UW_SHOW_DETAILS'						=> 'Show Details',
	'LBL_UW_SHOW_DIFFS'							=> 'Show Files Requiring Manual Merge',
	'LBL_UW_SHOW_NW_FILES'						=> 'Show Files with Bad Permissions',
	'LBL_UW_SHOW_SCHEMA'						=> 'Show Schema Change Script',
	'LBL_UW_SHOW_SQL_ERRORS'					=> 'Show Bad Queries',
	'LBL_UW_SHOW'								=> 'Show',

	'LBL_UW_SKIPPED_FILES_TITLE'				=> 'Skipped Files',
	'LBL_UW_SKIPPING_FILE_OVERWRITE'			=> 'Skipping File Overwrites - Manual Merge Selected.',
	'LBL_UW_SQL_RUN'							=> 'Check when SQL has been manually run',
	'LBL_UW_START_DESC'							=> 'This wizard will assist you in upgrading this SuiteCRM instance.',
	'LBL_UW_START_DESC2'						=> 'Note: We recommend that you backup the SuiteCRM database and the system files (all of the files in the SuiteCRM folder) before upgrading your production system. We highly recommend that you perform a test upgrade on a cloned instance of your production system first.',
	'LBL_UW_START_DESC3'						=> 'Click Next to perform a check on your system to make sure that the system is ready for the upgrade. The check includes file permissions, database privileges and server settings.',
	'LBL_UW_START_UPGRADED_UW_DESC'				=> 'The new Upgrade Wizard will now resume the upgrade process. Please continue your upgrade.',
	'LBL_UW_START_UPGRADED_UW_TITLE'			=> 'Welcome to the new Upgrade Wizard',

	'LBL_UW_SYSTEM_CHECK_CHECKING'				=> 'Now checking, please wait.  This could take up to 30 seconds.',
	'LBL_UW_SYSTEM_CHECK_FILE_CHECK_START'		=> 'Finding all pertinent files to check.',
	'LBL_UW_SYSTEM_CHECK_FILES'					=> 'Files',
	'LBL_UW_SYSTEM_CHECK_FOUND'					=> 'Found',

	'LBL_UW_TITLE_CANCEL'						=> 'Cancel',
	'LBL_UW_TITLE_COMMIT'						=> 'Commit Upgrade',
	'LBL_UW_TITLE_END'							=> 'Debrief',
	'LBL_UW_TITLE_PREFLIGHT'					=> 'Preflight Check',
	'LBL_UW_TITLE_START'						=> 'Welcome',
	'LBL_UW_TITLE_SYSTEM_CHECK'					=> 'System Check',
	'LBL_UW_TITLE_UPLOAD'						=> 'Upload Package',
	'LBL_UW_TITLE'								=> 'Upgrade Wizard',
	'LBL_UW_UNINSTALL'							=> 'Uninstall',
	//500 upgrade labels
	'LBL_UW_ACCEPT_THE_LICENSE' 				=> 'Accept License',
	'LBL_UW_CONVERT_THE_LICENSE' 				=> 'Convert License',
	'LBL_UW_CUSTOMIZED_OR_UPGRADED_MODULES'     => 'Upgraded/Customized Modules',
	'LBL_UW_FOLLOWING_MODULES_CUSTOMIZED'       => 'The following modules are detected as customized and preserved',
	'LBL_UW_FOLLOWING_MODULES_UPGRADED'         => 'The following modules are detected as Studio-customized and have been upgraded',

	'LBL_UW_SUGAR_COMMUNITY_EDITION_LICENSE'    => 'The SuiteCRM Community Edition 5.0 uses GNU Affero General Public License version 3. This upgrade will convert your existing license to the new license displayed below.',


	'LBL_START_UPGRADE_IN_PROGRESS'             => 'Start in progress',
	'LBL_SYSTEM_CHECKS_IN_PROGRESS'             => 'System Check in Progress',
	'LBL_LICENSE_CHECK_IN_PROGRESS'             => 'License Check in progress',
	'LBL_PREFLIGHT_CHECK_IN_PROGRESS'           => 'Preflight Check in Progress',
    'LBL_PREFLIGHT_FILE_COPYING_PROGRESS'       => 'File Copying in Progress',
	'LBL_COMMIT_UPGRADE_IN_PROGRESS'            => 'Commit Upgrade in Progress',
    'LBL_UW_COMMIT_DESC'						=> 'Click Next to run additional upgrade scripts.',
	'LBL_UPGRADE_SCRIPTS_IN_PROGRESS'			=> 'Upgrade Scripts in Progress',
	'LBL_UPGRADE_SUMMARY_IN_PROGRESS'			=> 'Upgrade Summary in Progress',
	'LBL_UPGRADE_IN_PROGRESS'                   => 'in progress     ',
	'LBL_UPGRADE_TIME_ELAPSED'                  => 'Time elapsed',
	'LBL_UPGRADE_CANCEL_IN_PROGRESS'			=> 'Upgrade Cancel and Cleanup in Progress',
    'LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE'      => 'Upgrade may take some time',
    'LBL_UPLOADE_UPGRADE_IN_PROGRESS'           => 'Upload Checks in Progress',
	'LBL_UPLOADING_UPGRADE_PACKAGE'      		=> 'Uploading Upgrade Package ',
    'LBL_UW_DORP_THE_OLD_SCHMEA' 				=> 'Would you like SuiteCRM to drop the depricated 451 Schema ?',
	'LBL_UW_DROP_SCHEMA_UPGRADE_WIZARD'			=> 'Upgrade Wizard Drops old 451 schema',
	'LBL_UW_DROP_SCHEMA_MANUAL'					=> 'Manual Drop Schema Post Upgrade',
	'LBL_UW_DROP_SCHEMA_METHOD'					=> 'Old Schema Drop Method',
	'LBL_UW_SHOW_OLD_SCHEMA_TO_DROP'			=> 'Show Old Schema that could be dropped',
	'LBL_UW_SKIPPED_QUERIES_ALREADY_EXIST'      => 'Skipped Queries',
	'LBL_INCOMPATIBLE_PHP_VERSION'              => 'Php version 5 or above is required.',
	'ERR_CHECKSYS_PHP_INVALID_VER'      => 'Your version of PHP is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported PHP Versions. Your version is ',
	'LBL_BACKWARD_COMPATIBILITY_ON' 			=> 'Php Backward Compatibility mode is turned on. Set zend.ze1_compatibility_mode to Off for proceeding further',
	//including some strings from moduleinstall that are used in Upgrade
	'LBL_ML_ACTION' => 'Action',
    'LBL_ML_CANCEL'             => 'Cancel',
    'LBL_ML_COMMIT'=>'Commit',
    'LBL_ML_DESCRIPTION' => 'Description',
    'LBL_ML_INSTALLED' => 'Date Installed',
    'LBL_ML_NAME' => 'Name',
    'LBL_ML_PUBLISHED' => 'Date Published',
    'LBL_ML_TYPE' => 'Type',
    'LBL_ML_UNINSTALLABLE' => 'Uninstallable',
    'LBL_ML_VERSION' => 'Version',
	'LBL_ML_INSTALL'=>'Install',
	//adding the string used in tracker. copying from homepage
	'LBL_HOME_PAGE_4_NAME' => 'Tracker',
	'LBL_CURRENT_PHP_VERSION' => '(Your current php version is ',
	'LBL_RECOMMENDED_PHP_VERSION' => '. Recommended php version is 5.2.2 or above)',
	'LBL_MODULE_NAME' => 'UpgradeWizard',
	'LBL_UPLOAD_SUCCESS' => 'Upgrade package successfully uploaded. Click Next to perform a final check.',
	'LBL_UW_TITLE_LAYOUTS' => 'Confirm Layouts',
	'LBL_LAYOUT_MODULE_TITLE' => 'Layouts',
	'LBL_LAYOUT_MERGE_DESC' => 'There are new fields available which have been added as part of this upgrade and can be automatically appended to your existing module layouts.  To learn more about the new fields, please refer to the Release Notes for the version to which you are upgrading.<br><br>If you do not wish to append the new fields, please uncheck the module, and your custom layouts will remain unchanged. The fields will be available in Studio after the upgrade. <br><br>',
	'LBL_LAYOUT_MERGE_TITLE' => 'Click Next to confirm changes and to finish the upgrade.',
	'LBL_LAYOUT_MERGE_TITLE2' => 'Click Next to complete the upgrade.',
	'LBL_UW_CONFIRM_LAYOUTS' => 'Confirm Layouts',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS' => 'Confirm Layout Results',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS_DESC' => 'The following layouts were merged successfully:',
	'LBL_SELECT_FILE' => 'Select File:',
    'ERROR_VERSION_INCOMPATIBLE' => 'The uploaded file is not compatible with this version of SuiteCRM: ',
    'ERROR_FLAVOR_INCOMPATIBLE'  => 'The uploaded file is not compatible with this flavor (Community Edition, Professional, or Enterprise) of SuiteCRM: ',
	'LBL_LANGPACKS' => 'Language Packs' /*for 508 compliance fix*/,
	'LBL_MODULELOADER' => 'Module Loader' /*for 508 compliance fix*/,
	'LBL_PATCHUPGRADES' => 'Patch Upgrades' /*for 508 compliance fix*/,
	'LBL_THEMES' => 'Themes' /*for 508 compliance fix*/,
	'LBL_WORKFLOW' => 'Workflow' /*for 508 compliance fix*/,
	'LBL_UPGRADE' => 'Upgrade' /*for 508 compliance fix*/,
	'LBL_PROCESSING' => 'Processing' /*for 508 compliance fix*/,
);
