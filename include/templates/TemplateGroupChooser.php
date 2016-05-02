<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


$js_loaded = false;
require_once("include/templates/Template.php");

class TemplateGroupChooser extends Template {
    var $args;
    var $js_loaded = false;
    var $display_hide_tabs = true;
    var $display_third_tabs = false;

    function __construct() {
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function TemplateGroupChooser(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function display() {
        global $app_strings, $mod_strings, $js_loaded;

        $left_size = (empty($this->args['left_size']) ? '10' : $this->args['left_size']);
        $right_size = (empty($this->args['right_size']) ? '10' : $this->args['right_size']);
        $third_size = (empty($this->args['third_size']) ? '10' : $this->args['third_size']);
        $max_left = (empty($this->args['max_left']) ? '' : $this->args['max_left']);
        $alt_tip_up = $app_strings['LBL_ALT_MOVE_COLUMN_UP'];
        $alt_tip_down = $app_strings['LBL_ALT_MOVE_COLUMN_DOWN'];
        $alt_tip_left = $app_strings['LBL_ALT_MOVE_COLUMN_LEFT'];
        $alt_tip_right = $app_strings['LBL_ALT_MOVE_COLUMN_RIGHT'];

        $str = '';
        if($js_loaded == false) {
//            $this->template_groups_chooser_js();
            $js_loaded = true;
        }
        if(!isset($this->args['display'])) {
            $table_style = "";
        }
        else {
            $table_style = "display: ".$this->args['display'];
        }

        $str .= "<div id=\"{$this->args['id']}\" style=\"{$table_style}\">";
        if(!empty($this->args['title'])) $str .= "<h4>{$this->args['title']}</h4>";
        $str .= <<<EOQ
        <table cellpadding="0" cellspacing="0" border="0">

        <tr>
            <td>&nbsp;</td>
            <td scope="row" id="chooser_{$this->args['left_name']}_text" align="center"><nobr>{$this->args['left_label']}</nobr></td>
EOQ;

        if($this->display_hide_tabs == true) {
           $str .= <<<EOQ
            <td>&nbsp;</td>
            <td scope="row" id="chooser_{$this->args['right_name']}" align="center"><nobr>{$this->args['right_label']}</nobr></td>
EOQ;
        }

        if($this->display_third_tabs == true) {
           $str .= <<<EOQ
            <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td scope="row" id="chooser_{$this->args['third_name']}" align="center"><nobr>{$this->args['third_label']}</nobr></td>
EOQ;
        }

        $str .= '<td>&nbsp;</td></tr><tr><td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">';
        if(!isset($this->args['disable'])) {
            $str .= "<a id='chooser_{$this->args['left_name']}_up_arrow' onclick=\"return SUGAR.tabChooser.up('{$this->args['left_name']}','{$this->args['left_name']}','{$this->args['right_name']}');\">" .  SugarThemeRegistry::current()->getImage('uparrow_big','border="0" style="margin-bottom: 1px;"',null,null,'.gif',$alt_tip_up) . "</a><br>
                     <a id='chooser_{$this->args['right_name']}_down_arrow' onclick=\"return SUGAR.tabChooser.down('{$this->args['left_name']}','{$this->args['left_name']}','{$this->args['right_name']}');\">" . SugarThemeRegistry::current()->getImage('downarrow_big','border="0" style="margin-top: 1px;"',null,null,'.gif',$alt_tip_down) . "</a>";
        }

        $str .= <<<EOQ
                </td>
                <td align="center">
                    <table border="0" cellspacing=0 cellpadding="0" align="center">
                        <tr>
                            <td id="{$this->args['left_name']}_td" align="center">
                            <select id="{$this->args['left_name']}" name="{$this->args['left_name']}[]" size=
EOQ;
        $str .=  '"' . (empty($this->args['left_size']) ? '10' : $this->args['left_size']) . '" multiple="multiple" ' . (isset($this->args['disable']) ?  "DISABLED" : '') . 'style="width: 150px;">';

        foreach($this->args['values_array'][0] as $key=>$value) {
            $str .= "<option value='{$key}'>{$value}</option>";
        }
        $str .= "</select></td>
            </tr>
            </table>
            </td>";
        if ($this->display_hide_tabs == true) {
            $str .= '<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">';
            if(!isset($this->args['disable'])) {
                $str .= "<a id='chooser_{$this->args['left_name']}_left_arrow' onclick=\"return SUGAR.tabChooser.right_to_left('{$this->args['left_name']}','{$this->args['right_name']}', '{$left_size}', '{$right_size}', '{$max_left}');\">" . SugarThemeRegistry::current()->getImage('leftarrow_big','border="0" style="margin-right: 1px;"',null,null,'.gif',$alt_tip_left) . "</a><a id='chooser_{$this->args['left_name']}_left_to_right' onclick=\"return SUGAR.tabChooser.left_to_right('{$this->args['left_name']}','{$this->args['right_name']}', '{$left_size}', '{$right_size}');\">" . SugarThemeRegistry::current()->getImage('rightarrow_big','border="0" style="margin-left: 1px;"',null,null,'.gif',$alt_tip_right) . "</a>";
            }
            $str .= "</td>
                <td id=\"{$this->args['right_name']}_td\" align=\"center\">
                <select id=\"{$this->args['right_name']}\" name=\"{$this->args['right_name']}[]\" size=\"" . (empty($this->args['right_size']) ? '10' : $this->args['right_size']) . "\" multiple=\"multiple\" " . (isset($this->args['disable']) ? "DISABLED" : '') . 'style="width: 150px;">';
            foreach($this->args['values_array'][1] as $key=>$value) {
                $str .= "<option value=\"{$key}\">{$value}</option>";
            }
            $str .= "</select></td><td valign=\"top\" style=\"padding-right: 2px; padding-left: 2px;\" align=\"center\">"
                    . "<script>var object_refs = new Object();object_refs['{$this->args['right_name']}'] = document.getElementById('{$this->args['right_name']}');</script>";
         }

         if ($this->display_third_tabs == true) {
            $str .= '<td valign="top" style="padding-right: 2px; padding-left: 2px;" align="center">';
            if(!isset($this->args['disable'])) {
                $str .= "<a id='chooser_{$this->args['right_name']}_right_arrow' onclick=\"return SUGAR.tabChooser.right_to_left('{$this->args['right_name']}','{$this->args['third_name']}', '{$right_size}', '{$third_size}');\">" . SugarThemeRegistry::current()->getImage('leftarrow_big','border="0" style="margin-right: 1px;"',null,null,'.gif',$alt_tip_left) . "</a><a id='chooser_{$this->args['right_name']}_left_to_right' onclick=\"return SUGAR.tabChooser.left_to_right('{$this->args['right_name']}','{$this->args['third_name']}', '{$right_size}', '{$third_size}');\">" . SugarThemeRegistry::current()->getImage('rightarrow_big','border="0" style="margin-left: 1px;"',null,null,'.gif',$alt_tip_right) . "</a>";
            }
            $str .= "</td>
                <td id=\"{$this->args['third_name']}_td\" align=\"center\">
                <select id=\"{$this->args['third_name']}\" name=\"{$this->args['third_name']}[]\" size=\"" . (empty($this->args['third_size']) ? '10' : $this->args['third_size']) . "\" multiple=\"multiple\" " . (isset($this->args['disable']) ? "DISABLED" : '') . 'style="width: 150px;">';
            foreach($this->args['values_array'][2] as $key=>$value) {
                $str .= "<option value=\"{$key}\">{$value}</option>";
            }
            $str .= "</select>
                <script>
                    object_refs['{$this->args['third_name']}'] = document.getElementById('{$this->args['third_name']}');
                </script>
                <td valign=\"top\" style=\"padding-right: 2px; padding-left: 2px;\" align=\"center\">
                </td>";
         }
         $str .= "<script>
                object_refs['{$this->args['left_name']}'] = document.getElementById('{$this->args['left_name']}');
                </script></tr>
            </table></div>";


        return $str;
}



    /*
     * All Moved to sugar_3.js in class tabChooser;
     * Please follow style that Dashlet configuration is done.
     */
    function template_groups_chooser_js() {
        //return '<script>var object_refs = new Object();</script>';
    }

}

?>
