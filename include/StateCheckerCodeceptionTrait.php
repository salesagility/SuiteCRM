<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

/**
 * Description of StateCheckerCodeceptionTrait
 *
 * @author SalesAgility
 */
class StateCheckerCodeceptionTrait {

    
    /**
     * Collect state information and storing a hash
     */
    public function _before()
    {
        if (StateCheckerConfig::get('testStateCheckMode') == StateCheckerConfig::RUN_PER_TESTS) {
            self::saveStates();
        }
        
        parent::_before();
    }
    
    /**
     * Collect state information and comparing hash
     */
    public function _after()
    {
        parent::_after();
           
        if (StateCheckerConfig::get('testStateCheckMode') == StateCheckerConfig::RUN_PER_TESTS) {
            self::checkStates();
        }
    }
}
