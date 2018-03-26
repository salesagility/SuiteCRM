<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

use PHPUnit_Framework_TestCase;

/**
 * Description of StateChecker_PHPUnit_Framework_TestCase
 *
 * @author SalesAgility
 */
class StateChecker_PHPUnit_Framework_TestCase extends PHPUnit_Framework_TestCase {
    
    /**
     *
     * @var StateChecker
     */
    protected $stateChecker;
    
    public function setUp() {
        parent::setUp();
        $this->stateChecker = new StateChecker();
    }
    
    public function tearDown() {
        parent::tearDown();
        $this->stateChecker->getStateHash();
    }
    
}