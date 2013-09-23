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



require_once('modules/AOW_Actions/actions/actionCreateRecord.php');
class actionModifyRecord extends actionCreateRecord {

    function actionModifyRecord($id = ''){
        parent::actionCreateRecord($id);
    }

    function loadJS(){
        return parent::loadJS();
    }

    function edit_display($line,SugarBean $bean = null, $params = array()){
        global $app_list_strings;

        $html = "<input type='hidden' name='aow_actions_param[".$line."][record_type]' id='aow_actions_param_record_type".$line."' value='' />";
        $html .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
        $html .= "<tr>";
        $html .= '<td colspan="4" scope="row"><table id="crLine'.$line.'_table" width="100%"></table></td>';
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= '<td colspan="4" scope="row"><input type="button" tabindex="116" class="button" value="'.translate("LBL_ADD_FIELD","AOW_Actions").'" id="addcrline'.$line.'" onclick="add_crLine('.$line.')" /></td>';
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= '<td colspan="4" scope="row"><table id="crRelLine'.$line.'_table" width="100%"></table></td>';
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= '<td colspan="4" scope="row"><input type="button" tabindex="116" class="button" value="'.translate("LBL_ADD_RELATIONSHIP","AOW_Actions").'" id="addcrrelline'.$line.'" onclick="add_crRelLine('.$line.')" /></td>';
        $html .= "</tr>";


            require_once("modules/AOW_WorkFlow/aow_utils.php");
        $html .= <<<EOS
        <script id ='aow_script$line'>
            function updateFlowModule(){
                var mod = document.getElementById('flow_module').value;
                document.getElementById('aow_actions_param_record_type$line').value = mod;
                cr_module[$line] = mod;
                show_crModuleFields($line);
            }
            document.getElementById('flow_module').addEventListener("change", updateFlowModule, false);
            updateFlowModule();
EOS;
        require_once("modules/AOW_WorkFlow/aow_utils.php");

        $html .= "cr_fields[".$line."] = \"".trim(preg_replace('/\s+/', ' ', getModuleFields($bean->module_name)))."\";";
        $html .= "cr_relationships[".$line."] = \"".trim(preg_replace('/\s+/', ' ', getModuleRelationships($params['record_type'])))."\";";
        if($params && array_key_exists('field',$params)){
            foreach($params['field'] as $key => $field){
                if(is_array($params['value'][$key]))$params['value'][$key] = json_encode($params['value'][$key]);

                $html .= "load_crline('".$line."','".$field."','".$params['value'][$key]."','".$params['value_type'][$key]."');";
            }
        }
        if(isset($params['rel'])){
            foreach($params['rel'] as $key => $field){
                if(is_array($params['rel_value'][$key]))$params['rel_value'][$key] = json_encode($params['rel_value'][$key]);

                $html .= "load_crrelline('".$line."','".$field."','".$params['rel_value'][$key]."','".$params['rel_value_type'][$key]."');";
            }
        }
        $html .= "</script>";
        return $html;
    }

    function run_action(SugarBean $bean, $params = array()){

        $this->set_record($bean, $bean, $params);
        $this->set_relationships($bean, $bean, $params);

        return true;
    }


}