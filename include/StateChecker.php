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

use DBManager;
use DBManagerFactory;
use mysqli_result;
use MysqliManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * StateChecker
 * 
 * Save and check the system state and reports you about any state change in the following: 
 * 
 * - Database 
 * - File system 
 * - Super globals 
 * - PHP error reporting level 
 * - PHP configuration options
 * 
 * See more about the StateChecker configuration at the StateCheckerConfig class.
 *
 * @author SalesAgility
 */
class StateChecker
{

    /**
     *
     * @var DBManager
     */
    protected $db;
    
    /**
     *
     * @var array
     */
    protected $hashes;

    /**
     *
     * @var string
     */
    protected $lastHash;
    
    /**
     *
     * @var array
     */
    protected $traces;
    
    /**
     *
     * @var integer
     */
    protected $memoryLimit;
    
    /**
     *
     * @throws StateCheckerException
     */
    public function __construct()
    {
        if (!$this->db = DBManagerFactory::getInstance()) {
            throw new StateCheckerException('DBManagerFactory get instace failure');
        }
        if (!($this->db instanceof MysqliManager)) {
            throw new StateCheckerException('Incompatible DB type, only supported: mysqli');
        }
        $this->resetHashes();
        $this->resetTraces();
        
        if (StateCheckerConfig::get('redefineMemoryLimit')) {
            $this->memoryLimit = ini_get('memory_limit');
            ini_set('memory_limit', -1);
        }
                
        if (StateCheckerConfig::get('autoRun')) {
            $this->getStateHash();
        }
    }
    
    /**
     *
     * @return array traces
     * @throws StateCheckerException
     */
    public function getTraces()
    {
        if (StateCheckerConfig::get('saveTraces')) {
            throw new StateCheckerException('Trace information is not saved, use StateCheckerConfig::get(\'saveTraces\') as true');
        }
        return $this->traces;
    }
    
    /**
     *
     */
    public function __destruct()
    {
        if (StateCheckerConfig::get('redefineMemoryLimit')) {
            ini_set('memory_limit', $this->memoryLimit);
        }
    }
    
    /**
     * resetTraces
     */
    protected function resetTraces()
    {
        $this->traces = [];
    }

    /**
     * resetHashes
     */
    protected function resetHashes()
    {
        $this->hashes = [];
    }
    
    /**
     *
     * @param string $key
     * @return boolean
     */
    protected function isDetailedKey($key)
    {
        $detailedKey = preg_match('/\w+\:\:/', $key);
        return $detailedKey;
    }
    
    /**
     *
     * @param string $hash
     * @param string $key
     * @return boolean
     */
    protected function checkHash($hash, $key)
    {
        $detailedKey = $this->isDetailedKey($key);
        $needToStore = !$detailedKey || ($detailedKey && StateCheckerConfig::get('storeDetails'));
        
        if (!isset($this->hashes[$key])) {
            if ($needToStore) {
                $this->hashes[$key] = $hash;
            }
        }
        if ($needToStore) {
            $match = $this->hashes[$key] == $hash;
        } else {
            $match = true;
        }
        return $match;
    }
    
    /**
     *
     * @param mixed $data should be serializable
     * @param string $key
     * @return string
     * @throws StateCheckerException
     */
    protected function getHash($data, $key)
    {
        $serialized = serialize($data);
        if (!$serialized) {
            throw new StateCheckerException('Serialize object failure');
        }
        
        $hash = null;
        if (!in_array($key, StateCheckerConfig::get('testsFailureExcludeKeys'))) {
            $hash = md5($serialized);
        }
        $this->lastHash = $hash;
        
        if (!$this->checkHash($hash, $key)) {
            if ($key != 'errlevel') { // TODO: temporary remove the error level check from state
                throw new StateCheckerException('Hash doesn\'t match at key "' . $key . '".');
            }
        }
        
        if (StateCheckerConfig::get('saveTraces')) {
            $this->traces[$key][] = debug_backtrace();
        }
        
        return $hash;
    }

    /**
     *
     * @return string
     */
    public function getLastHash()
    {
        return $this->lastHash;
    }
    
    // ------------ DATABASE ----------------
    
    /**
     *
     * @param mysqli_result $resource
     * @return array
     */
    protected function getMysqliResults(mysqli_result $resource)
    {
        $rows = [];
        while ($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    /**
     *
     * @return array
     * @throws StateCheckerException
     */
    protected function getDatabaseTables()
    {
        $tables = $this->db->tablesLike('');
        if (!$tables) {
            throw new StateCheckerException('get tables failure');
        }
        return $tables;
    }
    
    /**
     *
     * @return string
     */
    protected function getDatabaseHash()
    {
        $tables = $this->getDatabaseTables();
        $hashes = [];
        foreach ($tables as $table) {
            $rows = $this->getMysqliResults($this->db->query('SELECT * FROM ' . $table));
            $hashes[] = $this->getHash($rows, 'database::' . $table);
        }
        $hash = $this->getHash($hashes, 'database');
        return $hash;
    }
    
    // ------------- FILE SYSTEM ---------------
    
    /**
     *
     * @param string $name filename
     * @return boolean
     */
    protected function isExcludedFile($name)
    {
        foreach (StateCheckerConfig::get('fileExludeRegexes') as $regex) {
            if (preg_match($regex, $name)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     *
     * @param string $path
     * @return array
     * @throws StateCheckerException
     */
    protected function getFiles($path = '.')
    {
        clearstatcache(true);
        $realpath = realpath($path);
        if (!$realpath) {
            throw new StateCheckerException('Real path can not resolved for: ' . $path);
        }

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($realpath), RecursiveIteratorIterator::SELF_FIRST);
        $files = [];
        foreach ($objects as $name => $object) {
            if (!$object->isDir() && !$this->isExcludedFile($name)) {
                $fileObject = $object;
                $fileObject->modifyTime = filemtime($name);
                $fileObject->hash = $this->getHash((array)$fileObject, 'filesys::' . $fileObject);
                $files[] = $name;
            }
        }
        return $files;
    }
    
    /**
     *
     * @return string
     */
    protected function getFilesystemHash()
    {
        $files = $this->getFiles(__DIR__ . '/../');
        $hash = $this->getHash($files, 'filesys');
        return $hash;
    }
    
    // -------------- SUPERGLOBALS -----------------
    
    /**
     *
     * @return string
     */
    protected function getSuperGlobalsHash()
    {
        $globals = [];
        foreach (StateCheckerConfig::get('globalKeys') as $globalKey) {
            $globals[$globalKey] = $this->getHash(isset($GLOBALS[$globalKey]) ? $GLOBALS[$globalKey] : null, 'globals::' . $globalKey);
        }
        
        $hash = $this->getHash($globals, 'globals');
        return $hash;
    }
    
    // -------------- ERROR LEVEL -------------
    
    /**
     *
     * @return string hash
     */
    protected function getErrorLevelHash()
    {
        $level = error_reporting();
        $hash = $this->getHash($level, 'errlevel');
        return $hash;
    }
    
    // ------------- PHP CONFIGURATION OPTIONS ---------------
    
    protected function getPHPConfigOptionsHash()
    {
        $configOptions = StateSaver::getPHPConfigOptions();
        $hash = $this->getHash($configOptions, 'phpconfopt');
        return $hash;
    }
    
    // -------------- ALL ----------------------
    
    
    protected $lashHashAll = null;
    
    public function getLastHashAll() {
        return $this->lashHashAll;
    }
    
    /**
     * Retrieve a hash of all 
     * 
     * @return string hash
     */
    public function getStateHash()
    {
        $hashes['database'] = $this->getDatabaseHash();
        $hashes['filesys'] = $this->getFilesystemHash();
        $hashes['globals'] = $this->getSuperGlobalsHash();
        $hashes['errlevel'] = $this->getErrorLevelHash();
        $hashes['phpconf'] = $this->getPHPConfigOptionsHash();
        $this->lashHashAll = $this->getHash($hashes, 'state');
        return $this->lashHashAll;
    }
}
