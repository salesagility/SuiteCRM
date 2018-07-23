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
 * StateCheckerConfig
 *
 * Configuration of SuiteCRM\StateChecker and StateChecker Tests classes such as
 *
 *  - SuiteCRM\StateCheckerPHPUnitTestCaseAbstract,
 *  - SuiteCRM\StateCheckerUnitAbstract,
 *  - SuiteCRM\StateCheckerCestAbstract.
 *
 * SuiteCRM\StateCheckerConfig configuration options have default values
 * and each available in $sugar_config['state_checker'][$key].
 *
 * Each configuration value available with a getter method: SuiteCRM\StateCheckerConfig::get($key)
 *
 * @author SalesAgility
 */
class StateCheckerConfig
{
    
    /**
     * Tests never check state
     */
    const RUN_NEVER = 0;
    
    /**
     * Tests check states after each test method
     */
    const RUN_PER_TESTS = 1;
    
    /**
     * Tests check state after each test class (PHPUnit only)
     */
    const RUN_PER_CLASSES = 2;
     
    /**
     * SuperGlobals Collection
     * (DO NOT CHANGE!)
     *
     * @var array
     */
    protected static $globalKeys = ['_POST', '_GET', '_REQUEST', '_SESSION', '_SERVER', '_ENV', '_FILES', '_COOKIE'];
    
    /**
     * Tests won't checking hash at these files so won't failing
     *
     * @var array
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
        '/\/travis\/build\//',
        '/\/\.idea\//',
        '/\/\nbproject\//',
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
    protected static $storeDetails = true;
    
    /**
     * Enum specified that tests needs to check system state,
     * for Test Cases behaviour, possible values: [RUN_NEVER | RUN_PER_TESTS | RUN_PER_CLASSES].
     * RUN_NEVER: State check and save never run.
     * RUN_PER_TEST: State check runs after each test methods.
     * RUN_PER_CLASSES: State check runs after each test class.
     *
     * Note: Mode RUN_PER_CLASSES affects only PHPUnit Test Cases
     * Note: developer mode overrides this value
     *
     * @var integer
     */
    protected static $testStateCheckMode = self::RUN_PER_CLASSES;
    
    /**
     * Test using StateChecker
     * (Slow working but give more information about the error location, use in development only)
     *
     * @var boolean
     */
    protected static $testsUseStateChecker = true;
    
    /**
     * Test shows up an assertion failure when hash-mismatch,
     * use $testsUseStateChecker also, $testsUseAssertionFailureOnError applied only if $testsUseStateChecker = true;
     * (use in development only)
     *
     * @var boolean
     */
    protected static $testsUseAssertionFailureOnError = true;
        
    /**
     * Tests won't checking hash at these keys so won't failing
     * (It should be empty)
     *
     * @var array
     */
    protected static $testsFailureExcludeKeys = [];
    
    
    /**
     * Sate saver needs to know which PHP configuration option needs to save/restore.
     *
     * @var array
     */
    protected static $phpConfigOptionKeys = ['max_execution_time', 'display_errors', 'display_startup_errors'];
    
    
    /**
     *
     * @var boolean
     */
    protected static $retrieved = false;
    
    /**
     * Retrieve from sugar_config
     *
     * @global array $sugar_config
     */
    protected static function retrieve()
    {
        global $sugar_config;
        
        self::$globalKeys =
            isset($sugar_config['state_checker']['global_keys']) ?
                $sugar_config['state_checker']['global_keys'] :
                self::$globalKeys;
        
        self::$fileExludeRegexes =
            isset($sugar_config['state_checker']['file_exlude_regexes']) ?
                $sugar_config['state_checker']['file_exlude_regexes'] :
                self::$fileExludeRegexes;
        
        self::$autoRun =
            isset($sugar_config['state_checker']['auto_run']) ?
                $sugar_config['state_checker']['auto_run'] :
                self::$autoRun;
        
        self::$saveTraces =
            isset($sugar_config['state_checker']['save_traces']) ?
                $sugar_config['state_checker']['save_traces'] :
                self::$saveTraces;
        
        self::$redefineMemoryLimit =
            isset($sugar_config['state_checker']['redefine_memory_limit']) ?
                $sugar_config['state_checker']['redefine_memory_limit'] :
                self::$redefineMemoryLimit;
        
        self::$storeDetails =
            isset($sugar_config['state_checker']['store_details']) ?
                $sugar_config['state_checker']['store_details'] :
                self::$storeDetails;
        
        self::$testStateCheckMode =
            isset($sugar_config['state_checker']['test_state_check_mode']) ?
                $sugar_config['state_checker']['test_state_check_mode'] :
                self::$testStateCheckMode;
        
        self::$testsUseStateChecker =
            isset($sugar_config['state_checker']['tests_use_state_checker']) ?
                $sugar_config['state_checker']['tests_use_state_checker'] :
                self::$testsUseStateChecker;
        
        self::$testsUseAssertionFailureOnError =
            isset($sugar_config['state_checker']['tests_use_assertion_failure_on_error']) ?
                $sugar_config['state_checker']['tests_use_assertion_failure_on_error'] :
                self::$testsUseAssertionFailureOnError;
        
        self::$testsFailureExcludeKeys =
            isset($sugar_config['state_checker']['tests_failure_exclude_keys']) ?
                $sugar_config['state_checker']['tests_failure_exclude_keys'] :
                self::$testsFailureExcludeKeys;
        
        self::$phpConfigOptionKeys =
            isset($sugar_config['state_checker']['php_configuration_option_keys']) ?
                $sugar_config['state_checker']['php_configuration_option_keys'] :
                self::$phpConfigOptionKeys;
        
        self::$retrieved = true;
    }
    
    /**
     *
     * @param string $key
     * @return boolean
     */
    public static function get($key)
    {
        if (!self::$retrieved) {
            self::retrieve();
        }
        if (inDeveloperMode()) {
            if (in_array($key, ['testStateCheckMode'])) {
                return self::RUN_PER_TESTS;
            }
        }
        return self::$$key;
    }
}
