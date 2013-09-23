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
 * create full directory structure
 *
 * @param string $dir
 */

// $dir

function smarty_core_create_dir_structure($params, &$smarty)
{
    if (!file_exists($params['dir'])) {
        $_open_basedir_ini = ini_get('open_basedir');

        if (DIRECTORY_SEPARATOR=='/') {
            /* unix-style paths */
            $_dir = $params['dir'];
            $_dir_parts = preg_split('!/+!', $_dir, -1, PREG_SPLIT_NO_EMPTY);
            $_new_dir = (substr($_dir, 0, 1)=='/') ? '/' : getcwd().'/';
            if($_use_open_basedir = !empty($_open_basedir_ini)) {
                $_open_basedirs = explode(':', $_open_basedir_ini);
            }

        } else {
            /* other-style paths */
            $_dir = str_replace('\\','/', $params['dir']);
            $_dir_parts = preg_split('!/+!', $_dir, -1, PREG_SPLIT_NO_EMPTY);
            if (preg_match('!^((//)|([a-zA-Z]:/))!', $_dir, $_root_dir)) {
                /* leading "//" for network volume, or "[letter]:/" for full path */
                $_new_dir = $_root_dir[1];
                /* remove drive-letter from _dir_parts */
                if (isset($_root_dir[3])) array_shift($_dir_parts);

            } else {
                $_new_dir = str_replace('\\', '/', getcwd()).'/';

            }

            if($_use_open_basedir = !empty($_open_basedir_ini)) {
                $_open_basedirs = explode(';', str_replace('\\', '/', $_open_basedir_ini));
            }

        }

        /* all paths use "/" only from here */
        foreach ($_dir_parts as $_dir_part) {
            $_new_dir .= $_dir_part;

            if ($_use_open_basedir) {
                // do not attempt to test or make directories outside of open_basedir
                $_make_new_dir = false;
                foreach ($_open_basedirs as $_open_basedir) {
                    if (substr($_new_dir, 0, strlen($_open_basedir)) == $_open_basedir) {
                        $_make_new_dir = true;
                        break;
                    }
                }
            } else {
                $_make_new_dir = true;
            }

            if ($_make_new_dir && !file_exists($_new_dir) && !@mkdir($_new_dir, $smarty->_dir_perms) && !is_dir($_new_dir)) {
                $smarty->trigger_error("problem creating directory '" . $_new_dir . "'");
                return false;
            }
            $_new_dir .= '/';
        }
    }
}

/* vim: set expandtab: */

?>
