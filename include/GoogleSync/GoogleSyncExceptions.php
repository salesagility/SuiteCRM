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
 * These classes define unique exceptions for GoogleSync
 * When we don't need to support PHP < 7 we can set these to extend the new Exception classes
 * Exception Codes & Messages are set to unique values, but can still be overridden if needed.
 */

/**
 * Custom Exception - Missing Parameters When Calling A Method
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_MissingParameters extends Exception {
    /** @var int The default Exception Code: (1)*/
    protected $code = 1;
    /** @var string The default Exception Message: 'Missing Parameters When Calling A Method' */
    protected $message = 'Missing Parameters When Calling A Method';
    }

/**
 * Custom Exception - Invalid Parameters When Calling A Method
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_InvalidParameters extends Exception {
    /** @var int The default Exception Code: (2) */
    protected $code = 2;
    /** @var string The default Exception Message: 'Invalid Parameters When Calling A Method' */
    protected $message = 'Invalid Parameters When Calling A Method';
}

/**
 * Custom Exception - Value Failed Validation
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_ValidationFailure extends Exception {
    /** @var int The default Exception Code: (3) */
    protected $code = 3;
    /** @var string The default Exception Message: 'Value Failed Validation' */
    protected $message = 'Value Failed Validation';
}

/**
 * Custom Exception - Failed To Retrive A SuiteCRM Record
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_RecordRetrievalFail extends Exception {
    /** @var int The default Exception Code: (4) */
    protected $code = 4;
    /** @var string The default Exception Message: 'Failed To Retrive A SuiteCRM Record' */
    protected $message = 'Failed To Retrive A SuiteCRM Record';
}

/**
 * Custom Exception - Failed To Set The Timezone
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_TimezoneSetFailure extends Exception {
    /** @var int The default Exception Code: (5) */
    protected $code = 5;
    /** @var string The default Exception Message: 'Failed To Set The Timezone' */
    protected $message = 'Failed To Set The Timezone';
}

/**
 * Custom Exception - Refresh Token Missing From Google Client
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_NoRefreshToken extends Exception {
    /** @var int The default Exception Code: (6) */
    protected $code = 6;
    /** @var string The default Exception Message: 'Refresh Token Missing From Google Client' */
    protected $message = 'Refresh Token Missing From Google Client';
}

/**
 * Custom Exception - Google Client Failed To Initialize
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_GoogleClientFailure extends Exception {
    /** @var int The default Exception Code: (7) */
    protected $code = 7;
    /** @var string The default Exception Message: 'Google Client Failed To Initialize' */
    protected $message = 'Google Client Failed To Initialize';
}

/**
 * Custom Exception - Google Service Failed To Initialize
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_GoogleServiceFailure extends Exception {
    /** @var int The default Exception Code: (8) */
    protected $code = 8;
    /** @var string The default Exception Message: 'Google Client Failed To Initialize' */
    protected $message = 'Google Client Failed To Initialize';
}

/**
 * Custom Exception - Google Calendar Service Failure
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_GoogleCalendarFailure extends Exception {
    /** @var int The default Exception Code: (9) */
    protected $code = 9;
    /** @var string The default Exception Message: 'Google Calendar Service Failure' */
    protected $message = 'Google Calendar Service Failure';
}

/**
 * Custom Exception - Failed To Parse Google Record
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_GoogleRecordParseFailure extends Exception {
    /** @var int The default Exception Code: (10) */
    protected $code = 10;
    /** @var string The default Exception Message: 'Failed To Parse Google Record' */
    protected $message = 'Failed To Parse Google Record';
}

/**
 * Custom Exception - SuiteCRM DB Data Unexpected Or Corrupt
 *
 * @license https://raw.githubusercontent.com/salesagility/SuiteCRM/master/LICENSE.txt
 * GNU Affero General Public License version 3
 * @author Benjamin Long <ben@offsite.guru>
 */
class E_DbDataError extends Exception {
    /** @var int The default Exception Code: (11) */
    protected $code = 11;
    /** @var string The default Exception Message: 'SuiteCRM DB Data Unexpected Or Corrupt' */
    protected $message = 'SuiteCRM DB Data Unexpected Or Corrupt';
}
