<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r46793 - 2009-05-03 17:13:58 -0700 (Sun, 03 May 2009) - wdong - 28604, merge from maint520_hermosa

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r37314 - 2008-06-26 13:37:54 -0700 (Thu, 26 Jun 2008) - roger - bug: 23141 - seems is there is a $ in the value then when we do some regex to replace a placeholder it does not work properly for textareas. I took code from latest smarty download and replaced. 2.6.19

r34228 - 2008-04-16 09:41:19 -0700 (Wed, 16 Apr 2008) - jmertic - Bug 21141: Change smarty_outputfilter_trimwhitespace_replace from using substr_replace to preg_replace since the latter is mb safe.
Touched:
- include/Smarty/plugins/outputfilter.trimwhitespace.php

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty trimwhitespace outputfilter plugin
 *
 * File:     outputfilter.trimwhitespace.php<br>
 * Type:     outputfilter<br>
 * Name:     trimwhitespace<br>
 * Date:     Jan 25, 2003<br>
 * Purpose:  trim leading white space and blank lines from
 *           template source after it gets interpreted, cleaning
 *           up code and saving bandwidth. Does not affect
 *           <<PRE>></PRE> and <SCRIPT></SCRIPT> blocks.<br>
 * Install:  Drop into the plugin directory, call
 *           <code>$smarty->load_filter('output','trimwhitespace');</code>
 *           from application.
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @author Contributions from Lars Noschinski <lars@usenet.noschinski.de>
 * @version  1.3
 * @param string
 * @param Smarty
 */
function smarty_outputfilter_trimwhitespace($source, &$smarty)
{
    // Pull out the script blocks
    preg_match_all("!<script[^>]+>.*?</script>!is", $source, $match);
    $_script_blocks = $match[0];
    $source = preg_replace("!<script[^>]+>.*?</script>!is",
                           '@@@SMARTY:TRIM:SCRIPT@@@', $source);

    // Pull out the pre blocks
    preg_match_all("!<pre>.*?</pre>!is", $source, $match);
    $_pre_blocks = $match[0];
    $source = preg_replace("!<pre>.*?</pre>!is",
                           '@@@SMARTY:TRIM:PRE@@@', $source);

    // Pull out the textarea blocks
    preg_match_all("!<textarea[^>]+>.*?</textarea>!is", $source, $match);
    $_textarea_blocks = $match[0];
    $source = preg_replace("!<textarea[^>]+>.*?</textarea>!is",
                           '@@@SMARTY:TRIM:TEXTAREA@@@', $source);

    // remove all leading spaces, tabs and carriage returns NOT
    // preceeded by a php close tag.
    $source = trim(preg_replace('/((?<!\?>)\n)[\s]+/m', '\1', $source));

    // replace script blocks
    smarty_outputfilter_trimwhitespace_replace("@@@SMARTY:TRIM:SCRIPT@@@",$_script_blocks, $source);

    // replace pre blocks
    smarty_outputfilter_trimwhitespace_replace("@@@SMARTY:TRIM:PRE@@@",$_pre_blocks, $source);

    // replace textarea blocks
    smarty_outputfilter_trimwhitespace_replace("@@@SMARTY:TRIM:TEXTAREA@@@",$_textarea_blocks, $source);

    return $source;
}

function smarty_outputfilter_trimwhitespace_replace($search_str, $replace, &$subject) {
    $_len = strlen($search_str);
    $_pos = 0;
    for ($_i=0, $_count=count($replace); $_i<$_count; $_i++)
        if (($_pos=strpos($subject, $search_str, $_pos))!==false)
            $subject = substr($subject, 0, $_pos) . $replace[$_i] . substr($subject, $_pos+$_len);
        else
            break;

}

?>
