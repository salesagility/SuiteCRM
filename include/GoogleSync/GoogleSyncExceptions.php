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

/**
 * This class define unique exceptions for GoogleSync
 * When we don't need to support PHP < 7 we can set these to extend the new Exception classes
 * Exception Codes & Messages are set to unique values, but can still be overridden if needed.
 * Standard: Classes should be in separated files..
 */
class GoogleSyncException extends Exception
{
    const UNKNOWN_EXCEPTION = 100;
    const MEETING_NOT_FOUND = 101;
    const EVENT_ID_IS_EMPTY = 102;
    const INVALID_ACTION = 103;
    const INVALID_CLIENT_ID = 104;
    const UNABLE_TO_RETRIEVE_USER = 105;
    const UNABLE_TO_SETUP_GCLIENT = 106;
    const TIMEZONE_SET_FAILURE = 107;
    const GSERVICE_FAILURE = 108;
    const GCALENDAR_FAILURE = 109;
    const NO_REFRESH_TOKEN = 110;
    const UNABLE_TO_RETRIEVE_MEETING = 111;
    const AMBIGUOUS_MEETING_ID = 112;
    const GOOGLE_RECORD_PARSE_FAILURE = 113;
    const INVALID_USER_ID = 114;
    const NO_GRESOURCE_SET = 115;
    const NO_GSERVICE_SET = 116;
    const NO_REMOVE_EVENT_START_IS_NOT_SET = 117;
    const NO_REMOVE_EVENT_START_IS_INCORRECT = 118;
    const INCORRECT_WORKING_USER_TYPE = 119;
    const UNABLE_TO_RETRIEVE_USER_ALL = 120;
    const JSON_CORRUPT = 121;
    const JSON_KEY_MISSING = 122;
    const NO_GCLIENT_SET = 123;
    const GEVENT_INSERT_OR_UPDATE_FAILURE = 124;
    const MEETING_SAVE_FAILURE = 125;
    const MEETING_CREATE_OR_UPDATE_FAILURE = 126;
    const MEETING_ID_IS_EMPTY = 127;
    const RECORD_VALIDATION_FAILURE = 128;
    const SQL_FAILURE = 129;
    const ACCSESS_TOKEN_PARAMETER_MISSING = 130;
}
