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
 * Class ErrorLevel
 *
 * An enumerator which is used to set the log level of an UndefinedBehaviour which give the logger the ability to
 * filter out the reports which are considered unhelpful to the target log.
 */
class ErrorLevel
{
    const debug      = 100;
    const info       = 70;
    const warn       = 50;
    const deprecated = 40;
    const error      = 25;
    const fatal      = 10;
    const security   = 5;
    const off        = 0;

    /**
     * @param $sugarErrorLevel
     * @return bool|string
     */
    public static function toString($sugarErrorLevel)
    {
        $response = false;
        switch ($sugarErrorLevel)
        {
            case self::debug:
                $response = 'debug';
                break;
            case self::info:
                $response = 'info';
                break;
            case self::warn:
                $response = 'warn';
                break;
            case self::deprecated:
                $response = 'deprecated';
                break;
            case self::error:
                $response = 'error';
                break;
            case self::fatal:
                $response = 'fatal';
                break;
            case self::security:
                $response = 'security';
                break;
            case self::off:
                $response = 'off';
                break;
        }
        return $response;
    }
}