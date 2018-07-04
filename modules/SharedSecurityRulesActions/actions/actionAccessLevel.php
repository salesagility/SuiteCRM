<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */


require_once('modules/AOW_Actions/actions/actionBase.php');
class actionAccessLevel extends actionBase {

    function __construct($id = ''){
        parent::__construct($id);
    }

    function loadJS(){
        return array('modules/SharedSecurityRulesActions/actions/actionAccessLevel.js');
    }

    function edit_display($line,SugarBean $bean = null, $params = array()){
        global $app_list_strings;

        if(!in_array($bean->module_dir,getEmailableModules())) unset($app_list_strings['shared_email_type_list']['Record Email']);
        $targetOptions = getRelatedEmailableFields($bean->module_dir);
        if(empty($targetOptions)) unset($app_list_strings['shared_email_type_list']['Related Field']);

        $html = '<input type="hidden" name="aow_email_type_list" id="aow_email_type_list" value="'.get_select_options_with_id($app_list_strings['shared_email_type_list'], '').'">
				  <input type="hidden" name="aow_email_to_list" id="aow_email_to_list" value="'.get_select_options_with_id($app_list_strings['aow_email_to_list'], '').'">
				  <input type="hidden" name="sharedGroupRule" id="sharedGroupRule" value="'.get_select_options_with_id($app_list_strings['sharedGroupRule'], '').'">';

        $checked = '';
        if(isset($params['individual_email']) && $params['individual_email']) $checked = 'CHECKED';

        $html .= "<table border='0' cellpadding='0' cellspacing='0' width='100%' data-workflow-action='setRule'>";
        $html .= "<tr>";
        $html .= '<td id="name_label" scope="row" valign="top"><label>' . translate("LBL_OPTIONS",
                "SharedSecurityRulesActions") . ':<span class="required">*</span></label></td>';
        $html .= '<td valign="top" scope="row">';

        $html .='<button type="button" onclick="add_emailLine('.$line.')"><img src="'.SugarThemeRegistry::current()->getImageURL('id-ff-add.png').'"></button>';
        $html .= '<table id="emailLine'.$line.'_table" width="100%" class="email-line"></table>';
        $html .= '</td>';
        $html .= "</tr>";
        $html .= "</table>";

        $html .= "<script id ='aow_script".$line."'>";

        if(isset($params['email_target_type'])){
            foreach($params['email_target_type'] as $key => $field){
                if(is_array($params['email'][$key]))$params['email'][$key] = json_encode($params['email'][$key]);
                $html .= "load_emailline('".$line."','".$params['accesslevel'][$key]."','"
                         .$params['email_target_type'][$key]."','".$params['email'][$key]."');";
            }
        }
        $html .= "</script>";

        return $html;

    }
}