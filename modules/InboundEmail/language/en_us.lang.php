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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$mod_strings = array(


	'LBL_RE'					=> 'RE:',

	'ERR_BAD_LOGIN_PASSWORD'=> 'Login or Password Incorrect',
	'ERR_BODY_TOO_LONG'		=> '\rBody text too long to capture FULL email.  Trimmed.',
	'ERR_INI_ZLIB'			=> 'Could not turn off Zlib compression temporarily.  "Test Settings" may fail.',
	'ERR_MAILBOX_FAIL'		=> 'Could not retrieve any mail accounts.',
	'ERR_NO_IMAP'			=> 'No IMAP libraries found.  Please resolve this before continuing with Inbound Email',
	'ERR_NO_OPTS_SAVED'		=> 'No optimums were saved with your Inbound Email account.  Please review the settings',
	'ERR_TEST_MAILBOX'		=> 'Please check your settings and try again.',

	'LBL_APPLY_OPTIMUMS'	=> 'Apply Optimums',
	'LBL_ASSIGN_TO_USER'	=> 'Assign To User',
	'LBL_AUTOREPLY_OPTIONS'	=> 'Auto-Reply Options',
	'LBL_AUTOREPLY'			=> 'Auto-Reply Template',
	'LBL_AUTOREPLY_HELP'	=> 'Select an automated response to notify email senders that their response has been received.',
	'LBL_BASIC'				=> 'Mail Account Information',
	'LBL_CASE_MACRO'		=> 'Case Macro',
	'LBL_CASE_MACRO_DESC'	=> 'Set the macro which will be parsed and used to link imported email to a Case.',
	'LBL_CASE_MACRO_DESC2'	=> 'Set this to any value, but preserve the <b>"%1"</b>.',
	'LBL_CERT_DESC'			=> 'Force validation of the mail server\'s Security Certificate - do not use if self-signing.',
	'LBL_CERT'				=> 'Validate Certificate',
	'LBL_CLOSE_POPUP'		=> 'Close Window',
	'LBL_CREATE_NEW_GROUP'	=> '--Create Group On Save--',
	'LBL_CREATE_TEMPLATE'	=> 'Create',
	'LBL_SUBSCRIBE_FOLDERS'	=> 'Subscribe Folders',
	'LBL_DEFAULT_FROM_ADDR'	=> 'Default: ',
	'LBL_DEFAULT_FROM_NAME'	=> 'Default: ',
	'LBL_DELETE_SEEN'		=> 'Delete Read Emails After Import',
	'LBL_EDIT_TEMPLATE'		=> 'Edit',
	'LBL_EMAIL_OPTIONS'		=> 'Email Handling Options',
	'LBL_EMAIL_BOUNCE_OPTIONS' => 'Bounce Handling Options',
	'LBL_FILTER_DOMAIN_DESC'=> 'Specify a domain to which no auto-replies will be sent.',
	'LBL_ASSIGN_TO_GROUP_FOLDER_DESC'=> 'Select to automatically create email records in Sugar for all incoming emails.',
	'LBL_POSSIBLE_ACTION_DESC'		=> 'For the Create Case option, a Group Folder must be selected',
	'LBL_FILTER_DOMAIN'		=> 'No Auto-Reply to this Domain',
	'LBL_FIND_OPTIMUM_KEY'	=> 'f',
	'LBL_FIND_OPTIMUM_MSG'	=> '<br>Finding optimum connection variables.',
	'LBL_FIND_OPTIMUM_TITLE'=> 'Find Optimum Configuration',
	'LBL_FIND_SSL_WARN'		=> '<br>Testing SSL may take a long time.  Please be patient.<br>',
	'LBL_FORCE_DESC'		=> 'Some IMAP/POP3 servers require special switches. Check to force a negative switch when connecting (i.e., /notls)',
	'LBL_FORCE'				=> 'Force Negative',
	'LBL_FOUND_MAILBOXES'	=> 'Found the following usable folders.<br>Click one to choose it:',
	'LBL_FOUND_OPTIMUM_MSG'	=> '<br>Found optimum settings.  Press the button below to apply them to your mail account.',
	'LBL_FROM_ADDR'			=> '"From" Address',
    // as long as XTemplate doesn't support output escaping, transform
    // quotes to html-entities right here (bug #48913)
    'LBL_FROM_ADDR_DESC'    => "The email address provided here might not appear in the &quot;From&quot; address section of the email sent due to restrictions imposed by the mail service provider. In these circumstances, the email address defined in the outgoing mail server will be used.",
	'LBL_FROM_NAME_ADDR'	=> 'From Name/Email',
	'LBL_FROM_NAME'			=> '"From" Name',
	'LBL_GROUP_QUEUE'		=> 'Assign To Group',
    'LBL_HOME'              => 'Home',
	'LBL_LIST_MAILBOX_TYPE'	=> 'Mail Account Usage',
	'LBL_LIST_NAME'			=> 'Name:',
	'LBL_LIST_GLOBAL_PERSONAL'			=> 'Type',
	'LBL_LIST_SERVER_URL'	=> 'Mail Server',
	'LBL_LIST_STATUS'		=> 'Status',
	'LBL_LOGIN'				=> 'User Name',
	'LBL_MAILBOX_DEFAULT'	=> 'INBOX',
	'LBL_MAILBOX_SSL_DESC'	=> 'Use SSL when connecting. If this does not work, check that your PHP installation included "--with-imap-ssl" in the configuration.',
	'LBL_MAILBOX_SSL'		=> 'Use SSL',
	'LBL_MAILBOX_TYPE'		=> 'Possible Actions',
	'LBL_DISTRIBUTION_METHOD' => 'Distribution Method',
	'LBL_CREATE_CASE_REPLY_TEMPLATE' => 'New Case Auto-Reply Template',
	'LBL_CREATE_CASE_REPLY_TEMPLATE_HELP' => 'Select an automated response to notify email senders that a case has been created. The email contains the case number in the Subject line which adheres to the Case Macro setting.  This response is only sent when the first email is received from the recipient.',
	'LBL_MAILBOX'			=> 'Monitored Folders',
	'LBL_TRASH_FOLDER'		=> 'Trash Folder',
	'LBL_GET_TRASH_FOLDER'	=> 'Get Trash Folder',
	'LBL_SENT_FOLDER'		=> 'Sent Folder',
	'LBL_GET_SENT_FOLDER'	=> 'Get Sent Folder',
	'LBL_SELECT'				=> 'Select',
	'LBL_MARK_READ_DESC'	=> 'Mark messages read on mail server on import; do not delete.',
	'LBL_MARK_READ_NO'		=> 'Email marked deleted after import',
	'LBL_MARK_READ_YES'		=> 'Email left on server after import',
	'LBL_MARK_READ'			=> 'Leave Messages On Server',
	'LBL_MAX_AUTO_REPLIES'	=> 'Number of Auto-responses',
	'LBL_MAX_AUTO_REPLIES_DESC'	=> 'Set the maximum number of auto-responses to send to a unique email address during a period of 24 hours.',
	'LBL_PERSONAL_MODULE_NAME' => 'Personal Mail Account',
	'LBL_CREATE_CASE'      => 'Create Case from Email',
	'LBL_CREATE_CASE_HELP'  => 'Select to automatically create case records in Sugar from incoming emails.',
	'LBL_MODULE_NAME'		=> 'Group Mail Account',
	'LBL_BOUNCE_MODULE_NAME' => 'Bounce Handling Mailbox',
	'LBL_MODULE_TITLE'		=> 'Inbound Email',
	'LBL_NAME'				=> 'Name',
    'LBL_NONE'              => 'None',
	'LBL_NO_OPTIMUMS'		=> 'Could not find optimums.  Please check your settings and try again.',
	'LBL_ONLY_SINCE_DESC'	=> 'When using POP3, PHP cannot filter for New/Unread messages.  This flag allows the request to check for messages since the last time the mail account was polled.  This will significantly improve performance if your mail server does not support IMAP.',
	'LBL_ONLY_SINCE_NO'		=> 'No. Check against all emails on mail server.',
	'LBL_ONLY_SINCE_YES'	=> 'Yes.',
	'LBL_ONLY_SINCE'		=> 'Import Only Since Last Check:',
	'LBL_OUTBOUND_SERVER'	=> 'Outgoing Mail Server',
	'LBL_PASSWORD_CHECK'	=> 'Password Check',
	'LBL_PASSWORD'			=> 'Password',
	'LBL_POP3_SUCCESS'		=> 'Your POP3 test connection was successful.',
	'LBL_POPUP_FAILURE'		=> 'Test connection failed. The error is shown below.',
	'LBL_POPUP_SUCCESS'		=> 'Test connection successful.  Your settings are working.',
	'LBL_POPUP_TITLE'		=> 'Test Settings',
	'LBL_GETTING_FOLDERS_LIST' 		=> 'Getting Folders List',
	'LBL_SELECT_SUBSCRIBED_FOLDERS' 		=> 'Select Subscribed Folder(s)',
	'LBL_SELECT_TRASH_FOLDERS' 		=> 'Select Trash Folder',
	'LBL_SELECT_SENT_FOLDERS' 		=> 'Select Sent Folder',
	'LBL_DELETED_FOLDERS_LIST' 		=> 'The following folder(s) %s either does not exist or has been deleted from server',
	'LBL_PORT'				=> 'Mail Server Port',
	'LBL_QUEUE'				=> 'Mail Account Queue',
	'LBL_REPLY_NAME_ADDR'	=> 'Reply Name/Email',
	'LBL_REPLY_TO_NAME'		=> '"Reply-to" Name',
	'LBL_REPLY_TO_ADDR'		=> '"Reply-to" Address',
	'LBL_SAME_AS_ABOVE'		=> 'Using From Name/Address',
	'LBL_SAVE_RAW'			=> 'Save Raw Source',
	'LBL_SAVE_RAW_DESC_1'	=> 'Select "Yes" if you would like to preserve the raw source for each imported email.',
	'LBL_SAVE_RAW_DESC_2'	=> 'Large attachments can cause failures with conservatively or incorrectly configured databases.',
	'LBL_SERVER_OPTIONS'	=> 'Advanced Setup',
	'LBL_SERVER_TYPE'		=> 'Mail Server Protocol',
	'LBL_SERVER_URL'		=> 'Mail Server Address',
	'LBL_SSL_DESC'			=> 'If your mail server supports secure socket connections, enabling this will force SSL connections when importing email.',
	'LBL_ASSIGN_TO_TEAM_DESC' => 'The selected team has access to the mail account.',
	'LBL_SSL'				=> 'Use SSL',
	'LBL_STATUS'			=> 'Status',
	'LBL_SYSTEM_DEFAULT'	=> 'System Default',
	'LBL_TEST_BUTTON_KEY'	=> 't',
	'LBL_TEST_BUTTON_TITLE'	=> 'Test',
	'LBL_TEST_SETTINGS'		=> 'Test Settings',
	'LBL_TEST_SUCCESSFUL'	=> 'Connection completed successfully.',
	'LBL_TEST_WAIT_MESSAGE'	=> 'One moment please...',
	'LBL_TLS_DESC'			=> 'Use Transport Layer Security when connecting to the mail server - use this only if your mail server supports this protocol.',
	'LBL_TLS'				=> 'Use TLS',
	'LBL_WARN_IMAP_TITLE'	=> 'Inbound Email Disabled',
	'LBL_WARN_IMAP'			=> 'Warnings:',
	'LBL_WARN_NO_IMAP'		=> 'Inbound Email <b>cannot</b> function without the IMAP c-client libraries enabled/compiled with the PHP module.  Please contact your administrator to resolve this issue.',

	'LNK_CREATE_GROUP'		=> 'Create New Group',
	'LNK_LIST_CREATE_NEW_GROUP'	 => 'New Group Mail Account',
	'LNK_LIST_CREATE_NEW_BOUNCE' => 'New Bounce Handling Account',
	'LNK_LIST_MAILBOXES'	=> 'All Mail Accounts',
	'LNK_LIST_QUEUES'		=> 'All Queues',
	'LNK_LIST_SCHEDULER'	=> 'Schedulers',
	'LNK_LIST_TEST_IMPORT'	=> 'Test Email Import',
	'LNK_NEW_QUEUES'		=> 'Create New Queue',
	'LNK_SEED_QUEUES'		=> 'Seed Queues From Teams',
	'LBL_IS_PERSONAL'       => 'Personal Mail Account',
	'LBL_GROUPFOLDER_ID'	=> 'Group Folder Id',
	'LBL_ASSIGN_TO_GROUP_FOLDER' => 'Assign To Group Folder',
    'LBL_ALLOW_OUTBOUND_GROUP_USAGE' => 'Allow users to send emails using the "From" Name and Address as the reply to address',
    'LBL_ALLOW_OUTBOUND_GROUP_USAGE_DESC' => 'When this option is selected, the From Name and From Email Address associated with this group mail account will appear as an option for the From field when composing emails for users that have access to the group mail account.',
    'LBL_STATUS_ACTIVE'     => 'Active',
    'LBL_STATUS_INACTIVE'   => 'Inactive',
    'LBL_IS_PERSONAL' => 'personal',
    'LBL_IS_GROUP' => 'group',
    'LBL_ENABLE_AUTO_IMPORT' => 'Import Emails Automatically',
    'LBL_WARNING_CHANGING_AUTO_IMPORT' => 'Warning: You are modifying your automatic import setting which may result in loss of data.',
    'LBL_WARNING_CHANGING_AUTO_IMPORT_WITH_CREATE_CASE' => 'Warning: Auto import must be enabled when automatically creating cases.',
	'LBL_EDIT_LAYOUT' => 'Edit Layout' /*for 508 compliance fix*/,
);
?>
