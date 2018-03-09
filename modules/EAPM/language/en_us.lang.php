<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    'LBL_ASSIGNED_TO_ID' => 'Assigned User Id',
    'LBL_ASSIGNED_TO_NAME' => 'SuiteCRM User',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_NAME' => 'Modified By Name',
    'LBL_CREATED' => 'Created By',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_DELETED' => 'Deleted',
    'LBL_NAME' => 'App User Name',
    'LBL_CREATED_USER' => 'Created By User',
    'LBL_MODIFIED_USER' => 'Modified By User',
    'LBL_LIST_NAME' => 'Name',
    'LBL_LIST_FORM_TITLE' => 'External Account List',
    'LBL_MODULE_NAME' => 'External Account',
    'LBL_MODULE_TITLE' => 'External Accounts',
    'LBL_HOMEPAGE_TITLE' => 'My External Accounts',
    'LNK_NEW_RECORD' => 'Create External Account',
    'LNK_LIST' => 'View External Accounts',
    'LBL_SEARCH_FORM_TITLE' => 'Search External Source',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'View History',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activities',
    'LBL_NEW_FORM_TITLE' => 'New External Account',
    'LBL_PASSWORD' => 'App Password',
    'LBL_USER_NAME' => 'App User Name',
    'LBL_URL' => 'URL',
    'LBL_APPLICATION' => 'Application',
    'LBL_API_DATA' => 'API Data',
    'LBL_API_CONSKEY' => 'Consumer Key',
    'LBL_API_CONSSECRET' => 'Consumer Secret',
    'LBL_API_OAUTHTOKEN' => 'OAuth Token',
    'LBL_AUTH_UNSUPPORTED' => "This authorization method is not supported by the application",
    'LBL_AUTH_ERROR' => 'The attempt to connect to this account failed.',
    'LBL_VALIDATED' => 'Connected',
    'LBL_ACTIVE' => 'Active',
    'LBL_OAUTH_NAME' => '%s',
    'LBL_CONNECT_BUTTON_TITLE' => 'Connect',
    'LBL_NOTE' => 'Please Note',
    'LBL_CONNECTED' => 'Connected',

    'LBL_ERR_NO_AUTHINFO' => 'There is no authentication information for this account.',
    'LBL_ERR_NO_TOKEN' => 'There are no valid login tokens for this account.',

    'LBL_ERR_FAILED_QUICKCHECK' => 'You are not currently connected to your {0} account. Click OK to login to your account and to re-activate the connection.',

    'LBL_CLICK_TO_EDIT' => 'Click to Edit',

    // Various strings used throughout the external account modules
    'LBL_REAUTHENTICATE_LABEL' => 'Reauthenticate',
    'LBL_APPLICATION_FOUND_NOTICE' => 'An account for this application already exists. We have reinstated the existing account.',
    'LBL_OMIT_URL' => '(Omit http:// or https://)',
    'LBL_OAUTH_SAVE_NOTICE' => 'Click <b>Connect</b> to be directed to a page to provide your account information and to authorize access to the account by SuiteCRM. After connecting, you will be directed back to SuiteCRM.',
    'LBL_BASIC_SAVE_NOTICE' => 'Click <b>Connect</b> to connect this account to SuiteCRM.',
    'LBL_ERR_POPUPS_DISABLED' => 'Please enable browser popup windows or add an exception for website "{0}" to the exceptions list in order to connect.',

    'LBL_API_OAUTHSECRET' => 'API OAuth Secret',
);
