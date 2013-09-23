<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * read a cache file, determine if it needs to be
 * regenerated or not
 *
 * @param string $tpl_file
 * @param string $cache_id
 * @param string $compile_id
 * @param string $results
 * @return boolean
 */

//  $tpl_file, $cache_id, $compile_id, &$results

function smarty_core_read_cache_file(&$params, &$smarty)
{
    static  $content_cache = array();

    if ($smarty->force_compile) {
        // force compile enabled, always regenerate
        return false;
    }

    if (isset($content_cache[$params['tpl_file'].','.$params['cache_id'].','.$params['compile_id']])) {
        list($params['results'], $smarty->_cache_info) = $content_cache[$params['tpl_file'].','.$params['cache_id'].','.$params['compile_id']];
        return true;
    }

    if (!empty($smarty->cache_handler_func)) {
        // use cache_handler function
        call_user_func_array($smarty->cache_handler_func,
                             array('read', &$smarty, &$params['results'], $params['tpl_file'], $params['cache_id'], $params['compile_id'], null));
    } else {
        // use local cache file
        $_auto_id = $smarty->_get_auto_id($params['cache_id'], $params['compile_id']);
        $_cache_file = $smarty->_get_auto_filename($smarty->cache_dir, $params['tpl_file'], $_auto_id);
        $params['results'] = $smarty->_read_file($_cache_file);
    }

    if (empty($params['results'])) {
        // nothing to parse (error?), regenerate cache
        return false;
    }

    $_contents = $params['results'];
    $_info_start = strpos($_contents, "\n") + 1;
    $_info_len = (int)substr($_contents, 0, $_info_start - 1);
    $_cache_info = unserialize(substr($_contents, $_info_start, $_info_len));
    $params['results'] = substr($_contents, $_info_start + $_info_len);

    if ($smarty->caching == 2 && isset ($_cache_info['expires'])){
        // caching by expiration time
        if ($_cache_info['expires'] > -1 && (time() > $_cache_info['expires'])) {
            // cache expired, regenerate
            return false;
        }
    } else {
        // caching by lifetime
        if ($smarty->cache_lifetime > -1 && (time() - $_cache_info['timestamp'] > $smarty->cache_lifetime)) {
            // cache expired, regenerate
            return false;
        }
    }

    if ($smarty->compile_check) {
        $_params = array('get_source' => false, 'quiet'=>true);
        foreach (array_keys($_cache_info['template']) as $_template_dep) {
            $_params['resource_name'] = $_template_dep;
            if (!$smarty->_fetch_resource_info($_params) || $_cache_info['timestamp'] < $_params['resource_timestamp']) {
                // template file has changed, regenerate cache
                return false;
            }
        }

        if (isset($_cache_info['config'])) {
            $_params = array('resource_base_path' => $smarty->config_dir, 'get_source' => false, 'quiet'=>true);
            foreach (array_keys($_cache_info['config']) as $_config_dep) {
                $_params['resource_name'] = $_config_dep;
                if (!$smarty->_fetch_resource_info($_params) || $_cache_info['timestamp'] < $_params['resource_timestamp']) {
                    // config file has changed, regenerate cache
                    return false;
                }
            }
        }
    }

    $content_cache[$params['tpl_file'].','.$params['cache_id'].','.$params['compile_id']] = array($params['results'], $_cache_info);

    $smarty->_cache_info = $_cache_info;
    return true;
}

/* vim: set expandtab: */

?>
