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
 * Smarty {mailto} function plugin
 *
 * Type:     function<br>
 * Name:     mailto<br>
 * Date:     May 21, 2002
 * Purpose:  automate mailto address link creation, and optionally
 *           encode them.<br>
 * Input:<br>
 *         - address = e-mail address
 *         - text = (optional) text to display, default is address
 *         - encode = (optional) can be one of:
 *                * none : no encoding (default)
 *                * javascript : encode with javascript
 *                * javascript_charcode : encode with javascript charcode
 *                * hex : encode with hexidecimal (no javascript)
 *         - cc = (optional) address(es) to carbon copy
 *         - bcc = (optional) address(es) to blind carbon copy
 *         - subject = (optional) e-mail subject
 *         - newsgroups = (optional) newsgroup(s) to post to
 *         - followupto = (optional) address(es) to follow up to
 *         - extra = (optional) extra tags for the href link
 *
 * Examples:
 * <pre>
 * {mailto address="me@domain.com"}
 * {mailto address="me@domain.com" encode="javascript"}
 * {mailto address="me@domain.com" encode="hex"}
 * {mailto address="me@domain.com" subject="Hello to you!"}
 * {mailto address="me@domain.com" cc="you@domain.com,they@domain.com"}
 * {mailto address="me@domain.com" extra='class="mailto"'}
 * </pre>
 * @link http://smarty.php.net/manual/en/language.function.mailto.php {mailto}
 *          (Smarty online manual)
 * @version  1.2
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @author   credits to Jason Sweat (added cc, bcc and subject functionality)
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_mailto($params, &$smarty)
{
    $extra = '';

    if (empty($params['address'])) {
        $smarty->trigger_error("mailto: missing 'address' parameter");
        return;
    } else {
        $address = $params['address'];
    }

    $text = $address;

    // netscape and mozilla do not decode %40 (@) in BCC field (bug?)
    // so, don't encode it.
    $mail_parms = array();
    foreach ($params as $var=>$value) {
        switch ($var) {
            case 'cc':
            case 'bcc':
            case 'followupto':
                if (!empty($value))
                    $mail_parms[] = $var.'='.str_replace('%40','@',rawurlencode($value));
                break;
                
            case 'subject':
            case 'newsgroups':
                $mail_parms[] = $var.'='.rawurlencode($value);
                break;

            case 'extra':
            case 'text':
                $$var = $value;

            default:
        }
    }

    $mail_parm_vals = '';
    for ($i=0; $i<count($mail_parms); $i++) {
        $mail_parm_vals .= (0==$i) ? '?' : '&';
        $mail_parm_vals .= $mail_parms[$i];
    }
    $address .= $mail_parm_vals;

    $encode = (empty($params['encode'])) ? 'none' : $params['encode'];
    if (!in_array($encode,array('javascript','javascript_charcode','hex','none')) ) {
        $smarty->trigger_error("mailto: 'encode' parameter must be none, javascript or hex");
        return;
    }

    if ($encode == 'javascript' ) {
        $string = 'document.write(\'<a href="mailto:'.$address.'" '.$extra.'>'.$text.'</a>\');';

        $js_encode = '';
        for ($x=0; $x < strlen($string); $x++) {
            $js_encode .= '%' . bin2hex($string[$x]);
        }

        return '<script type="text/javascript">eval(unescape(\''.$js_encode.'\'))</script>';

    } elseif ($encode == 'javascript_charcode' ) {
        $string = '<a href="mailto:'.$address.'" '.$extra.'>'.$text.'</a>';

        for($x = 0, $y = strlen($string); $x < $y; $x++ ) {
            $ord[] = ord($string[$x]);   
        }

        $_ret = "<script type=\"text/javascript\" language=\"javascript\">\n";
        $_ret .= "<!--\n";
        $_ret .= "{document.write(String.fromCharCode(";
        $_ret .= implode(',',$ord);
        $_ret .= "))";
        $_ret .= "}\n";
        $_ret .= "//-->\n";
        $_ret .= "</script>\n";
        
        return $_ret;
        
        
    } elseif ($encode == 'hex') {

        preg_match('!^(.*)(\?.*)$!',$address,$match);
        if(!empty($match[2])) {
            $smarty->trigger_error("mailto: hex encoding does not work with extra attributes. Try javascript.");
            return;
        }
        $address_encode = '';
        for ($x=0; $x < strlen($address); $x++) {
            if(preg_match('!\w!',$address[$x])) {
                $address_encode .= '%' . bin2hex($address[$x]);
            } else {
                $address_encode .= $address[$x];
            }
        }
        $text_encode = '';
        for ($x=0; $x < strlen($text); $x++) {
            $text_encode .= '&#x' . bin2hex($text[$x]).';';
        }

        $mailto = "&#109;&#97;&#105;&#108;&#116;&#111;&#58;";
        return '<a href="'.$mailto.$address_encode.'" '.$extra.'>'.$text_encode.'</a>';

    } else {
        // no encoding
        return '<a href="mailto:'.$address.'" '.$extra.'>'.$text.'</a>';

    }

}

/* vim: set expandtab: */

?>
