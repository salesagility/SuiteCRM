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


/**
 * Sugar Cache manager
 * @api
 */
class SugarCache
{
    const EXTERNAL_CACHE_NULL_VALUE = "SUGAR_CACHE_NULL_ZZ";

    protected static $_cacheInstance;

    /**
     * @var true if the cache has been reset during this request, so we no longer return values from
     *      cache until the next reset
     */
    public static $isCacheReset = false;

    private function __construct() {}

    /**
     * initializes the cache in question
     */
    protected static function _init()
    {
        $lastPriority = 1000;
        $locations = array('include/SugarCache','custom/include/SugarCache');
 	    foreach ( $locations as $location ) {
            if (sugar_is_dir($location) && $dir = opendir($location)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == ".."
                            || $file == "."
                            || !is_file("$location/$file")
                            )
                        continue;
                    require_once("$location/$file");
                    $cacheClass = basename($file, ".php");
                    if ( class_exists($cacheClass) && is_subclass_of($cacheClass,'SugarCacheAbstract') ) {
                        $GLOBALS['log']->debug("Found cache backend $cacheClass");
                        $cacheInstance = new $cacheClass();
                        if ( $cacheInstance->useBackend()
                                && $cacheInstance->getPriority() < $lastPriority ) {
                            $GLOBALS['log']->debug("Using cache backend $cacheClass, since ".$cacheInstance->getPriority()." is less than ".$lastPriority);
                            self::$_cacheInstance = $cacheInstance;
                            $lastPriority = $cacheInstance->getPriority();
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns the instance of the SugarCacheAbstract object, cooresponding to the external
     * cache being used.
     */
    public static function instance()
    {
        if ( !is_subclass_of(self::$_cacheInstance,'SugarCacheAbstract') )
            self::_init();

        return self::$_cacheInstance;
    }

    /**
     * Try to reset any opcode caches we know about
     *
     * @todo make it so developers can extend this somehow
     */
    public static function cleanOpcodes()
    {
        // APC
        if ( function_exists('apc_clear_cache') && ini_get('apc.stat') == 0 ) {
            apc_clear_cache();
        }
        // Wincache
        if ( function_exists('wincache_refresh_if_changed') ) {
            wincache_refresh_if_changed();
        }
        // Zend
        if ( function_exists('accelerator_reset') ) {
            accelerator_reset();
        }
        // eAccelerator
        if ( function_exists('eaccelerator_clear') ) {
            eaccelerator_clear();
        }
        // XCache
        if ( function_exists('xcache_clear_cache') && !ini_get('xcache.admin.enable_auth') ) {
            $max = xcache_count(XC_TYPE_PHP);
            for ($i = 0; $i < $max; $i++) {
                if (!xcache_clear_cache(XC_TYPE_PHP, $i)) {
                    break;
                }
            }
        }
    }

    /**
     * Try to reset file from caches
     */
    public static function cleanFile( $file )
    {
        // APC
        if ( function_exists('apc_delete_file') && ini_get('apc.stat') == 0 )
        {
            apc_delete_file( $file );
        }
    }
}

/**
 * Procedural API for external cache
 */

/**
 * Retrieve a key from cache.  For the Zend Platform, a maximum age of 5 minutes is assumed.
 *
 * @param String $key -- The item to retrieve.
 * @return The item unserialized
 */
function sugar_cache_retrieve($key)
{
    return SugarCache::instance()->$key;
}

/**
 * Put a value in the cache under a key
 *
 * @param String $key -- Global namespace cache.  Key for the data.
 * @param Serializable $value -- The value to store in the cache.
 */
function sugar_cache_put($key, $value, $ttl = null)
{
    SugarCache::instance()->set($key,$value, $ttl);
}

/**
 * Clear a key from the cache.  This is used to invalidate a single key.
 *
 * @param String $key -- Key from global namespace
 */
function sugar_cache_clear($key)
{
    unset(SugarCache::instance()->$key);
}

/**
 * Turn off external caching for the rest of this round trip and for all round
 * trips for the next cache timeout.  This function should be called when global arrays
 * are affected (studio, module loader, upgrade wizard, ... ) and it is not ok to
 * wait for the cache to expire in order to see the change.
 */
function sugar_cache_reset()
{
    SugarCache::instance()->reset();
    SugarCache::cleanOpcodes();
}

/**
 * Flush the cache in its entirety including the local and external store along with the opcodes.
 */
function sugar_cache_reset_full()
{
    SugarCache::instance()->resetFull();
    SugarCache::cleanOpcodes();
}

/**
 * Clean out whatever opcode cache we may have out there.
 */
function sugar_clean_opcodes()
{
    SugarCache::cleanOpcodes();
}

/**
 * Internal -- Determine if there is an external cache available for use.
 *
 * @deprecated
 */
function check_cache()
{
    SugarCache::instance();
}

/**
 * This function is called once an external cache has been identified to ensure that it is correctly
 * working.
 *
 * @deprecated
 *
 * @return true for success, false for failure.
 */
function sugar_cache_validate()
{
    $instance = SugarCache::instance();

    return is_object($instance);
}

/**
 * Internal -- This function actually retrieves information from the caches.
 * It is a helper function that provides that actual cache API abstraction.
 *
 * @param unknown_type $key
 * @return unknown
 * @deprecated
 * @see sugar_cache_retrieve
 */
function external_cache_retrieve_helper($key)
{
    return SugarCache::instance()->$key;
}
