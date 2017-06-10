<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

require_once __DIR__ . '/UndefinedBehaviour.php';
require_once __DIR__ . '/exceptions.php';

/**
 * Class ErrorCollection
 * Soft Exception handler
 *
 * Since old code does not handle undefined behaviour well, We cannot throw exceptions without potentially
 * breaking old customisations.
 *
 * ErrorCollection allows us to collect undefined behaviour and check for exceptions without breaking legacy code.
 * ErrorCollection tells us where the in the code base should throw exceptions.
 * When $sugar_config['show_log_trace'] is assigned to true, ErrorCollection will give us a stack trace
 * to help find where problems have occurred during the SuiteCRM operation.
 *
 * Typical usage:
 * ErrorCollection::throwError(new UndefinedBehaviour('Custom message');
 *
 */
class ErrorCollection
{
    /**
     * @var array $errors
     */
    protected static $errors = array();

    /**
     * Throws and logs the error.
     *
     * @param UndefinedBehaviour $exception The error presented as a exception
     * @param int $sugarErrorLevel determines the log level reported in the log file(s)
     * @param boolean $throwException offers a means for new code to throw exception and keep the same log convention
     * @throws UndefinedBehaviour when $throwException is assigned to true
     */
    public static function throwError($exception, $sugarErrorLevel = ErrorLevel::fatal, $throwException = false)
    {
        global $sugar_config;
        self::$errors[] = $exception;

        $errorMessage = 'PHP ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine() . PHP_EOL;
        if(isset($sugar_config['show_log_trace']) && $sugar_config['show_log_trace'] === true) {
            $errorMessage .= 'PHP Stack trace:' . PHP_EOL . $exception->getTraceAsString() . PHP_EOL;
        }

        $logFunction = ErrorLevel::toString($sugarErrorLevel);
        $GLOBALS['log']->{$logFunction}($errorMessage);

        if ($throwException === true) {
            throw $exception;
        }
    }

    /**
     * @param UndefinedBehaviour $type
     * @return bool
     */
    public static function hasThrownError($type)
    {
        foreach (self::$errors as $error) {
            if ($error instanceof $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function hasErrors()
    {
        return !empty(self::$errors);
    }

    /**
     * @return string
     */
    public static function getStackTraceMessage()
    {

        $stackTraceString = '';
        if (!empty(self::$errors)) {
            foreach (self::$errors as $error) {
                $stackTraceString .= 'PHP ' . $error->getMessage() . ' in ' . $error->getFile() . ':'
                    . $error->getLine() . PHP_EOL .
                    'PHP Stack trace:' . PHP_EOL . $error->getTraceAsString() . PHP_EOL;
            }
        }
        return $stackTraceString;
    }

    /**
     * Clears errors (used for testing)
     */
    public static function clearErrors()
    {
        self::$errors = array();
    }
}
