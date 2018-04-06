<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

/**
 * Description of StateCheckerTrait
 *
 * @author SalesAgility
 */
class StateCheckerTrait {
   
    /**
     *
     * @var StateChecker
     */
    protected static $stateChecker = null;
    
    /**
     * 
     */
    protected function saveStates()
    {
        if (StateCheckerConfig::get('testsUseStateChecker')) {
            if (null === self::$stateChecker) {
                self::$stateChecker = new StateChecker();
            }
        }
    }
    
    /**
     * 
     */
    protected function checkStates()
    {
        if (StateCheckerConfig::get('testsUseStateChecker') && self::$stateChecker) {
            try {
                self::$stateChecker->getStateHash();
            } catch (StateCheckerException $e) {
                $message = 'Incorrect state hash (in PHPUnitTest): ' . $e->getMessage() . (StateCheckerConfig::get('saveTraces') ? "\nTrace:\n" . $e->getTraceAsString() . "\n" : '');
                if (StateCheckerConfig::get('testsUseAssertionFailureOnError')) {
                    self::assertFalse(true, $message);
                } else {
                    echo $message;
                }
            }
        }
    }
    
}
