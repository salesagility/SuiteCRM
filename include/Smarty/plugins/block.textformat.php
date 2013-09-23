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
 * Smarty {textformat}{/textformat} block plugin
 *
 * Type:     block function<br>
 * Name:     textformat<br>
 * Purpose:  format text a certain way with preset styles
 *           or custom wrap/indent settings<br>
 * @link http://smarty.php.net/manual/en/language.function.textformat.php {textformat}
 *       (Smarty online manual)
 * @param array
 * <pre>
 * Params:   style: string (email)
 *           indent: integer (0)
 *           wrap: integer (80)
 *           wrap_char string ("\n")
 *           indent_char: string (" ")
 *           wrap_boundary: boolean (true)
 * </pre>
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return string string $content re-formatted
 */
function smarty_block_textformat($params, $content, &$smarty)
{
    if (is_null($content)) {
        return;
    }

    $style = null;
    $indent = 0;
    $indent_first = 0;
    $indent_char = ' ';
    $wrap = 80;
    $wrap_char = "\n";
    $wrap_cut = false;
    $assign = null;
    
    foreach ($params as $_key => $_val) {
        switch ($_key) {
            case 'style':
            case 'indent_char':
            case 'wrap_char':
            case 'assign':
                $$_key = (string)$_val;
                break;

            case 'indent':
            case 'indent_first':
            case 'wrap':
                $$_key = (int)$_val;
                break;

            case 'wrap_cut':
                $$_key = (bool)$_val;
                break;

            default:
                $smarty->trigger_error("textformat: unknown attribute '$_key'");
        }
    }

    if ($style == 'email') {
        $wrap = 72;
    }

    // split into paragraphs
    $_paragraphs = preg_split('![\r\n][\r\n]!',$content);
    $_output = '';

    for($_x = 0, $_y = count($_paragraphs); $_x < $_y; $_x++) {
        if ($_paragraphs[$_x] == '') {
            continue;
        }
        // convert mult. spaces & special chars to single space
        $_paragraphs[$_x] = preg_replace(array('!\s+!','!(^\s+)|(\s+$)!'), array(' ',''), $_paragraphs[$_x]);
        // indent first line
        if($indent_first > 0) {
            $_paragraphs[$_x] = str_repeat($indent_char, $indent_first) . $_paragraphs[$_x];
        }
        // wordwrap sentences
        $_paragraphs[$_x] = wordwrap($_paragraphs[$_x], $wrap - $indent, $wrap_char, $wrap_cut);
        // indent lines
        if($indent > 0) {
            $_paragraphs[$_x] = preg_replace('!^!m', str_repeat($indent_char, $indent), $_paragraphs[$_x]);
        }
    }
    $_output = implode($wrap_char . $wrap_char, $_paragraphs);

    return $assign ? $smarty->assign($assign, $_output) : $_output;

}

/* vim: set expandtab: */

?>
