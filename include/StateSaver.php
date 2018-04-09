<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SuiteCRM;

use DBManagerFactory;
use Exception;
use LoggerManager;

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
    
    protected $files;
    
    public function __conatruct() {
        $this->clearErrors();
    }
    
    public function __destruct() {
        if(!empty($this->state)) {
            throw new StateSaverException('Some garbage state left in stack');
        }
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
    
    public function pushGlobalKeys() {
        $keys = array_keys($GLOBALS);
        $this->push($keys, 'keys', 'globalsArrayKeys');
    }
    
    public function popGlobalKeys() {
        $keys = $this->pop('keys', 'globalsArrayKeys');
        foreach($keys as $key) {
            if(!isset($GLOBALS[$key])) {
                $GLOBALS[$key] = [];
            }
        }
    }
    
    public function pushErrorLevel($key = 'level', $namespace = 'error_reporting') {
        LoggerManager::getLogger()->warn('Saving error level. Try to remove the error_reporting() function from your code.');
        $level = error_reporting();
        $this->push($level, $key, $namespace);
    }
    
    public function popErrorLevel($key = 'level', $namespace = 'error_reporting') {
        LoggerManager::getLogger()->warn('Pop error level. Try to remove the error_reporting() function from your code.');
        $level = $this->pop($key, $namespace);
        error_reporting($level);
    }
    
    
    public function pushTable($table, $namespace = 'db_table') {
        
        $query = "SELECT * FROM " . DBManagerFactory::getInstance()->quote($table);
        if(!$resource = DBManagerFactory::getInstance()->query($query)) {
            throw new StateSaverException('Could not resolve DB resource for table: ' . $table);
        }
        $rows = [];
        while($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        } 
        
        $this->push($rows, $table, $namespace);
    }
    
    public function popTable($table, $namespace = 'db_table') {
        
        $rows = $this->pop($table, $namespace);
        
        DBManagerFactory::getInstance()->query("DELETE FROM " . DBManagerFactory::getInstance()->quote($table));
        
        if (!is_array($rows) && !is_object($rows)) {
            throw new StateCheckerException('Table state pop failed, invalid data format. Table and namespace were: "' . $table . '", "' . $namespace . '"');
        }
        
        foreach($rows as $row) {
            $query = "INSERT $table INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
    }
    
    // --- Files ---
    
    public function pushFile($filename) {
        $exists = file_exists($filename);
        $realpath = realpath($filename);
        if (!$realpath && $exists) {
            throw new StateSaverException('Could not resolve real path for file for push: ' . $filename);
        }
        if ($exists) {
            $contents = file_get_contents($realpath);
            if (false === $contents) {
                throw new StateSaverException('Can not read file: ' . $realpath);
            }
            $this->files[$realpath]['contents'] = $contents;
            $this->files[$realpath]['time'] = filemtime($realpath);
            if (false === $this->files[$realpath]['time']) {
                throw new StateSaverException('Unable to get filemtime for file: ' . $realpath);
            }
        } else {
            unset($this->files[$realpath]['contents']);
        }
    }
    
    public function popFile($filename) {
        $exists = file_exists($filename);
        $realpath = realpath($filename);
        if (!$realpath && $exists) {
            throw new StateSaverException('Could not resolve real path for file for pop: ' . $filename);
        }
        if (isset($this->files[$realpath]['contents'])) {
            $contents = $this->files[$realpath]['contents'];
            $ok = file_put_contents($realpath, $contents);
            if (false === $ok) {
                throw new StateSaverException('Can not write file: ' . $realpath);            
            }
            if (false === touch($realpath, $this->files[$realpath]['time'])) {
                throw new StateSaverException('Unable to touch filemtime for file: ' . $realpath);
            }
        } else {
            if (file_exists($realpath) && false === unlink($realpath)) {
                return false;
            }
        }
        return true;
    }
    
}
