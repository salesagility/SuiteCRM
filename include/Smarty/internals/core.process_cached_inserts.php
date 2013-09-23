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

r10971 - 2006-01-12 14:58:30 -0800 (Thu, 12 Jan 2006) - chris - Bug 4128: updating Smarty templates to 2.6.11, a version supposedly that plays better with PHP 5.1

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Replace cached inserts with the actual results
 *
 * @param string $results
 * @return string
 */
function smarty_core_process_cached_inserts($params, &$smarty)
{
    preg_match_all('!'.$smarty->_smarty_md5.'{insert_cache (.*)}'.$smarty->_smarty_md5.'!Uis',
                   $params['results'], $match);
    list($cached_inserts, $insert_args) = $match;

    for ($i = 0, $for_max = count($cached_inserts); $i < $for_max; $i++) {
        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $debug_start_time = smarty_core_get_microtime($_params, $smarty);
        }

        $args = unserialize($insert_args[$i]);
        $name = $args['name'];

        if (isset($args['script'])) {
            $_params = array('resource_name' => $smarty->_dequote($args['script']));
            require_once(SMARTY_CORE_DIR . 'core.get_php_resource.php');
            if(!smarty_core_get_php_resource($_params, $smarty)) {
                return false;
            }
            $resource_type = $_params['resource_type'];
            $php_resource = $_params['php_resource'];


            if ($resource_type == 'file') {
                $smarty->_include($php_resource, true);
            } else {
                $smarty->_eval($php_resource);
            }
        }

        $function_name = $smarty->_plugins['insert'][$name][0];
        if (empty($args['assign'])) {
            $replace = $function_name($args, $smarty);
        } else {
            $smarty->assign($args['assign'], $function_name($args, $smarty));
            $replace = '';
        }

        $params['results'] = substr_replace($params['results'], $replace, strpos($params['results'], $cached_inserts[$i]), strlen($cached_inserts[$i]));
        if ($smarty->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $smarty->_smarty_debug_info[] = array('type'      => 'insert',
                                                'filename'  => 'insert_'.$name,
                                                'depth'     => $smarty->_inclusion_depth,
                                                'exec_time' => smarty_core_get_microtime($_params, $smarty) - $debug_start_time);
        }
    }

    return $params['results'];
}

/* vim: set expandtab: */

?>
