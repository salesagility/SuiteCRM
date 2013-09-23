<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


require_once('include/SugarCache/SugarCacheAbstract.php');

class SugarCacheMemcached extends SugarCacheAbstract
{
    /**
     * @var Memcache server name string
     */
    protected $_host = '127.0.0.1';
    
    /**
     * @var Memcache server port int
     */
    protected $_port = 11211;
    
    /**
     * @var Memcached object
     */
    protected $_memcached = '';
    
    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 900;
     
    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend()
    {
        if ( extension_loaded('memcached')
                && empty($GLOBALS['sugar_config']['external_cache_disabled_memcached'])
                && $this->_getMemcachedObject() )
            return true;
            
        return false;
    }
    
    /**
     * @see SugarCacheAbstract::__construct()
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get the memcached object; initialize if needed
     */
    protected function _getMemcachedObject()
    {
        if ( !($this->_memcached instanceOf Memcached) ) {
            $this->_memcached = new Memcached();
            $this->_host = SugarConfig::getInstance()->get('external_cache.memcache.host', $this->_host);
            $this->_port = SugarConfig::getInstance()->get('external_cache.memcache.port', $this->_port);
            if ( !@$this->_memcached->addServer($this->_host,$this->_port) ) {
                return false;
            }
        }
        
        return $this->_memcached;
    }
    
    /**
     * @see SugarCacheAbstract::_setExternal()
     */
    protected function _setExternal(
        $key,
        $value
        )
    {
        $this->_getMemcachedObject()->set($key, $value, $this->_expireTimeout);
    }
    
    /**
     * @see SugarCacheAbstract::_getExternal()
     */
    protected function _getExternal(
        $key
        )
    {
        $returnValue = $this->_getMemcachedObject()->get($key);
        if ( $this->_getMemcachedObject()->getResultCode() != Memcached::RES_SUCCESS ) {
            return null;
        }

        return $returnValue;
    }
    
    /**
     * @see SugarCacheAbstract::_clearExternal()
     */
    protected function _clearExternal(
        $key
        )
    {
        $this->_getMemcachedObject()->delete($key);
    }
    
    /**
     * @see SugarCacheAbstract::_resetExternal()
     */
    protected function _resetExternal()
    {
        $this->_getMemcachedObject()->flush();
    }
}
