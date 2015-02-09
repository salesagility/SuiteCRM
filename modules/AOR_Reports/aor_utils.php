<?php
 /**
 * 
 * 
 * @package 
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
 * @author Salesagility Ltd <support@salesagility.com>
 */

/**
 * Returns the display labels for a module path and field.
 * @param $modulePath
 * @param $field
 * @return array
 */
function getDisplayForField($modulePath, $field, $reportModule){
    $modulePathDisplay = array();
    $currentBean = BeanFactory::getBean($reportModule);
    $modulePathDisplay[] = $currentBean->module_name;
    if(is_array($modulePath)) {
        $split = $modulePath;
    }else{
        $split = explode(':', $modulePath);
    }
    if ($split && $split[0] == $currentBean->module_dir) {
        array_shift($split);
    }
    foreach($split as $relName){
        if(empty($relName)){
            continue;
        }
        if(!empty($currentBean->field_name_map[$relName]['vname'])){
            $moduleLabel = trim(translate($currentBean->field_name_map[$relName]['vname'],$currentBean->module_dir),':');
        }
        $thisModule = getRelatedModule($currentBean->module_dir, $relName);
        $currentBean = BeanFactory::getBean($thisModule);

        if(!empty($moduleLabel)){
            $modulePathDisplay[] = $moduleLabel;
        }else {
            $modulePathDisplay[] = $currentBean->module_name;
        }
    }
    $fieldDisplay = $currentBean->field_name_map[$field]['vname'];
    $fieldDisplay = translate($fieldDisplay,$currentBean->module_dir);
    $fieldDisplay = trim($fieldDisplay,':');
    return array('field'=>$fieldDisplay,'module'=>implode(' : ',$modulePathDisplay));
}

function requestToUserParameters(){
    $params = array();
    foreach($_REQUEST['parameter_id'] as $key => $parameterId){
        $params[$parameterId] = array('id'=>$parameterId,
            'operator'=> $_REQUEST['parameter_operator'][$key],
            'type'=> $_REQUEST['parameter_type'][$key],
            'value'=> $_REQUEST['parameter_value'][$key],
        );
    }
    return $params;
}

function getConditionsAsParameters($report, $override = array()){
    if(empty($report)){
        return array();
    }

    global $app_list_strings;
    $conditions = array();
    foreach($report->get_linked_beans('aor_conditions','AOR_Conditions') as $condition){
        if(!$condition->parameter){
            continue;
        }

        $path = unserialize(base64_decode($condition->module_path));
        $field_module = $report->report_module;
        if($path[0] != $report->report_module){
            foreach($path as $rel){
                if(empty($rel)){
                    continue;
                }
                $field_module = getRelatedModule($field_module,$rel);
            }
        }

        $value = isset($override[$condition->id]['value']) ? $override[$condition->id]['value'] : $value = $condition->value;
        $field = getModuleField($field_module,$condition->field,'parameter_value[]', 'EditView', $value);
        $disp = getDisplayForField($path,$condition->field,$report->report_module);
        $conditions[] = array('id'=>$condition->id,
            'operator' => $condition->operator,
            'operator_display' => $app_list_strings['aor_operator_list'][$condition->operator],
            'value_type' => $condition->value_type,
            'value' => $value,
            'field_display' => $disp['field'],
            'module_display' => $disp['module'],
            'field' => $field);
    }
    return $conditions;
}