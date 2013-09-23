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
 * Smarty capitalize modifier plugin
 *
 * Type:     modifier<br>
 * Name:     capitalize<br>
 * Purpose:  capitalize words in the string
 * @link http://smarty.php.net/manual/en/language.modifiers.php#LANGUAGE.MODIFIER.CAPITALIZE
 *      capitalize (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_capitalize($string, $uc_digits = false)
{
    smarty_modifier_capitalize_ucfirst(null, $uc_digits);
    return preg_replace_callback('!\b\w+\b!', 'smarty_modifier_capitalize_ucfirst', $string);
}

function smarty_modifier_capitalize_ucfirst($string, $uc_digits = null)
{
    static $_uc_digits = false;
    
    if(isset($uc_digits)) {
        $_uc_digits = $uc_digits;
        return;
    }
    
    if(!preg_match('!\d!',$string[0]) || $_uc_digits)
        return ucfirst($string[0]);
    else
        return $string[0];
}


?>
