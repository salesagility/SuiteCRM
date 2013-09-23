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
 * called for included php files within templates
 *
 * @param string $smarty_file
 * @param string $smarty_assign variable to assign the included template's
 *               output into
 * @param boolean $smarty_once uses include_once if this is true
 * @param array $smarty_include_vars associative array of vars from
 *              {include file="blah" var=$var}
 */

//  $file, $assign, $once, $_smarty_include_vars

function smarty_core_smarty_include_php($params, &$smarty)
{
    $_params = array('resource_name' => $params['smarty_file']);
    require_once(SMARTY_CORE_DIR . 'core.get_php_resource.php');
    smarty_core_get_php_resource($_params, $smarty);
    $_smarty_resource_type = $_params['resource_type'];
    $_smarty_php_resource = $_params['php_resource'];

    if (!empty($params['smarty_assign'])) {
        ob_start();
        if ($_smarty_resource_type == 'file') {
            $smarty->_include($_smarty_php_resource, $params['smarty_once'], $params['smarty_include_vars']);
        } else {
            $smarty->_eval($_smarty_php_resource, $params['smarty_include_vars']);
        }
        $smarty->assign($params['smarty_assign'], ob_get_contents());
        ob_end_clean();
    } else {
        if ($_smarty_resource_type == 'file') {
            $smarty->_include($_smarty_php_resource, $params['smarty_once'], $params['smarty_include_vars']);
        } else {
            $smarty->_eval($_smarty_php_resource, $params['smarty_include_vars']);
        }
    }
}


/* vim: set expandtab: */

?>
