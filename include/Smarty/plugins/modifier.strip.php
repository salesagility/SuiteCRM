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

r24314 - 2007-07-13 15:02:02 -0700 (Fri, 13 Jul 2007) - clee - Reverted previous changes.

r24312 - 2007-07-13 14:59:55 -0700 (Fri, 13 Jul 2007) - clee - Reverted previous changes.

r24309 - 2007-07-13 14:41:48 -0700 (Fri, 13 Jul 2007) - clee - Safeguard against labels with existing semi-colon.

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty strip modifier plugin
 *
 * Type:     modifier<br>
 * Name:     strip<br>
 * Purpose:  Replace all repeated spaces, newlines, tabs
 *           with a single space or supplied replacement string.<br>
 * Example:  {$var|strip} {$var|strip:"&nbsp;"}
 * Date:     September 25th, 2002
 * @link http://smarty.php.net/manual/en/language.modifier.strip.php
 *          strip (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @version  1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_strip($text, $replace = ' ')
{   
    return preg_replace('!\s+!', $replace, $text);
}

/* vim: set expandtab: */

?>
