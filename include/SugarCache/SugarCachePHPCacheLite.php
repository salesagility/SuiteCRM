<?php

/********************************************************************************
 * Copyleft © 2016 gcoop - Cooperativa de Software Libre <http://gcoop.coop>.
 * Julian Alvarez 958 (1414), Ciudad Autónoma de Buenos Aires, Argentina
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/



require_once('include/SugarCache/SugarCacheAbstract.php');

class SugarCachePHPCacheLite extends SugarCacheAbstract
{
    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 99;
    protected $cacheLite;

    public function __construct(){
        parent::__construct();
        $this->getCacheLite();
    }


    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend(){
        // we'll always have this backend available
        return true;
    }

    /**
     * @see SugarCacheAbstract::_setExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _setExternal($key,$value){
    }

    /**
     * @see SugarCacheAbstract::_getExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _getExternal($key){
    }

    /**
     * @see SugarCacheAbstract::_clearExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _clearExternal($key){
    }

    /**
     * @see SugarCacheAbstract::_resetExternal()
     *
     * Does nothing; cache is gone after request is done.
     */
    protected function _resetExternal(){
    }


    /**
     * Reset the cache fully
     */
    public function resetFull(){
        return $this->cacheLite->clean();
    }


    /**
     *  Set a value for a key in the cache, optionally specify a ttl. A ttl value of zero
     * will indicate that a value should only be stored per the request.
     *
     * @param $key
     * @param $value
     * @param $ttl
     */
    public function set($key, $value, $ttl = null){
        global $log;

        if(is_null($value)){
            $value = SugarCache::EXTERNAL_CACHE_NULL_VALUE;
        }
        else{
            $config = SugarConfig::getInstance();
            $v = @unserialize(base64_decode($key));
            $msg = 'CACHE SAVED! key: ';

            if(is_array($v)){
                $this->cacheLite->save($value, $v['id'], $v['group']);
                $log->debug($msg . $v['id']);
            }
            else{
                $this->cacheLite->save($value, $key);
                $log->debug($msg . $key);
            }
        }
    }


    /**
     * PHP's magic __get() method, used here for getting the current value from the cache.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key){
        global $log;
        $ret = '';
        $v = @unserialize(base64_decode($key));

        if(is_array($v)){
            $ret = $this->cacheLite->get($v['id'], $v['group']);
        }
        else{
            $ret = $this->cacheLite->get($key);
        }

        $msg = 'CACHE HIT! key: ';
        if(!empty($ret)){
            $log->debug($msg . $key);
        }
        else{
            $msg = 'NO CACHE HIT! key: ';
            $log->debug($msg . $key);
        }

        return $ret;
    }


    /**
     * Clean a group cache in CacheLite
     *
     * @param  string $group
     * @return mixed
     */
    public function clean($group = 'default'){
        return $this->cacheLite->clean($group);
    }


    /**
     * Remove the given cache file (specified with its id and group)
     *
     * @param string $id cache id
     * @param  string $group name of the cache group
     * @return mixed
     */
    public function remove($id, $group = 'default'){
        return $this->cacheLite->remove($id, $group);
    }

    function getCacheLite(){
        $cache_lifetime = 600;
        $config = SugarConfig::getInstance();

        if(!empty($config->get('CacheLite')['LifeTime'])){
            $cache_lifetime = $config->get('CacheLite')['LifeTime'];
        }
        require_once('include/CacheLite/Cache/Lite.php');
        $options = array(
            'cacheDir' => dirname( __FILE__) . '/../../cache/',
            'lifeTime' => $cache_lifetime ,
            'automaticSerialization' => true,
            'automaticCleaningFactor' => 20,
            'readControlType' => 'md5',
        );
        $this->cacheLite = new Cache_Lite($options);
    }
}