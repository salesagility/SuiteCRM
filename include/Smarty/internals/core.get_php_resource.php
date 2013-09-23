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
 * Retrieves PHP script resource
 *
 * sets $php_resource to the returned resource
 * @param string $resource
 * @param string $resource_type
 * @param  $php_resource
 * @return boolean
 */

function smarty_core_get_php_resource(&$params, &$smarty)
{

    $params['resource_base_path'] = $smarty->trusted_dir;
    $smarty->_parse_resource_name($params, $smarty);

    /*
     * Find out if the resource exists.
     */

    if ($params['resource_type'] == 'file') {
        $_readable = false;
        if(file_exists($params['resource_name']) && is_readable($params['resource_name'])) {
            $_readable = true;
        } else {
            // test for file in include_path
            $_params = array('file_path' => $params['resource_name']);
            require_once(SMARTY_CORE_DIR . 'core.get_include_path.php');
            if(smarty_core_get_include_path($_params, $smarty)) {
                $_include_path = $_params['new_file_path'];
                $_readable = true;
            }
        }
    } else if ($params['resource_type'] != 'file') {
        $_template_source = null;
        $_readable = is_callable($smarty->_plugins['resource'][$params['resource_type']][0][0])
            && call_user_func_array($smarty->_plugins['resource'][$params['resource_type']][0][0],
                                    array($params['resource_name'], &$_template_source, &$smarty));
    }

    /*
     * Set the error function, depending on which class calls us.
     */
    if (method_exists($smarty, '_syntax_error')) {
        $_error_funcc = '_syntax_error';
    } else {
        $_error_funcc = 'trigger_error';
    }

    if ($_readable) {
        if ($smarty->security) {
            require_once(SMARTY_CORE_DIR . 'core.is_trusted.php');
            if (!smarty_core_is_trusted($params, $smarty)) {
                $smarty->$_error_funcc('(secure mode) ' . $params['resource_type'] . ':' . $params['resource_name'] . ' is not trusted');
                return false;
            }
        }
    } else {
        $smarty->$_error_funcc($params['resource_type'] . ':' . $params['resource_name'] . ' is not readable');
        return false;
    }

    if ($params['resource_type'] == 'file') {
        $params['php_resource'] = $params['resource_name'];
    } else {
        $params['php_resource'] = $_template_source;
    }
    return true;
}

/* vim: set expandtab: */

?>
