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
 * Smarty {cycle} function plugin
 *
 * Type:     function<br>
 * Name:     cycle<br>
 * Date:     May 3, 2002<br>
 * Purpose:  cycle through given values<br>
 * Input:
 *         - name = name of cycle (optional)
 *         - values = comma separated list of values to cycle,
 *                    or an array of values to cycle
 *                    (this can be left out for subsequent calls)
 *         - reset = boolean - resets given var to true
 *         - print = boolean - print var or not. default is true
 *         - advance = boolean - whether or not to advance the cycle
 *         - delimiter = the value delimiter, default is ","
 *         - assign = boolean, assigns to template var instead of
 *                    printed.
 *
 * Examples:<br>
 * <pre>
 * {cycle values="#eeeeee,#d0d0d0d"}
 * {cycle name=row values="one,two,three" reset=true}
 * {cycle name=row}
 * </pre>
 * @link http://smarty.php.net/manual/en/language.function.cycle.php {cycle}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author credit to Mark Priatel <mpriatel@rogers.com>
 * @author credit to Gerard <gerard@interfold.com>
 * @author credit to Jason Sweat <jsweat_php@yahoo.com>
 * @version  1.3
 * @param array
 * @param Smarty
 * @return string|null
 */
function smarty_function_cycle($params, &$smarty)
{
    static $cycle_vars;
    
    $name = (empty($params['name'])) ? 'default' : $params['name'];
    $print = (isset($params['print'])) ? (bool)$params['print'] : true;
    $advance = (isset($params['advance'])) ? (bool)$params['advance'] : true;
    $reset = (isset($params['reset'])) ? (bool)$params['reset'] : false;
            
    if (!in_array('values', array_keys($params))) {
        if(!isset($cycle_vars[$name]['values'])) {
            $smarty->trigger_error("cycle: missing 'values' parameter");
            return;
        }
    } else {
        if(isset($cycle_vars[$name]['values'])
            && $cycle_vars[$name]['values'] != $params['values'] ) {
            $cycle_vars[$name]['index'] = 0;
        }
        $cycle_vars[$name]['values'] = $params['values'];
    }

    $cycle_vars[$name]['delimiter'] = (isset($params['delimiter'])) ? $params['delimiter'] : ',';
    
    if(is_array($cycle_vars[$name]['values'])) {
        $cycle_array = $cycle_vars[$name]['values'];
    } else {
        $cycle_array = explode($cycle_vars[$name]['delimiter'],$cycle_vars[$name]['values']);
    }
    
    if(!isset($cycle_vars[$name]['index']) || $reset ) {
        $cycle_vars[$name]['index'] = 0;
    }
    
    if (isset($params['assign'])) {
        $print = false;
        $smarty->assign($params['assign'], $cycle_array[$cycle_vars[$name]['index']]);
    }
        
    if($print) {
        $retval = $cycle_array[$cycle_vars[$name]['index']];
    } else {
        $retval = null;
    }

    if($advance) {
        if ( $cycle_vars[$name]['index'] >= count($cycle_array) -1 ) {
            $cycle_vars[$name]['index'] = 0;
        } else {
            $cycle_vars[$name]['index']++;
        }
    }
    
    return $retval;
}

/* vim: set expandtab: */

?>
