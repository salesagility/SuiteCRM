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
 * Get path to file from include_path
 *
 * @param string $file_path
 * @param string $new_file_path
 * @return boolean
 * @staticvar array|null
 */

//  $file_path, &$new_file_path

function smarty_core_get_include_path(&$params, &$smarty)
{
    static $_path_array = null;

    if(!isset($_path_array)) {
        $_ini_include_path = ini_get('include_path');

        if(strstr($_ini_include_path,';')) {
            // windows pathnames
            $_path_array = explode(';',$_ini_include_path);
        } else {
            $_path_array = explode(':',$_ini_include_path);
        }
    }
    foreach ($_path_array as $_include_path) {
        if (@is_readable($_include_path . DIRECTORY_SEPARATOR . $params['file_path'])) {
               $params['new_file_path'] = $_include_path . DIRECTORY_SEPARATOR . $params['file_path'];
            return true;
        }
    }
    return false;
}

/* vim: set expandtab: */

?>
