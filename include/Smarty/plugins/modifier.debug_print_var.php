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
 * Smarty debug_print_var modifier plugin
 *
 * Type:     modifier<br>
 * Name:     debug_print_var<br>
 * Purpose:  formats variable contents for display in the console
 * @link http://smarty.php.net/manual/en/language.modifier.debug.print.var.php
 *          debug_print_var (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param array|object
 * @param integer
 * @param integer
 * @return string
 */
function smarty_modifier_debug_print_var($var, $depth = 0, $length = 40)
{
    $_replace = array("\n"=>'<i>&#92;n</i>', "\r"=>'<i>&#92;r</i>', "\t"=>'<i>&#92;t</i>');
    if (is_array($var)) {
        $results = "<b>Array (".count($var).")</b>";
        foreach ($var as $curr_key => $curr_val) {
            $return = smarty_modifier_debug_print_var($curr_val, $depth+1, $length);
            $results .= "<br>".str_repeat('&nbsp;', $depth*2)."<b>".strtr($curr_key, $_replace)."</b> =&gt; $return";
        }
    } else if (is_object($var)) {
        $object_vars = get_object_vars($var);
        $results = "<b>".get_class($var)." Object (".count($object_vars).")</b>";
        foreach ($object_vars as $curr_key => $curr_val) {
            $return = smarty_modifier_debug_print_var($curr_val, $depth+1, $length);
            $results .= "<br>".str_repeat('&nbsp;', $depth*2)."<b>$curr_key</b> =&gt; $return";
        }
    } else if (is_resource($var)) {
        $results = '<i>'.(string)$var.'</i>';
    } else if (empty($var) && $var != "0") {
        $results = '<i>empty</i>';
    } else {
        if (strlen($var) > $length ) {
            $results = substr($var, 0, $length-3).'...';
        } else {
            $results = $var;
        }
        $results = htmlspecialchars($results);
        $results = strtr($results, $_replace);
    }
    return $results;
}

/* vim: set expandtab: */

?>
