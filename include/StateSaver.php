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

use DBManagerFactory;
use LoggerManager;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * StateSaver
 *
 * @author SalesAgility
 */
class StateSaver
{
    const UNDEFINED = '__reserved_value_of_undefined__';

    /**
     *
     * @var array
     */
    protected $stack;
    
    /**
     *
     * @var array
     */
    protected $errors;
    
    /**
     *
     * @var array
     */
    protected $files;
    
    /**
     *
     */
    public function __construct()
    {
        $this->clearErrors();
    }
    
    /**
     *
     * @throws StateSaverException
     */
    public function __destruct()
    {
        if (!empty($this->state)) {
            throw new StateSaverException('Some garbage state left in stack');
        }
    }
    
    // ------------ Error Collector ------------
    
    /**
     *
     * @param string $msg
     */
    protected function error($msg)
    {
        $this->errors[] = $msg;
    }
    
    /**
     * Retrieve if any error occurred in storing/restoring processes.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Clear all collected error information about latest storing/restoring processes.
     */
    public function clearErrors()
    {
        $this->errors = [];
    }
    
    /**
     * Retrieve if any error occurred in storing/restoring processes and
     * clear all collected error information about latest storing/restoring processes.
     *
     * @return array
     */
    public function getErrorsClear()
    {
        $errors = $this->getErrors();
        $this->clearErrors();
        return $errors;
    }

    // ------------- Push/pop stack storeage -------------------

    /**
     * Save any value into state store at a key and namespace.
     *
     * @param mixed $value
     * @param string $key
     * @param string $namespace
     */
    public function push($value, $key, $namespace)
    {
        if (!isset($this->stack[$namespace][$key])) {
            $this->stack[$namespace][$key] = [];
        }
        $this->stack[$namespace][$key][] = $value;
    }
    
    /**
     * Restore any value from state store at a key and namespace.
     *
     * @param string $key
     * @param string $namespace
     * @return mixed
     */
    public function pop($key, $namespace)
    {
        $ok = true;
        if (!isset($this->stack[$namespace])) {
            $this->error('Trying to pop form stack at namespace but stack is unset: ' . $namespace . '.' . $key);
            $ok = false;
        } elseif (!isset($this->stack[$namespace][$key])) {
            $this->error('Trying to pop form stack at key but stack is unset: ' . $namespace . '.' . $key);
            $ok = false;
        } elseif (!count($this->stack[$namespace][$key])) {
            $this->error('Trying to pop from state stack but stack is empty: ' . $namespace . '.' . $key);
            $ok = false;
        }
        
        $value = $ok ? array_pop($this->stack[$namespace][$key]) : self::UNDEFINED;
          
        return $value;
    }
    
    /**
     * Save a global variable into storage at an optional namespace.
     *
     * @param string $key
     * @param string $namespace
     */
    public function pushGlobal($key, $namespace = 'GLOBALS')
    {
        $this->push(isset($GLOBALS[$key]) ? $GLOBALS[$key] : self::UNDEFINED, $key, $namespace);
    }
    
    /**
     * Restore a global value from storage at an optional namespace.
     *
     * @param string $key
     * @param string $namespace
     */
    public function popGlobal($key, $namespace = 'GLOBALS')
    {
        $top = $this->pop($key, $namespace);
        if (!$this->stack[$namespace]) {
            unset($this->stack[$namespace]);
        }
        if ($top !== self::UNDEFINED) {
            $GLOBALS[$key] = $top;
        } else {
            unset($GLOBALS[$key]);
        }
    }
    
    /**
     * Save all super globals which are specified in configuration.
     * @see StateCheckerConfig
     *
     * pushGlobals
     */
    public function pushGlobals()
    {
        $keys = StateCheckerConfig::get('globalKeys');
        foreach ($keys as $key) {
            $this->pushGlobal($key);
        }
    }
    
    /**
     * Restore all super globals which are specified in configuration.
     * @see StateCheckerConfig
     *
     * popGlobals
     */
    public function popGlobals()
    {
        $keys = StateCheckerConfig::get('globalKeys');
        foreach ($keys as $key) {
            $this->popGlobal($key);
        }
    }
    
    /**
     * Save all defined global variable name.
     * (note: this function does not store the values, so use it carefully)
     *
     * pushGlobalKeys
     */
    public function pushGlobalKeys()
    {
        $keys = array_keys($GLOBALS);
        $this->push($keys, 'keys', 'globalsArrayKeys');
    }
    
    /**
     * Restore all defined global variable name.
     * (note: this function does not restore the values, so use it carefully)
     *
     * popGlobalKeys
     */
    public function popGlobalKeys()
    {
        $keys = $this->pop('keys', 'globalsArrayKeys');
        foreach ($keys as $key) {
            if (!isset($GLOBALS[$key])) {
                $GLOBALS[$key] = [];
            }
        }
    }
    
    /**
     * Save Error Reporting Level into the store at an optional key and namespace.
     * (note: error level should not be changed for any reason, so use it for own risk)
     *
     * @param string $key
     * @param string $namespace
     */
    public function pushErrorLevel($key = 'level', $namespace = 'error_reporting')
    {
        LoggerManager::getLogger()->warn('Saving error level. Try to remove the error_reporting() function from your code.');
        $level = error_reporting();
        $this->push($level, $key, $namespace);
    }
    
    /**
     * Restore Error Reporting Level from the store at an optional key and namespace.
     * (note: error level should not be changed for any reason, so use it for own risk)
     *
     * @param string $key
     * @param string $namespace
     */
    public function popErrorLevel($key = 'level', $namespace = 'error_reporting')
    {
        LoggerManager::getLogger()->warn('Pop error level. Try to remove the error_reporting() function from your code.');
        $level = $this->pop($key, $namespace);
        error_reporting($level);
    }
    
    /**
     * Save all data from a database table into store at an optional namespace.
     *
     * @param string $table
     * @param string $namespace
     * @throws StateSaverException
     */
    public function pushTable($table, $namespace = 'db_table')
    {
        $query = "SELECT * FROM " . DBManagerFactory::getInstance()->quote($table);
        if (!$resource = DBManagerFactory::getInstance()->query($query)) {
            throw new StateSaverException('Could not resolve DB resource for table: ' . $table);
        }
        $rows = [];
        while ($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        
        $this->push($rows, $table, $namespace);
        return $rows;
    }
    
    /**
     * Restore all data into a database table from store at an optional namespace.
     *
     * @param string $table
     * @param string $namespace
     */
    public function popTable($table, $namespace = 'db_table')
    {
        $rows = $this->pop($table, $namespace);
        
        DBManagerFactory::getInstance()->query("TRUNCATE TABLE " . DBManagerFactory::getInstance()->quote($table));
        
        if(!is_array($rows)) {
            throw new StateSaverException('Table information is not an array. Are you sure you pushed this table previously?');
        }
        foreach ($rows as $row) {
            $query = "INSERT INTO $table (";
            $query .= (implode(', ', array_keys($row)) . ') VALUES (');
            $quoteds = [];
            foreach ($row as $value) {
                $quoteds[] = (null === $value) ? 'NULL' : "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        return $rows;
    }
    
    // --- Files ---
    
    /**
     * Save a file contents.
     *
     * @param string $filename
     * @throws StateSaverException
     */
    public function pushFile($filename)
    {
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
    
    /**
     * Restore a file contents.
     *
     * @param string $filename
     * @return boolean
     * @throws StateSaverException
     */
    public function popFile($filename)
    {
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
            if (false ===touch($realpath, $this->files[$realpath]['time'])) {
                throw new StateSaverException('Unable to touch filemtime for file: ' . $realpath);
            }
        } else {
            if (file_exists($realpath) && false === unlink($realpath)) {
                return false;
            }
        }
        return true;
    }
    
    // ------------------ PHP CONFIGURATION OPTIONS
    
    /**
     * Getter for PHP Configuration Options
     * @see more at StateCheckerConfig::$phpConfigOptionKeys
     * 
     * @return array
     */
    public static function getPHPConfigOptions()
    {
        $configOptions = [];
        $configOptionKeys = StateCheckerConfig::get('phpConfigOptionKeys');
        foreach ($configOptionKeys as $name) {
            $configOptions[$name] = ini_get($name);
        }
        
        return $configOptions;
    }
    
    /**
     * Setter for PHP Configuration Options
     * @see more at StateCheckerConfig::$phpConfigOptionKeys
     * 
     * @param array $configOptions
     * @throws StateSaverException
     */
    public static function setPHPConfigOptions($configOptions)
    {
        $configOptionKeys = StateCheckerConfig::get('phpConfigOptionKeys');
        foreach ($configOptionKeys as $name) {
            if (ini_set($name, $configOptions[$name]) === false) {
                throw new StateSaverException('Error to restore PHP Configuration Option: "' . $name . '"');
            }
        }
    }
    
    /**
     * Store PHP Configuration Options
     * @see more at StateCheckerConfig::$phpConfigOptionKeys
     * 
     * @param string $key
     * @param string $namespace
     */
    public function pushPHPConfigOptions($key = 'all', $namespace = 'php_config_options')
    {
        $configOptions = self::getPHPConfigOptions();
        $this->push($configOptions, $key, $namespace);
    }
    
    /**
     * Restore PHP Configuration Options
     * @see more at StateCheckerConfig::$phpConfigOptionKeys
     * 
     * @param string $key
     * @param string $namespace
     */
    public function popPHPConfigOptions($key = 'all', $namespace = 'php_config_options')
    {
        $configOptions = $this->pop($key, $namespace);
        self::setPHPConfigOptions($configOptions);
    }
}
