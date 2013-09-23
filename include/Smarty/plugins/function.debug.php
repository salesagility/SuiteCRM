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
 * Smarty {debug} function plugin
 *
 * Type:     function<br>
 * Name:     debug<br>
 * Date:     July 1, 2002<br>
 * Purpose:  popup debug window
 * @link http://smarty.php.net/manual/en/language.function.debug.php {debug}
 *       (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string output from {@link Smarty::_generate_debug_output()}
 */
function smarty_function_debug($params, &$smarty)
{
    if (isset($params['output'])) {
        $smarty->assign('_smarty_debug_output', $params['output']);
    }
    require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
    return smarty_core_display_debug_console(null, $smarty);
}

/* vim: set expandtab: */

?>
