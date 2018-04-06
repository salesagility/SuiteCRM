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

namespace SuiteCRM;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Description of StateCheckerConfig
 *
 * @author SalesAgility
 */
class StateCheckerConfig
{
    const RUN_NEVER = 0;
    const RUN_PER_TESTS = 1;
    const RUN_PER_CLASSES = 2;
    
    /**
     * SuperGlobals Collection
     * (DO NOT CHANGE!)
     *
     * @var array
     */
    protected static $globalKeys = ['_POST', '_GET', '_REQUEST', '_SESSION', '_SERVER', '_ENV', '_FILES', '_COOKIE'];
    
    /**
     *
     * @var array of excluder regexps
     */
    protected static $fileExludeRegexes = [
        '/\/\.git\//',
        '/\/cache\//',
        '/\.log$/',
        '/\/tests\/_output\//',
        '/\/blowfish\//',
        '/\/upload\//',
        '/\/vendor\//',
        '/\/sugarfield_jjwg_maps_/',
        '/\/vardefs.ext.php$/',
        '/\/modules\/AOD_Index\/Index\/Index\//',
    ];
    
    /**
     * Automatically run state collection in StateChecker constructor
     * (DO NOT CHANGE!)
     *
     * @var boolean
     */
    protected static $autoRun = true;
    
    /**
     * Save trace info on state-hash mismatch
     * (Slow working but give more information about the error location, use in development only)
     * @var boolean
     */
    protected static $saveTraces = false;
    
    /**
     * Redefine memory limit
     * (For more memory expensive task, for e.g collection stack trace information when $saveTraces is ON, use in development only)
     * @var boolean
     */
    protected static $redefineMemoryLimit = false;
    
    /**
     * Store more information about hash-mismatch,
     * which part having state of globals/filesys/database.
     * (Slow working but give more information about the error location, use in development only)
     *
     * @var boolean
     */
    protected static $storeDetails = false;
    
    /**
     *
     * @var integer
     */
    protected static $testStateCheckMode = self::RUN_NEVER;
    
    /**
     * Test using StateChecker
     * (Slow working but give more information about the error location, use in development only)
     *
     * @var boolean
     */
    protected static $testsUseStateChecker = false;
    
    /**
     * Test shows up an assertion failure when hash-mismatch,
     * use $testsUseStateChecker also, $testsUseAssertionFailureOnError applied only if $testsUseStateChecker = true;
     * (use in development only)
     *
     * @var boolean
     */
    protected static $testsUseAssertionFailureOnError = true;
    
    /**
     *
     * @param string $key
     * @return boolean
     */
    public static function get($key)
    {
        if (inDeveloperMode()) {
            if (in_array($key, ['storeDetails', 'testsUseStateChecker', 'testsUseAssertionFailureOnError'])) {
                return true;
            }
            if (in_array($key, ['testStateCheckMode'])) {
                return self::RUN_PER_TESTS;
            }
        }
        return self::$$key;
    }
}
