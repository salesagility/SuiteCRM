<?php

/*

Modification information for LGPL compliance

r58602 - 2010-10-20 14:33:52 -0700 (Wed, 20 Oct 2010) - engsvnbuild - Author: Stanislav Malyshev <smalyshev@gmail.com>
    handle Japanese semicolons too

r58597 - 2010-10-20 11:40:04 -0700 (Wed, 20 Oct 2010) - engsvnbuild - Author: Jenny Gonsalves <jenny@sugarcrm.com>
    Revert "Merge branch 'RC2'"

r58596 - 2010-10-20 09:50:45 -0700 (Wed, 20 Oct 2010) - engsvnbuild - Merge: a813190 e0a061b
Author: Jenny Gonsalves <jenny@sugarcrm.com>
    Merge branch 'RC2'

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r24313 - 2007-07-13 15:01:40 -0700 (Fri, 13 Jul 2007) - clee - Added file.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty strip_semicolon modifier plugin
 *
 * Type:     modifier<br>
 * Name:     strip<br>
 * Purpose:  Replace strings with trailing semicolon with blank string
 * @author   Collin Lee
 * @version  1.0
 * @param string
 * @return string
 */
function smarty_modifier_strip_semicolon($text)
{
    return preg_replace("/([:]|\xEF\xBC\x9A)[\\s]*$/", '', trim($text));
}
