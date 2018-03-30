<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

use Exception;

class StateSaverException extends Exception {}

/**
 * Description of StateSaver
 *
 * @author SalesAgility
 */
class StateSaver {
    
    const UNDEFINED = 'reserver_value_of_undefined';


    protected $stack;
    
    protected $errors;
    
    public function __conatruct() {
        $this->clearErrors();
    }
    
    protected function error($msg) {
        $this->errors[] = $msg;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function clearErrors() {
        $this->errors = [];
    }
    
    public function getErrorsClear() {
        $errors = $this->getErrors();
        $this->clearErrors();
        return $errors;
    }


    public function push($value, $key, $namespace) {
        if(!isset($this->stack[$namespace][$key])) {
            $this->stack[$namespace][$key] = [];
        }
        $this->stack[$namespace][$key][] = $value;
    }
    
    public function pop($key, $namespace) {
        $ok = true;
        if(!isset($this->stack[$namespace])) {
            $this->error('Trying to pop form stack at namespace but stack is unset: ' . $namespace . '.' . $key);
            $ok = false;
        } else if(!isset($this->stack[$namespace][$key])) {
            $this->error('Trying to pop form stack at key but stack is unset: ' . $namespace . '.' . $key);
            $ok = false;
        } else if(!count($this->stack[$namespace][$key])) {
            $this->error('Trying to pop from state stack but stack is empty: ' . $namespace . '.' . $key);
            $ok = false;
        }
        
        $value = $ok ? array_pop($this->stack[$namespace][$key]) : self::UNDEFINED; 
          
        return $value;
    }
    
    public function pushGlobal($key, $namespace = 'GLOBALS') {        
        if(isset($GLOBALS[$key])) {
            $this->push(isset($GLOBALS[$key]) ? $GLOBALS[$key] : self::UNDEFINED, $key, $namespace);
        }
    }
    
    public function popGlobal($key, $namespace = 'GLOBALS') {
        $top = $this->pop($key, $namespace);
        if(!$this->stack[$namespace]) {
            unset($this->stack[$namespace]);
        }
        if($top !== self::UNDEFINED) {
            $GLOBALS[$key] = $top;
        } else {
            unset($GLOBALS[$key]);
        }
    }
    
    public function pushGlobals() {
        $keys = StateCheckerConfig::get('globalKeys');
        foreach($keys as $key) {
            $this->pushGlobal($key);
        }
    }
    
    public function popGlobals() {
        $keys = StateCheckerConfig::get('globalKeys');
        foreach($keys as $key) {
            $this->popGlobal($key);
        }
    }
    
    public function pushErrorLevel($key = 'level', $namespace = 'error_reporting') {
        $this->push(error_reporting(), $key, $namespace);
    }
    
    public function popErrorLevel($key = 'level', $namespace = 'error_reporting') {
        $level = $this->pop($key, $namespace);
        error_reporting($level);
    }
    
}
