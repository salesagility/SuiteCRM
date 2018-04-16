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

use PHPUnit_Framework_TestCase;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * StateCheckerPHPUnitTestCaseAbstract
 *
 * @author SalesAgility
 */
abstract class StateCheckerPHPUnitTestCaseAbstract extends PHPUnit_Framework_TestCase
{
    use StateCheckerTrait;
    
    
    protected static $testCounters = [];
    
    /**
     * 
     * @return string
     */
    protected static function getClassName()
    {
        $class = get_called_class();
        return $class;
    }
    
    /**
     * 
     * @return int
     */
    protected static function getTestMethodsCount()
    {
        $count = 0;
        $class = get_called_class();
        $methods = get_class_methods($class);
        foreach ($methods as $method) {
            if (preg_match('/^test/', $method)) {
                $count++;
            }
        }
        return $count;
    }


    /**
     * Collect state information and storing a hash
     */
    public function setUp()
    {
        $mode = StateCheckerConfig::get('testStateCheckMode');
        
        switch ($mode) {
            
            case StateCheckerConfig::RUN_PER_TESTS:
                self::saveStates();
                break;
            
            case StateCheckerConfig::RUN_PER_CLASSES:
                if (!isset(self::$testCounters[$this::getClassName()]) || !self::$testCounters[$this::getClassName()]) {
                    self::$testCounters[$this::getClassName()] = $this->getTestMethodsCount();
                    self::saveStates();
                }
                break;
            
            case StateCheckerConfig::RUN_NEVER:
                break;
            
            default:
                throw new StateCheckerException('Incorect state check mode: ' . $mode);
        }
        
        
        parent::setUp();
    }
    
    /**
     * Collect state information and comparing hash
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $mode = StateCheckerConfig::get('testStateCheckMode');
        
        switch ($mode) {
            
            case StateCheckerConfig::RUN_PER_TESTS:
                self::checkStates();
                break;
            
            case StateCheckerConfig::RUN_PER_CLASSES:
                self::$testCounters[$this::getClassName()]--;
                if (self::$testCounters[$this::getClassName()] <= 0) {
                    self::checkStates();
                }
                break;
            
            case StateCheckerConfig::RUN_NEVER:
                break;
            
            default:
                throw new StateCheckerException('Incorect state check mode: ' . $mode);
        }
    }
}
