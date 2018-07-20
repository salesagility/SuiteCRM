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


require_once("modules/AOW_WorkFlow/aow_utils.php");

class SharedSecurityRulesController extends SugarController {

    public function action_fielddefs(){
        $bean = BeanFactory::getBean($_REQUEST['moduletype']);
        $matrix = new SharedSecurityRules();
        $fields = $matrix->getFieldDefs($bean->field_defs, $_REQUEST['moduletype']);
        asort($fields);
        echo get_select_options_with_id($fields, "");
        die();
    }


    protected function action_getAction(){
        global $beanList, $beanFiles;

        $action_name = 'action'.$_REQUEST['aow_action'];
        $line = $_REQUEST['line'];

        if($_REQUEST['aow_module'] == '' || !isset($beanList[$_REQUEST['aow_module']])){
            echo '';
            die;
        }

        if(file_exists('custom/modules/SharedSecurityRulesActions/actions/'.$action_name.'.php')){

            require_once('custom/modules/SharedSecurityRulesActions/actions/'.$action_name.'.php');

        } else if(file_exists('modules/SharedSecurityRulesActions/actions/'.$action_name.'.php')){

            require_once('modules/SharedSecurityRulesActions/actions/'.$action_name.'.php');

        } else {
            echo '';
            die;
        }

        $custom_action_name = "custom" . $action_name;
        if(class_exists($custom_action_name)){
            $action_name = $custom_action_name;
        }

        $id = '';
        $params = array();
        if(isset($_REQUEST['id'])){
            require_once('modules/AOW_Actions/AOW_Action.php');
            $aow_action = new SharedSecurityRulesActions();
            $aow_action->retrieve($_REQUEST['id']);
            $id = $aow_action->id;
            $params = unserialize(base64_decode($aow_action->parameters));
        }

        $action = new $action_name($id);

        require_once($beanFiles[$beanList[$_REQUEST['aow_module']]]);
        $bean = new $beanList[$_REQUEST['aow_module']];
        echo $action->edit_display($line,$bean,$params);
        die;
    }

    protected function action_getModuleFieldType()
    {
        if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
            $rel_module = getRelatedModule($_REQUEST['aow_module'],$_REQUEST['rel_field']);
        } else {
            $rel_module = $_REQUEST['aow_module'];
        }
        $module = $_REQUEST['aow_module'];
        $fieldname = $_REQUEST['aow_fieldname'];
        $aow_field = $_REQUEST['aow_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aow_value'])) $value = $_REQUEST['aow_value'];
        else $value = '';

        switch($_REQUEST['aow_type']) {
            case 'Field':
                if(isset($_REQUEST['alt_module']) && $_REQUEST['alt_module'] != '') $module = $_REQUEST['alt_module'];
                if($view == 'EditView'){
                    echo "<select type='text'  name='$aow_field' id='$aow_field ' title='' tabindex='116'>". getModuleFields($module, $view, $value, getValidFieldsTypes($module, $fieldname)) ."</select>";
                }else{
                    echo getModuleFields($module, $view, $value);
                }
                break;
            case 'Any_Change';
            case 'currentUser';
                echo '';
                break;
            case 'Date':
                echo getDateField($module, $aow_field, $view, $value, false);
                break;
            case 'Multi':
                echo getModuleField($rel_module,$fieldname, $aow_field, $view, $value,'multienum');
                break;
            case 'SecurityGroup':
                $module = 'Accounts';
                $fieldname = 'SecurityGroups';
            case 'Value':
            default:
                echo getModuleField($rel_module,$fieldname, $aow_field, $view, $value );
                break;
        }
        die;

    }


    protected function action_getFieldTypeOptions(){

        global $app_list_strings, $beanFiles, $beanList;

        if(isset($_REQUEST['rel_field']) &&  $_REQUEST['rel_field'] != ''){
            $module = getRelatedModule($_REQUEST['aow_module'],$_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aow_module'];
        }
        $fieldname = $_REQUEST['aow_fieldname'];
        $aow_field = $_REQUEST['aow_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';

        if(isset($_REQUEST['aow_value'])) $value = $_REQUEST['aow_value'];
        else $value = '';


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        // Usetting these as they are not required
        //unset($app_list_strings['aow_condition_type_list']['Field']);
        unset($app_list_strings['aow_condition_type_list']['Any_Change']);
        unset($app_list_strings['aow_condition_type_list']['SecurityGroup']);
        unset($app_list_strings['aow_condition_type_list']['Date']);
        unset($app_list_strings['aow_condition_type_list']['Multi']);


        switch($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array('Value','Field','Any_Change');
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array('Value','Field','Any_Change');
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array('Value','Field','Any_Change','Date');
                break;
            case 'enum':
            case 'dynamicenum':
            case 'multienum':
                $valid_opp = array('Value','Field','Any_Change', 'Multi');
                break;
            case 'relate':
            case 'id':
                $valid_opp = array('Value','Field','Any_Change', 'SecurityGroup', 'currentUser');
                break;
            default:
                $valid_opp = array('Value','Field','Any_Change');
                break;
        }

        if(!file_exists('modules/SecurityGroups/SecurityGroup.php')){
            unset($app_list_strings['aow_condition_type_list']['SecurityGroup']);
        }
        foreach($app_list_strings['aow_condition_type_list'] as $key => $keyValue){
            if(!in_array($key, $valid_opp)){
                unset($app_list_strings['aow_condition_type_list'][$key]);
            }
        }

        if($view == 'EditView'){
            echo "<select type='text'  name='$aow_field' id='$aow_field' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aow_condition_type_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aow_condition_type_list'][$value];
        }
        die;

    }

    protected function action_getModuleOperatorField()
    {

        global $app_list_strings, $beanFiles, $beanList;

        if (isset($_REQUEST['rel_field']) && $_REQUEST['rel_field'] != '') {
            $module = getRelatedModule($_REQUEST['aor_module'], $_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aor_module'];
        }
        $fieldname = $_REQUEST['aor_fieldname'];
        $aor_field = $_REQUEST['aor_newfieldname'];

        if (isset($_REQUEST['view'])) {
            $view = $_REQUEST['view'];
        } else {
            $view = 'EditView';
        }

        if (isset($_REQUEST['aor_value'])) {
            $value = $_REQUEST['aor_value'];
        } else {
            $value = '';
        }


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        switch ($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array(
                    'Equal_To',
                    'Not_Equal_To',
                    'Greater_Than',
                    'Less_Than',
                    'Greater_Than_or_Equal_To',
                    'Less_Than_or_Equal_To'
                );
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array(
                    'Equal_To',
                    'Not_Equal_To',
                    'Greater_Than',
                    'Less_Than',
                    'Greater_Than_or_Equal_To',
                    'Less_Than_or_Equal_To'
                );
                break;
            case 'date':
            case 'datetime':
            case 'datetimecombo':
                $valid_opp = array(
                    'Equal_To',
                    'Not_Equal_To',
                    'Greater_Than',
                    'Less_Than',
                    'Greater_Than_or_Equal_To',
                    'Less_Than_or_Equal_To'
                );
                break;
            case 'enum':
            case 'multienum':
                $valid_opp = array('Equal_To', 'Not_Equal_To');
                break;
            default:
                $valid_opp = array('Equal_To', 'Not_Equal_To', 'Contains','Not_Contains', 'Starts_With', 'Ends_With',);
                break;
        }

        foreach ($app_list_strings['aor_operator_list'] as $key => $keyValue) {
            if (!in_array($key, $valid_opp)) {
                unset($app_list_strings['aor_operator_list'][$key]);
            }
        }

        $onchange = "";
        if($_REQUEST['m'] != "aomr"){
            $onchange = "UpdatePreview(\"preview\");";
        }

        $app_list_strings['aor_operator_list'];
        if ($view == 'EditView') {
            echo "<select type='text' style='width:178px;' name='{$aor_field}' id='{$aor_field}' title='' 
            onchange='{$onchange}' tabindex='116'>"
                . get_select_options_with_id($app_list_strings['aor_operator_list'], $value) . "</select>";
        } else {
            echo $app_list_strings['aor_operator_list'][$value];
        }
        die;

    }

}
