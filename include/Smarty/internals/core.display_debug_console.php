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
 * Smarty debug_console function plugin
 *
 * Type:     core<br>
 * Name:     display_debug_console<br>
 * Purpose:  display the javascript debug console window
 * @param array Format: null
 * @param Smarty
 */
function smarty_core_display_debug_console($params, &$smarty)
{
    // we must force compile the debug template in case the environment
    // changed between separate applications.

    if(empty($smarty->debug_tpl)) {
        // set path to debug template from SMARTY_DIR
        $smarty->debug_tpl = SMARTY_DIR . 'debug.tpl';
        if($smarty->security && is_file($smarty->debug_tpl)) {
            $smarty->secure_dir[] = realpath($smarty->debug_tpl);
        }
        $smarty->debug_tpl = 'file:' . SMARTY_DIR . 'debug.tpl';
    }

    $_ldelim_orig = $smarty->left_delimiter;
    $_rdelim_orig = $smarty->right_delimiter;

    $smarty->left_delimiter = '{';
    $smarty->right_delimiter = '}';

    $_compile_id_orig = $smarty->_compile_id;
    $smarty->_compile_id = null;

    $_compile_path = $smarty->_get_compile_path($smarty->debug_tpl);
    if ($smarty->_compile_resource($smarty->debug_tpl, $_compile_path))
    {
        ob_start();
        $smarty->_include($_compile_path);
        $_results = ob_get_contents();
        ob_end_clean();
    } else {
        $_results = '';
    }

    $smarty->_compile_id = $_compile_id_orig;

    $smarty->left_delimiter = $_ldelim_orig;
    $smarty->right_delimiter = $_rdelim_orig;

    return $_results;
}

/* vim: set expandtab: */

?>
