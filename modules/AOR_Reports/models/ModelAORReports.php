<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 10/02/17
 * Time: 09:12
 */

namespace modules\AOR_Reports\models;
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rootPath.php';
include_once ROOTPATH.'/data/BeanFactory.php';

class ModelAORReports
{
    public function getReportParameters($bean){
        if(!$bean->id){
            return array();
        }
        $conditions = $bean->get_linked_beans('aor_conditions','AOR_Conditions', 'condition_order');
        $parameters = array();
        foreach($conditions as $condition){
            if(!$condition->parameter){
                continue;
            }
            $condition->module_path = implode(":",unserialize(base64_decode($condition->module_path)));
            if($condition->value_type == 'Date'){
                $condition->value = unserialize(base64_decode($condition->value));
            }
            $condition_item = $condition->toArray();
            $display = $this->getViewDisplayForField($condition->module_path, $condition->field, $bean->report_module);
            $condition_item['module_path_display'] = $display['module'];
            $condition_item['field_label'] = $display['field'];
            if(!empty($bean->user_parameters[$condition->id])){
                $param = $bean->user_parameters[$condition->id];
                $condition_item['operator'] = $param['operator'];
                $condition_item['value_type'] = $param['type'];
                $condition_item['value'] = $param['value'];
            }
            if(isset($parameters[$condition_item['condition_order']])) {
                $parameters[] = $condition_item;
            }
            else {
                $parameters[$condition_item['condition_order']] = $condition_item;
            }
        }
        return $parameters;
    }


    /**
     * Returns the display labels for a module path and field.
     * @param $modulePath
     * @param $field
     * @return array
     */
    public function getViewDisplayForField($modulePath, $field, $reportModule)
    {
        global $app_list_strings;
        $modulePathDisplay = array();
        $currentBean = \BeanFactory::getBean($reportModule);
        $modulePathDisplay[] = $currentBean->module_name;
        if (is_array($modulePath)) {
            $split = $modulePath;
        } else {
            $split = explode(':', $modulePath);
        }
        if ($split && $split[0] == $currentBean->module_dir) {
            array_shift($split);
        }
        foreach ($split as $relName) {
            if (empty($relName)) {
                continue;
            }
            if (!empty($currentBean->field_name_map[$relName]['vname'])) {
                $moduleLabel = trim(translate($currentBean->field_name_map[$relName]['vname'], $currentBean->module_dir), ':');
            }
            $thisModule = getRelatedModule($currentBean->module_dir, $relName);
            $currentBean = \BeanFactory::getBean($thisModule);

            if (!empty($moduleLabel)) {
                $modulePathDisplay[] = $moduleLabel;
            } else {
                $modulePathDisplay[] = $currentBean->module_name;
            }
        }
        $fieldDisplay = $currentBean->field_name_map[$field]['vname'];
        $fieldDisplay = translate($fieldDisplay, $currentBean->module_dir);
        $fieldDisplay = trim($fieldDisplay, ':');
        foreach($modulePathDisplay as &$module) {
            $module = isset($app_list_strings['aor_moduleList'][$module]) ? $app_list_strings['aor_moduleList'][$module] : (
            isset($app_list_strings['moduleList'][$module]) ? $app_list_strings['moduleList'][$module] : $module
            );
        }
        return array('field' => $fieldDisplay, 'module' => str_replace(' ', '&nbsp;', implode(' : ', $modulePathDisplay)));
    }


    public function getConditionsAsParameters($report, $override = array())
    {
        if (empty($report)) {
            return array();
        }

        global $app_list_strings;
        $conditions = array();
        foreach ($report->get_linked_beans('aor_conditions', 'AOR_Conditions') as $key => $condition) {
            if (!$condition->parameter) {
                continue;
            }

            $path = unserialize(base64_decode($condition->module_path));
            $field_module = $report->report_module;
            if ($path[0] != $report->report_module) {
                foreach ($path as $rel) {
                    if (empty($rel)) {
                        continue;
                    }
                    $field_module = getRelatedModule($field_module, $rel);
                }
            }

            $additionalConditions = unserialize(base64_decode($condition->value));


            $value = isset($override[$condition->id]['value']) ? $override[$condition->id]['value'] : $value = $condition->value;


            $field = getModuleField($field_module, $condition->field, "parameter_value[$key]", 'EditView', $value);
            $disp = $this->getViewDisplayForField($path, $condition->field, $report->report_module);
            $conditions[] = array(
                'id' => $condition->id,
                'operator' => $condition->operator,
                'operator_display' => $app_list_strings['aor_operator_list'][$condition->operator],
                'value_type' => $condition->value_type,
                'value' => $value,
                'field_display' => $disp['field'],
                'module_display' => $disp['module'],
                'field' => $field,
                'additionalConditions' => $additionalConditions
            );
        }
        return $conditions;
    }



// From Edit



    public function getConditionLines($bean){
        if(!$bean->id){
            return array();
        }
        $sql = "SELECT id FROM aor_conditions WHERE aor_report_id = '".$bean->id."' AND deleted = 0 ORDER BY condition_order ASC";
        $result = $bean->db->query($sql);
        $conditions = array();
        while ($row = $bean->db->fetchByAssoc($result)) {
            $condition_name = new \AOR_Condition();
            $condition_name->retrieve($row['id']);
            if(!$condition_name->parenthesis) {
                $condition_name->module_path = implode(":", unserialize(base64_decode($condition_name->module_path)));
            }
            if($condition_name->value_type == 'Date'){
                $condition_name->value = unserialize(base64_decode($condition_name->value));
            }
            $condition_item = $condition_name->toArray();

            if(!$condition_name->parenthesis) {
                $display = $this->getEditDisplayForField($condition_name->module_path, $condition_name->field, $bean->report_module);
                if(isset($display['module'])){
                    $condition_item['module_path_display'] = $display['module'];
                }else{
                    $condition_item['module_path_display'] = '';
                }
                if(isset($display['field'])){
                    $condition_item['field_label'] = $display['field'];
                }else{
                    $condition_item['field_label'] = '';
                }

            }
            if(isset($conditions[$condition_item['condition_order']])) {
                $conditions[] = $condition_item;
            }
            else {
                $conditions[$condition_item['condition_order']] = $condition_item;
            }
        }
        return $conditions;
    }

    public function getFieldLines($bean){
        if(!$bean->id){
            return array();
        }
        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$bean->id."' AND deleted = 0 ORDER BY field_order ASC";
        $result = $bean->db->query($sql);

        $fields = array();
        while ($row = $bean->db->fetchByAssoc($result)) {
            $field_name = new \AOR_Field();
            $field_name->retrieve($row['id']);
            $field_name->module_path = implode(":",unserialize(base64_decode($field_name->module_path)));
            $arr = $field_name->toArray();

            $arr['field_type'] = $this->getEditDisplayForField($field_name->module_path, $field_name->field  , $bean->report_module);

            $display = $this->getEditDisplayForField($field_name->module_path, $field_name->field, $bean->report_module);

            if(isset($display['module'])){
                $arr['module_path_display'] = $display['module'];
            }else{
                $arr['module_path_display'] = '';
            }
            if(isset($display['field'])){
                $arr['field_label']  = $display['field'];
            }else{
                $arr['field_label']  = '';
            }
            $fields[] = $arr;
        }
        return $fields;
    }

    public function getChartLines($bean){
        $charts = array();
        if(!$bean->id){
            return array();
        }
        foreach($bean->get_linked_beans('aor_charts','AOR_Charts') as $chart){
            $charts[] = $chart->toArray();
        }
        return $charts;
    }


    public function getEditDisplayForField($modulePath, $field, $reportModule){
        $modulePathDisplay = array();
        $currentBean = \BeanFactory::getBean($reportModule);
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
            $thisModule = $this->getRelatedModule($currentBean->module_dir, $relName);
            $currentBean = \BeanFactory::getBean($thisModule);

            if(!empty($moduleLabel)){
                $modulePathDisplay[] = $moduleLabel;
            }else {
                $modulePathDisplay[] = $currentBean->module_name;
            }
        }
        $fieldDisplay = $currentBean->field_name_map[$field]['type'];
        return $fieldDisplay;
    }

    private function getRelatedModule($module, $rel_field){
        global $beanList;

        if($module == $rel_field){
            return $module;
        }

        $mod = new $beanList[$module]();

        if(isset($arr['module']) && $arr['module'] != '') {
            return $arr['module'];
        } else if($mod->load_relationship($rel_field)){
            return $mod->$rel_field->getRelatedModuleName();
        }

        return $module;

    }

}