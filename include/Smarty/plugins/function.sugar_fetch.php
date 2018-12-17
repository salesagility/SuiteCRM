<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r53409 - 2010-01-03 19:31:15 -0800 (Sun, 03 Jan 2010) - roger - merge -r50376:HEAD from fuji_newtag_tmp


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_fetch} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_fetch<br>
 * Purpose:  grabs the requested index from either an object or an array
 *
 * @author Rob Aagaard {rob at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_fetch($params, &$smarty)
{
    if (empty($params['key'])) {
        $smarty->trigger_error("sugar_fetch: missing 'key' parameter");
        return;
    }
    if (empty($params['object'])) {
        $smarty->trigger_error("sugar_fetch: missing 'object' parameter");
        return;
    }
    
    $theKey = $params['key'];
    if (is_object($params['object'])) {
        $theData = $params['object']->$theKey;
    } else {
        $theData = $params['object'][$theKey];
    }

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $theData);
    } else {
        return $theData;
    }
}
