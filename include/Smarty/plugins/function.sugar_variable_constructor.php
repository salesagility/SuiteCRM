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

r21722 - 2007-04-11 14:18:45 -0700 (Wed, 11 Apr 2007) - wayne - sugar variable constructor plugin


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_variable_constructor} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_variable_constructor<br>
 * Purpose:  creates a smarty variable from the parameters
 *
 * @author Wayne Pan {wayne at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_variable_constructor($params, &$smarty)
{
    if (!isset($params['objectName']) || !isset($params['memberName']) || !isset($params['key'])) {
        if (!isset($params['objectName'])) {
            $smarty->trigger_error("sugar_variable_constructor: missing 'objectName' parameter");
        }
        if (!isset($params['memberName'])) {
            $smarty->trigger_error("sugar_variable_constructor: missing 'memberName' parameter");
        }
        if (!isset($params['key'])) {
            $smarty->trigger_error("sugar_variable_constructor: missing 'key' parameter");
        }
                
        return;
    }

    if (isset($params['stringFormat'])) {
        $_contents =  '$'. $params['objectName'] . '.' . $params['memberName'] . '.' . $params['key'];
    } else {
        $_contents = '{$' . $params['objectName'] . '.' . $params['memberName'] . '.' . $params['key'] . '}';
    }
    
    return $_contents;
}
