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


require_once('include/SugarCache/SugarCacheAbstract.php');

class SugarCacheMemcache extends SugarCacheAbstract
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
     * @var Memcache object
     */
    protected $_memcache = '';

    /**
     * @see SugarCacheAbstract::$_priority
     */
    protected $_priority = 900;

    /**
     * Minimal data size to be compressed
     * @var int
     */
    protected $min_compress = 512;
    /**
     * @see SugarCacheAbstract::useBackend()
     */
    public function useBackend()
    {
        if (extension_loaded('memcache')
                && empty($GLOBALS['sugar_config']['external_cache_disabled_memcache'])
                && $this->_getMemcacheObject()) {
            return true;
        }

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
     * Get the memcache object; initialize if needed
     */
    protected function _getMemcacheObject()
    {
        if (!($this->_memcache instanceof Memcache)) {
            $this->_memcache = new Memcache();
            $config = SugarConfig::getInstance();
            $this->_host = $config->get('external_cache.memcache.host', $this->_host);
            $this->_port = $config->get('external_cache.memcache.port', $this->_port);
            if (!@$this->_memcache->connect($this->_host, $this->_port)) {
                return false;
            }
            if ($config->get('external_cache.memcache.disable_compression', false)) {
                $this->_memcache->setCompressThreshold($config->get('external_cache.memcache.min_compression', $this->min_compress));
            } else {
                $this->_memcache->setCompressThreshold(0);
            }
        }

        return $this->_memcache;
    }

    /**
     * @see SugarCacheAbstract::_setExternal()
     */
    protected function _setExternal(
        $key,
        $value
        ) {
        $this->_getMemcacheObject()->set($key, $value, 0, $this->_expireTimeout);
    }

    /**
     * @see SugarCacheAbstract::_getExternal()
     */
    protected function _getExternal(
        $key
        ) {
        $returnValue = $this->_getMemcacheObject()->get($key);
        if ($returnValue === false) {
            return null;
        }

        return $returnValue;
    }

    /**
     * @see SugarCacheAbstract::_clearExternal()
     */
    protected function _clearExternal(
        $key
        ) {
        $this->_getMemcacheObject()->delete($key);
    }

    /**
     * @see SugarCacheAbstract::_resetExternal()
     */
    protected function _resetExternal()
    {
        $this->_getMemcacheObject()->flush();
    }
}
