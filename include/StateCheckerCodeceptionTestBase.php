<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

/**
 * Description of StateCheckerCodeceptionTestBase
 *
 * @author SalesAgility
 */
abstract class StateCheckerCodeceptionTestBase extends StateChecker_PHPUnit_Framework_TestCase {
    
    public function _before() {
        parent::setUp();
    }
    
    public function _after() {
        parent::tearDown();
    }
    
}
