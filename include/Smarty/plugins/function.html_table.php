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
 * Smarty {html_table} function plugin
 *
 * Type:     function<br>
 * Name:     html_table<br>
 * Date:     Feb 17, 2003<br>
 * Purpose:  make an html table from an array of data<br>
 * Input:<br>
 *         - loop = array to loop through
 *         - cols = number of columns
 *         - rows = number of rows
 *         - table_attr = table attributes
 *         - tr_attr = table row attributes (arrays are cycled)
 *         - td_attr = table cell attributes (arrays are cycled)
 *         - trailpad = value to pad trailing cells with
 *         - vdir = vertical direction (default: "down", means top-to-bottom)
 *         - hdir = horizontal direction (default: "right", means left-to-right)
 *         - inner = inner loop (default "cols": print $loop line by line,
 *                   $loop will be printed column by column otherwise)
 *
 *
 * Examples:
 * <pre>
 * {table loop=$data}
 * {table loop=$data cols=4 tr_attr='"bgcolor=red"'}
 * {table loop=$data cols=4 tr_attr=$colors}
 * </pre>
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @version  1.0
 * @link http://smarty.php.net/manual/en/language.function.html.table.php {html_table}
 *          (Smarty online manual)
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_table($params, &$smarty)
{
    $table_attr = 'border="1"';
    $tr_attr = '';
    $td_attr = '';
    $cols = 3;
    $rows = 3;
    $trailpad = '&nbsp;';
    $vdir = 'down';
    $hdir = 'right';
    $inner = 'cols';

    if (!isset($params['loop'])) {
        $smarty->trigger_error("html_table: missing 'loop' parameter");
        return;
    }

    foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'loop':
                $$_key = (array)$_value;
                break;

            case 'cols':
            case 'rows':
                $$_key = (int)$_value;
                break;

            case 'table_attr':
            case 'trailpad':
            case 'hdir':
            case 'vdir':
            case 'inner':
                $$_key = (string)$_value;
                break;

            case 'tr_attr':
            case 'td_attr':
                $$_key = $_value;
                break;
        }
    }

    $loop_count = count($loop);
    if (empty($params['rows'])) {
        /* no rows specified */
        $rows = ceil($loop_count/$cols);
    } elseif (empty($params['cols'])) {
        if (!empty($params['rows'])) {
            /* no cols specified, but rows */
            $cols = ceil($loop_count/$rows);
        }
    }

    $output = "<table $table_attr>\n";

    for ($r=0; $r<$rows; $r++) {
        $output .= "<tr" . smarty_function_html_table_cycle('tr', $tr_attr, $r) . ">\n";
        $rx =  ($vdir == 'down') ? $r*$cols : ($rows-1-$r)*$cols;

        for ($c=0; $c<$cols; $c++) {
            $x =  ($hdir == 'right') ? $rx+$c : $rx+$cols-1-$c;
            if ($inner!='cols') {
                /* shuffle x to loop over rows*/
                $x = floor($x/$cols) + ($x%$cols)*$rows;
            }

            if ($x<$loop_count) {
                $output .= "<td" . smarty_function_html_table_cycle('td', $td_attr, $c) . ">" . $loop[$x] . "</td>\n";
            } else {
                $output .= "<td" . smarty_function_html_table_cycle('td', $td_attr, $c) . ">$trailpad</td>\n";
            }
        }
        $output .= "</tr>\n";
    }
    $output .= "</table>\n";
    
    return $output;
}

function smarty_function_html_table_cycle($name, $var, $no) {
    if(!is_array($var)) {
        $ret = $var;
    } else {
        $ret = $var[$no % count($var)];
    }
    
    return ($ret) ? ' '.$ret : '';
}


/* vim: set expandtab: */

?>
