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
 * Smarty {math} function plugin
 *
 * Type:     function<br>
 * Name:     math<br>
 * Purpose:  handle math computations in template<br>
 * @link http://smarty.php.net/manual/en/language.function.math.php {math}
 *          (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_math($params, &$smarty)
{
    // be sure equation parameter is present
    if (empty($params['equation'])) {
        $smarty->trigger_error("math: missing equation parameter");
        return;
    }

    $equation = $params['equation'];

    // make sure parenthesis are balanced
    if (substr_count($equation,"(") != substr_count($equation,")")) {
        $smarty->trigger_error("math: unbalanced parenthesis");
        return;
    }

    // match all vars in equation, make sure all are passed
    preg_match_all("!(?:0x[a-fA-F0-9]+)|([a-zA-Z][a-zA-Z0-9_]+)!",$equation, $match);
    $allowed_funcs = array('int','abs','ceil','cos','exp','floor','log','log10',
                           'max','min','pi','pow','rand','round','sin','sqrt','srand','tan');
    
    foreach($match[1] as $curr_var) {
        if ($curr_var && !in_array($curr_var, array_keys($params)) && !in_array($curr_var, $allowed_funcs)) {
            $smarty->trigger_error("math: function call $curr_var not allowed");
            return;
        }
    }

    foreach($params as $key => $val) {
        if ($key != "equation" && $key != "format" && $key != "assign") {
            // make sure value is not empty
            if (strlen($val)==0) {
                $smarty->trigger_error("math: parameter $key is empty");
                return;
            }
            if (!is_numeric($val)) {
                $smarty->trigger_error("math: parameter $key: is not numeric");
                return;
            }
            $equation = preg_replace("/\b$key\b/",$val, $equation);
        }
    }

    eval("\$smarty_math_result = ".$equation.";");

    if (empty($params['format'])) {
        if (empty($params['assign'])) {
            return $smarty_math_result;
        } else {
            $smarty->assign($params['assign'],$smarty_math_result);
        }
    } else {
        if (empty($params['assign'])){
            printf($params['format'],$smarty_math_result);
        } else {
            $smarty->assign($params['assign'],sprintf($params['format'],$smarty_math_result));
        }
    }
}

/* vim: set expandtab: */

?>
