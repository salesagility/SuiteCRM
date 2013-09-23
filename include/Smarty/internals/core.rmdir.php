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
 * delete a dir recursively (level=0 -> keep root)
 * WARNING: no tests, it will try to remove what you tell it!
 *
 * @param string $dirname
 * @param integer $level
 * @param integer $exp_time
 * @return boolean
 */

//  $dirname, $level = 1, $exp_time = null

function smarty_core_rmdir($params, &$smarty)
{
   if(!isset($params['level'])) { $params['level'] = 1; }
   if(!isset($params['exp_time'])) { $params['exp_time'] = null; }

   if($_handle = @opendir($params['dirname'])) {

        while (false !== ($_entry = readdir($_handle))) {
            if ($_entry != '.' && $_entry != '..') {
                if (@is_dir($params['dirname'] . DIRECTORY_SEPARATOR . $_entry)) {
                    $_params = array(
                        'dirname' => $params['dirname'] . DIRECTORY_SEPARATOR . $_entry,
                        'level' => $params['level'] + 1,
                        'exp_time' => $params['exp_time']
                    );
                    smarty_core_rmdir($_params, $smarty);
                }
                else {
                    $smarty->_unlink($params['dirname'] . DIRECTORY_SEPARATOR . $_entry, $params['exp_time']);
                }
            }
        }
        closedir($_handle);
   }

   if ($params['level']) {
       return @rmdir($params['dirname']);
   }
   return (bool)$_handle;

}

/* vim: set expandtab: */

?>
