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
 * delete an automagically created file by name and id
 *
 * @param string $auto_base
 * @param string $auto_source
 * @param string $auto_id
 * @param integer $exp_time
 * @return boolean
 */

// $auto_base, $auto_source = null, $auto_id = null, $exp_time = null

function smarty_core_rm_auto($params, &$smarty)
{
    if (!@is_dir($params['auto_base']))
      return false;

    if(!isset($params['auto_id']) && !isset($params['auto_source'])) {
        $_params = array(
            'dirname' => $params['auto_base'],
            'level' => 0,
            'exp_time' => $params['exp_time']
        );
        require_once(SMARTY_CORE_DIR . 'core.rmdir.php');
        $_res = smarty_core_rmdir($_params, $smarty);
    } else {
        $_tname = $smarty->_get_auto_filename($params['auto_base'], $params['auto_source'], $params['auto_id']);

        if(isset($params['auto_source'])) {
            if (isset($params['extensions'])) {
                $_res = false;
                foreach ((array)$params['extensions'] as $_extension)
                    $_res |= $smarty->_unlink($_tname.$_extension, $params['exp_time']);
            } else {
                $_res = $smarty->_unlink($_tname, $params['exp_time']);
            }
        } elseif ($smarty->use_sub_dirs) {
            $_params = array(
                'dirname' => $_tname,
                'level' => 1,
                'exp_time' => $params['exp_time']
            );
            require_once(SMARTY_CORE_DIR . 'core.rmdir.php');
            $_res = smarty_core_rmdir($_params, $smarty);
        } else {
            // remove matching file names
            $_handle = opendir($params['auto_base']);
            $_res = true;
            while (false !== ($_filename = readdir($_handle))) {
                if($_filename == '.' || $_filename == '..') {
                    continue;
                } elseif (substr($params['auto_base'] . DIRECTORY_SEPARATOR . $_filename, 0, strlen($_tname)) == $_tname) {
                    $_res &= (bool)$smarty->_unlink($params['auto_base'] . DIRECTORY_SEPARATOR . $_filename, $params['exp_time']);
                }
            }
        }
    }

    return $_res;
}

/* vim: set expandtab: */

?>
