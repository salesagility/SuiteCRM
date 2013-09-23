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
 * Replace nocache-tags by results of the corresponding non-cacheable
 * functions and return it
 *
 * @param string $compiled_tpl
 * @param string $cached_source
 * @return string
 */

function smarty_core_process_compiled_include($params, &$smarty)
{
    $_cache_including = $smarty->_cache_including;
    $smarty->_cache_including = true;

    $_return = $params['results'];

    foreach ($smarty->_cache_info['cache_serials'] as $_include_file_path=>$_cache_serial) {
        $smarty->_include($_include_file_path, true);
    }

    foreach ($smarty->_cache_serials as $_include_file_path=>$_cache_serial) {
        $_return = preg_replace_callback('!(\{nocache\:('.$_cache_serial.')#(\d+)\})!s',
                                         array(&$smarty, '_process_compiled_include_callback'),
                                         $_return);
    }
    $smarty->_cache_including = $_cache_including;
    return $_return;
}

?>
