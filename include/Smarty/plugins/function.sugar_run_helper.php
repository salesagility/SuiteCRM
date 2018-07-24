<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r56153 - 2010-04-28 15:37:27 -0700 (Wed, 28 Apr 2010) - asandberg - Bug #35808 - Tab ordering for fields is inconsistent specifically for the "Email Address" and "Teams" fields
Modified SugarFieldBase file, displayFromFunc function to propagate the tabindex down the call stack and the email address widget to utilize the value

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r54415 - 2010-02-10 07:58:39 -0800 (Wed, 10 Feb 2010) - jmertic - Bug 35628 - Fixed SQL error showing when importing into a currency field. Also fixes unit test failure of properly rendering the currency field widget.

r54369 - 2010-02-08 16:33:57 -0800 (Mon, 08 Feb 2010) - rob - Bug 35453: Add support for vardef functions to return various html, bypassing the sugar fields


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_field} function plugin
 *
 * Type:     function
 * Name:     sugar_run_helper
 * Purpose:  Runs helper functions as defined in the vardef for specific fields
 *
 * @author Rob Aagaard {rob at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_run_helper($params, &$smarty)
{
    $error = false;
    
    if (!isset($params['func'])) {
        $error = true;
        $smarty->trigger_error("sugar_field: missing 'func' parameter");
    }
    if (!isset($params['displayType'])) {
        $error = true;
        $smarty->trigger_error("sugar_field: missing 'displayType' parameter");
    }
    if (!isset($params['bean'])) {
        $params['bean'] = $GLOBALS['focus'];
    }

    if ($error) {
        return;
    }

    $funcName = $params['func'];

    if (!empty($params['include'])) {
        require_once($params['include']);
    }

    $_contents = $funcName($params['bean'], $params['field'], $params['value'], $params['displayType'], $params['tabindex']);
    return $_contents;
}
