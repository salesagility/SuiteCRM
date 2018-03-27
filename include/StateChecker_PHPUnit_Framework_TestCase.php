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
abstract class StateChecker_PHPUnit_Framework_TestCase extends PHPUnit_Framework_TestCase {
   
    /**
     *
     * @var StateChecker
     */
    protected $stateChecker;
    
    public function setUp() {
        if(StateCheckerConfig::$testsUseStateChecker) {
            $this->stateChecker = new StateChecker();
        }
        
        parent::setUp();
    }
    
    public function tearDown() {
        parent::tearDown();
        
        if(StateCheckerConfig::$testsUseStateChecker && $this->stateChecker) {
            try {
                $this->stateChecker->getStateHash();
            } catch (StateCheckerException $e) {
                $message = 'Incorrect state hash: ' . $e->getMessage() . (StateCheckerConfig::$saveTraces ? "\nTrace:\n" . $e->getTraceAsString() . "\n" : '');
                if(StateCheckerConfig::$testsUseAssertationFailureOnError) {
                    $this->assertFalse(true, $message);
                } else {
                    echo $message;
                }
            }
        }
    }
    
}