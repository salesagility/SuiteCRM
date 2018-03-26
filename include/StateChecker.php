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
use Exception;
use mysqli_result;
use MysqliManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


/**
 * Description of StateChecker
 *
 * @author SalesAgility
 */
class StateChecker {
    
    // ----------- COMMON ----------------
    
    protected $globalKeys = ['_POST', '_GET', '_REQUEST', '_SESSION', '_SERVER', '_ENV', '_FILES', '_COOKIE'];
    
    /**
     *
     * @var DBManager
     */
    protected $db;
    
    protected $hashes;
    
    protected $traces;
    
    protected $saveTraces;
    
    public function __construct($saveTraces = false, $autorun = true) {
        if(!$this->db = DBManagerFactory::getInstance()) {
            throw new Exception('DBManagerFactory get instace failure');
        }
        if(!($this->db instanceof MysqliManager)) {
            throw new Exception('Incompatible DB type, only supported: mysqli');
        }
        $this->resetHashes();
        $this->resetTraces();
        
        $this->saveTraces = $saveTraces;
                
        if($autorun) {
            $this->getStateHash();
        }
    }
    
    protected function resetTraces() {
        $this->traces = [];
    }

    protected function resetHashes() {
        $this->hashes = [];
    }
    
    protected function checkHash($hash, $key) {
        if(!isset($this->hashes[$key])) {
            $this->hashes[$key] = $hash;
        }
        $match = $this->hashes[$key] == $hash;
        return $match;
    }
    
    protected function getHash($data, $key) {
        if(!$serialized = serialize($data)) {
            throw new Exception('Serialize object failure');
        }
        $hash = md5($serialized);
        
        if(!$this->checkHash($hash, $key)) {
            throw new Exception('Hash doesn\'t match at key "' . $key . '"');
        }
        
        if($this->saveTraces) {
            $this->traces[$key][] = debug_backtrace();
        }
        
        return $hash;
    }
    
    // ------------ DATABASE ----------------
    
    protected function getMysqliResoults(mysqli_result $resource) {
        $rows = [];
        while($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    protected function getDatabaseTables() {
        if(!$tables = $this->db->tablesLike('')) {
            throw new Exception('get tables failure');
        }
        return $tables;
    }
    
    protected function getDatabaseHash() {
        $tables = $this->getDatabaseTables();
        $hashes = [];
        foreach($tables as $table) {
            $rows = $this->getMysqliResoults($this->db->query('SELECT * FROM ' . $table));
            $hashes[] = $this->getHash($rows, 'database::' . $table);
        }
        $hash = $this->getHash($hashes, 'database');
        return $hash;
    }
    
    // ------------- FILE SYSTEM ---------------
    
    protected function getFiles($path = '.') {
        if(!$realpath = realpath($path)) {
            throw new Exception('Real path can not resolved for: ' . $path);
        }

        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($realpath), RecursiveIteratorIterator::SELF_FIRST);
        $files = [];
        foreach($objects as $name => $object){
            $fileObject = $object;
            $fileObject->modifyTime = filemtime($name);
            $fileObject->hash = $this->getHash((array)$fileObject, 'filesys::' . $fileObject);
            $files[] = $name;
        }
        return $files;
    }
    
    protected function getFilesystemHash() {
        $files = $this->getFiles(__DIR__ . '/../');
        $hash = $this->getHash($files, 'filesys');
        return $hash;
    }
    
    // -------------- SUPERGLOBALS -----------------
    
    
    protected function getSuperGlobalsHash() {
        
        $globals = [];
        foreach($this->globalKeys as $globalKey) {
            $globals[$globalKey] = $this->getHash($GLOBALS[$globalKey], 'globals::' . $globalKey);
        }
        
        $hash = $this->getHash($globals, 'globals');
        return $hash;
    }
    
    // -------------- ALL ----------------------
    
    public function getStateHash() {
        $hashes['database'] = $this->getDatabaseHash();
        $hashes['filesys'] = $this->getFilesystemHash();
        $hashes['globals'] = $this->getSuperGlobalsHash();
        $hash = $this->getHash($hashes, 'state');
        return $hash;
    }
}
