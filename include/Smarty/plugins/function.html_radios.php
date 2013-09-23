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

r27851 - 2007-10-10 09:19:04 -0700 (Wed, 10 Oct 2007) - clee - Applied changes to radio enum field to add separator value and also blank label.

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_radios} function plugin
 *
 * File:       function.html_radios.php<br>
 * Type:       function<br>
 * Name:       html_radios<br>
 * Date:       24.Feb.2003<br>
 * Purpose:    Prints out a list of radio input types<br>
 * Input:<br>
 *           - name       (optional) - string default "radio"
 *           - values     (required) - array
 *           - options    (optional) - associative array
 *           - checked    (optional) - array default not set
 *           - separator  (optional) - ie <br> or &nbsp;
 *           - output     (optional) - the output next to each radio button
 *           - assign     (optional) - assign the output as an array to this variable
 * Examples:
 * <pre>
 * {html_radios values=$ids output=$names}
 * {html_radios values=$ids name='box' separator='<br>' output=$names}
 * {html_radios values=$ids checked=$checked separator='<br>' output=$names}
 * </pre>
 * @link http://smarty.php.net/manual/en/language.function.html.radios.php {html_radios}
 *      (Smarty online manual)
 * @author     Christopher Kvarme <christopher.kvarme@flashjab.com>
 * @author credits to Monte Ohrt <monte at ohrt dot com>
 * @version    1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_function_html_radios($params, &$smarty)
{

    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');
   
    $name = 'radio';
    $values = null;
    $options = null;
    $selected = null;
    $separator = '';
    $labels = true;
    $label_ids = false;
    $output = null;
    $extra = '';
    
    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'name':
            case 'separator':
                $$_key = (string)$_val;
                break;

            case 'checked':
            case 'selected':
                if(is_array($_val)) {
                    $smarty->trigger_error('html_radios: the "' . $_key . '" attribute cannot be an array', E_USER_WARNING);
                } else {
                    $selected = (string)$_val;
                }
                break;

            case 'labels':
            case 'label_ids':
                $$_key = (bool)$_val;
                break;

            case 'options':
                $$_key = (array)$_val;
                break;

            case 'values':
            case 'output':
                $$_key = array_values((array)$_val);
                break;

            case 'radios':
                $smarty->trigger_error('html_radios: the use of the "radios" attribute is deprecated, use "options" instead', E_USER_WARNING);
                $options = (array)$_val;
                break;

            case 'assign':
                break;

            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("html_radios: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    if (!isset($options) && !isset($values))
        return ''; /* raise error here? */

    $_html_result = array();

    if (isset($options)) {

        foreach ($options as $_key=>$_val)
            $_html_result[] = smarty_function_html_radios_output($name, $_key, $_val, $selected, $extra, $separator, $labels, $label_ids);

    } else {

        foreach ($values as $_i=>$_key) {
            $_val = isset($output[$_i]) ? $output[$_i] : '';
            $_html_result[] = smarty_function_html_radios_output($name, $_key, $_val, $selected, $extra, $separator, $labels, $label_ids);
        }

    }

    if(!empty($params['assign'])) {
        $smarty->assign($params['assign'], $_html_result);
    } else {
        return implode("\n",$_html_result);
    }

}

function smarty_function_html_radios_output($name, $value, $output, $selected, $extra, $separator, $labels, $label_ids) {
    
    $_output = '';
    if ($labels) {
      if($label_ids) {
          $_id = smarty_function_escape_special_chars(preg_replace('![^\w\-\.]!', '_', $name . '_' . $value));
          $_output .= '<label for="' . $_id . '">';
      } else {
          $_output .= '<label>';           
      }
   }
   $_output .= '<input type="radio" name="'
        . smarty_function_escape_special_chars($name) . '" value="'
        . smarty_function_escape_special_chars($value) . '"';

   if ($labels && $label_ids) $_output .= ' id="' . $_id . '"';

    if ((string)$value==$selected) {
        $_output .= ' checked="checked"';
    }
    
    $_output .= $extra . ' />' . ($output == '' ? $GLOBALS['app_strings']['LBL_LINK_NONE'] : $output);
    
    if ($labels) $_output .= '</label>';
    $_output .=  $separator;

    return $_output;
}

?>
