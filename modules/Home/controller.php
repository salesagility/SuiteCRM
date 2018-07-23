<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

include_once("include/InlineEditing/InlineEditing.php");
require_once "data/BeanDuplicateCheckRules.php";

class HomeController extends SugarController{


    public function action_getEditFieldHTML(){

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']){

            $html = getEditFieldHTML($_REQUEST['current_module'], $_REQUEST['field'], $_REQUEST['field'] , 'EditView', $_REQUEST['id']);
            echo $html;
        }

    }

    public function action_saveHTMLField(){

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']){

            echo saveField($_REQUEST['field'], $_REQUEST['id'], $_REQUEST['current_module'], $_REQUEST['value'], $_REQUEST['view']);

        }

    }

    public function action_getDisplayValue(){

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module'] ){

            $bean = BeanFactory::getBean($_REQUEST['current_module'],$_REQUEST['id']);

            if(is_object($bean) && $bean->id != ""){
                echo getDisplayValue($bean, $_REQUEST['field'],"close");
            }else{
                echo "Could not find value.";
            }

        }

    }

    public function action_checkUniqueRules()
    {
        global $app_strings;
        $arules = json_decode(html_entity_decode($_REQUEST['rules']));
        if(isset($arules->rules) && !empty($arules->rules) && $_REQUEST['current_module']){
            if($_REQUEST['id']){
                $bean = BeanFactory::getBean($_REQUEST['current_module'],$_REQUEST['id']);
            } else {
                $bean = BeanFactory::getBean($_REQUEST['current_module']);
            }
            if (!$bean->has_duplicate_check){
                $return_json["iserror"] = true;
                $return_json["error"] = 
                array(
                    array(
                        "type" => "system",
                        "msg" => $app_strings["LBL_ERROR_UNIQUE_CHECK"],
                    ),
                );
            } else {
                $return_json["iserror"] = false;
                $return_json["error"] = array();
                foreach($arules as $rules ){
                    foreach($rules as $rule ){
                        $result = $bean->duplicate_check->checkForDuplicateCheckRule( $rule, $bean, $_REQUEST['current_module'] ); 
                        switch($result["return"]){
                            case "rulenotfound":
                                $return_json["iserror"] = true;
                                array_push( $return_json["error"], array(
                                                                       "type" => "system",
                                                                       "msg" => $app_strings["LBL_ERROR_UNIQUE_CHECK_NORULES"],
                                                                   ));
                                break;
                            case "missingfields":
                                $return_json["iserror"] = true;
                                array_push( $return_json["error"], array(
                                                                       "type" => "system",
                                                                       "msg" => $app_strings["LBL_ERROR_UNIQUE_CHECK_MISSING"],
                                                                   ));
                                break;
                            case "duplicated":
                                $return_json["iserror"] = true;
                                array_push( $return_json["error"], array(
                                                                       "type" => "field",
                                                                       "msg" => $result["msgError"],
                                                                       "field" => $rule->field,
                                                                   ));
                                break;
                        }
                    }
                }
            }
        } else {
            $return_json["iserror"] = false;
            $return_json["error"] = 
            array(
                "type" => "system",
                "msg" => $app_strings["LBL_ERROR_UNIQUE_CHECK_NORULES"],
            );
        }
        echo json_encode($return_json);
    }

    public function action_getValidationRules(){
        global $app_strings, $mod_strings;

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module'] ){

            $bean = BeanFactory::getBean($_REQUEST['current_module'],$_REQUEST['id']);

            if(is_object($bean) && $bean->id != ""){

                $fielddef = $bean->field_defs[$_REQUEST['field']];

                if (!isset($fielddef['required']) || !$fielddef['required']) {
                    $fielddef['required'] = false;
                }

                if ($fielddef['name'] == "email1" || (isset($fielddef['email2']) && $fielddef['email2'])) {
                    $fielddef['type'] = "email";
                    $fielddef['vname'] = "LBL_EMAIL_ADDRESSES";
                }

                if (isset($app_strings[$fielddef['vname']])) {
                    $fielddef['label'] = $app_strings[$fielddef['vname']];
                }else{
                    if (isset($mod_strings[$fielddef['vname']])) {$fielddef['label'] = $mod_strings[$fielddef['vname']];} else {
                        $GLOBALS['log']->warn("Unknown text label in a fielddef: {$fielddef['vname']}");
                        if(!isset($fielddef['label'])) {
                            $fielddef['label'] = null;
                        }
                    }
                }
                switch ($fielddef['type']){
                    case 'timeslot':
                        $validate_array = 
                        array( "rules" => 
                            array( 
                                array(
                                    'validation' => 'default',
                                    'type' => $fielddef['type'], 
                                    'required' => $fielddef['required'],
                                    'label' => $fielddef['label']
                                ),
                                array( 
                                    'validation' => 'composefield', 
                                    'type' => $fielddef['type'], 
                                    'required' => $fielddef['required'],
                                    'label' => $fielddef['label'],
                                    'field' => "val_".$fielddef['name']
                                ),
                                array( 
                                    'validation' => 'addtocomposefield', 
                                    'type' => $fielddef['type'], 
                                    'required' => true,
                                    'label' => $app_strings["LBL_HOURS"],
                                    'field' => $fielddef['name']."_hours",
                                    'parent' => "val_".$fielddef['name']
                                ),
                                array( 
                                    'validation' => 'addtocomposefield', 
                                    'type' => $fielddef['type'], 
                                    'required' => true,
                                    'label' => $app_strings["LBL_MINUTES"],
                                    'field' => $fielddef['name']."_minutes",
                                    'parent' => "val_".$fielddef['name']
                                ),
                            )
                        );
                        break;
                    default:
                        $validate_array =
                        array( "rules" =>
                            array(
                                array(
                                    'validation' => 'default',
                                    'type' => $fielddef['type'], 
                                    'required' => $fielddef['required'],
                                    'label' => $fielddef['label']
                                ),
                            )
                        );
                        break;
                }
                if (isset($fielddef['validation']['type'])){
                    switch ($fielddef['validation']['type']){
                        case 'callback':
                            $newRule = 
                            array(
                                'validation' => $fielddef['validation']['type'],
                                'type' => $fielddef['type'],
                                'required' => $fielddef['required'],
                                'function' => $fielddef['validation']['callback'],
                                'label' => $fielddef['label']
                            ); 
                            array_push( $validate_array['rules'], $newRule );
                            break;
                        default:
                            break;
                    }
                }
                if ($bean->has_duplicate_check) {
                    $rules = $bean->duplicate_check->isFieldOfDuplicateCheckRule($_REQUEST['field']);
                    foreach( $rules as $rule ){
                        $tmpRule = $rule->getRuleInformation();
                        $newRule = 
                        array(
                            'validation' => 'duplicate_check',
                            'name' => $tmpRule['nameRule'],
                            'fields' => $tmpRule['fields'],
                            'errorMessages' => $tmpRule['errorMessages'],
                            'label' => $fielddef['label']
                        ); 
                        array_push( $validate_array['rules'], $newRule );
                    }
                }
                if (isset($bean->formandvis['beep']) && ($bean->formandvis['beep'] === true || $bean->formandvis['beep']=="1")){
                    $beep = "true";
                } else {
                    $beep = "false";
                }
                $validate_array['formconfig'] = 
                    array( 
                        "hasformulas" => false, 
                        "view" => "InlineEditView", 
                        "getbean" => "false", 
                        "beep" => $beep,
                        "onloadform" => "true");
                $validate_array['formulas'] = array();
                $validate_array['visibility'] = array();
                $validate_array['panelvisibility'] = array();
                $validate_array['tabvisibility'] = array();

                foreach($bean->field_name_map as $field => $value)
                {
                    if (isset($value['calculated']) && ($value['calculated'] == 1 || $value['calculated'] == true))
                    {
                        if (isset($value['formula']['fielddeps']))
                        {
                            $fielddeps = implode( "','", $value['formula']['fielddeps']);
                            array_push($validate_array['formulas'], array( "name" => $value['name'], "fielddeps" => "['" . $fielddeps . "']" ));
                        }
                    }
                    if (isset($value['visibility']) && ($value['visibility'] == 1 || $value['visibility'] == true))
                    {
                        if (isset($value['visformula']['fielddeps']))
                        {
                            $fielddeps = implode( "','", $value['visformula']['fielddeps']);
                            array_push($validate_array['visibility'], array( "name" => $value['name'], "fielddeps" => "['" . $fielddeps . "']" ));
                        }
                    }
                    if (isset($validate_array['formulas']))
                    {
                        $validate_array['formconfig']['hasformulas'] = true;
                    }
                }
                foreach( $bean->visibility as $key => $object )
                {
                    if (!isset($object['objecttype'])){
                        continue;
                    }
                    switch($object['objecttype']){
                        case 'tab':
                            if (isset($object['fielddeps']))
                            {
                              $fielddeps = implode( "','", $object['fielddeps']);
                              array_push($validate_array['tabvisibility'], array( "name" => $key, "tab" => $object['tab'], "fielddeps" => "['" . $fielddeps . "']" ));
                            }
                            break;
                        case 'panel':
                        default:
                            if (isset($object['fielddeps']))
                            {
                              $fielddeps = implode( "','", $object['fielddeps']);
                              array_push($validate_array['panelvisibility'], array( "name" => $key, "fielddeps" => "['" . $fielddeps . "']" ));
                            }
                            break;
                    }
                }
                echo json_encode($validate_array);
            }
        }
    }
    
    public function action_getRelateFieldJS(){
        
        global $beanFiles, $beanList;
        
        $fieldlist = array();
        $view = "EditView";

        if (!isset($focus) || !($focus instanceof SugarBean)){
            require_once($beanFiles[$beanList[$_REQUEST['current_module']]]);
            $focus = new $beanList[$_REQUEST['current_module']];
        }

        // create the dropdowns for the parent type fields
        $vardefFields[$_REQUEST['field']] = $focus->field_defs[$_REQUEST['field']];

        require_once("include/TemplateHandler/TemplateHandler.php");
        $template_handler = new TemplateHandler();
        $quicksearch_js = $template_handler->createQuickSearchCode($vardefFields, $vardefFields, $view);
        $quicksearch_js = str_replace($_REQUEST['field'], $_REQUEST['field'] . '_display', $quicksearch_js);

        if($_REQUEST['field'] != "parent_name") {
            $quicksearch_js = str_replace($vardefFields[$_REQUEST['field']]['id_name'], $_REQUEST['field'], $quicksearch_js);
        }

        echo $quicksearch_js;

    }

    private function getModuleRelatedFormulaFields( $fielddef, $name )
    {
        $fields = array();
        foreach( $fielddef as $field ){
            if (isset($field['calculated']) && ($field['calculated'] == 1 || $field['calculated'] == 'true') && ( $field['name'] != $name)){
                if ( isset($field['formula']['fielddeps']) && in_array( $name, $field['formula']['fielddeps'] )){
                    array_push( $fields, $field['name'] );
                }
            }
        }
        return $fields;
    }

    private function getModuleRelatedVisibilityFields( $fielddef, $name )
    {
        $fields = array();
        foreach( $fielddef as $field ){
            if (isset($field['visibility']) && ($field['visibility'] == 1 || $field['visibility'] == 'true') && ( $field['name'] != $name)){
                if ( isset($field['visformula']['fielddeps']) && in_array( $name, $field['visformula']['fielddeps'] )){
                    array_push( $fields, $field['name'] );
                }
            }
        }
        return $fields;
    }

    private function getModuleFormulasInt( $fieldsret, $fielddef, $name, $type )
    {
        if (isset($fieldsret['formula'][$name])){
            return $fieldsret;
        }
        switch ($type){
            case 'calculated':
                if (isset($fielddef[$name]['calculated']) && ($fielddef[$name]['calculated'] == 1 || $fielddef[$name]['calculated'] == 'true')){
                    $fieldsret['formula'][$name] = $fielddef[$name];
                    $relateddeps = $this->getModuleRelatedFormulaFields( $fielddef, $name );
                    foreach( $relateddeps as $relatedfield ){
                        $fieldsret = $this->getModuleFormulasInt( $fieldsret, $fielddef, $relatedfield, $type );
                    }
                }
                break;
        }
        return $fieldsret;
    }
    
    private function getModuleVisibilityInt( $fieldsret, $fielddef, $name, $type )
    {
        if (isset($fieldsret['visibility'][$name])){
            return $fieldsret;
        }
        switch ($type){
            case 'visibility':
                if (isset($fielddef[$name]['visibility']) && ($fielddef[$name]['visibility'] == 1 || $fielddef[$name]['visibility'] == 'true')){
                    $fieldsret['visibility'][$name] = $fielddef[$name];
                    $relateddeps = $this->getModuleRelatedVisibilityFields( $fielddef, $name );
                    foreach( $relateddeps as $relatedfield ){
                        $fieldsret = $this->getModuleVisibilityInt( $fieldsret, $fielddef, $relatedfield, $type );
                    }
                }
                break;
        }
        return $fieldsret;
    }

    private function getPanelVisibility( $fieldsret, $visdef, $name )
    {
        if (isset($visdef[$name])){
            $fieldsret['panelvisibility'][$name] = $visdef[$name];
        }
        return $fieldsret;
    }
    
    private function getTabVisibility( $fieldsret, $visdef, $name )
    {
        if (isset($visdef[$name])){
            $fieldsret['tabvisibility'][$name] = $visdef[$name];
        }
        return $fieldsret;
    }
    
    private function isNecessaryLoadBean( $fielddeps, $inlinetd, $event )
    {
        $fields = array();
        foreach( $fielddeps as $field => $val ){
            if (is_null($val) || $val == '__$NULL$__' || ($inlinetd && $field != $event['name'])){
                array_push( $fields, $field );
            }
        }
        return $fields;
    }
    
    public function getModuleFormulas( $module, $fields, $panels, $tabs, $id = '', $getbean = false )
    {
        global $beanFiles, $beanList;

        require_once($beanFiles[$beanList[$module]]);

        if ($getbean == true && !empty( $id )){
            $focus = BeanFactory::getBean( $module, $id );
        } else {
            $focus = new $beanList[$module];
        }
        $fieldsret = 
            array( 
                "formula" => array(), 
                "visibility" => array(),
                "panelvisibility" => array(),
                "tabvisibility" => array(),
                "bean" => 
                    array( 
                        "isset" => false, 
                        "fetchbean" => array(),
                    )
            );
        if (is_object($focus)){
            $fielddef = $focus->field_defs;
            $visdef = $focus->visibility;
            if ( !empty( $focus->id )){
                $fieldsret["bean"] = 
                    array( 
                        "isset" => true,
                        "fetchbean" => $focus,
                    );
            }
            foreach( $fields as $field => $val ){
                $fieldsret = $this->getModuleFormulasInt( $fieldsret, $fielddef, $field, "calculated" );
                $fieldsret = $this->getModuleVisibilityInt( $fieldsret, $fielddef, $field, "visibility" );
            }
            foreach( $panels as $panel => $val ){
                $fieldsret = $this->getPanelVisibility( $fieldsret, $visdef, $panel );
            }
            foreach( $tabs as $tab => $val ){
                $fieldsret = $this->getTabVisibility( $fieldsret, $visdef, $tab );
            }
        }
        return $fieldsret;
    }

    public function action_getFormula()
    {
        if (!isset($_REQUEST['panels'])){
            $_REQUEST['panels'] = array();
        }
        if (!isset($_REQUEST['tabs'])){
            $_REQUEST['tabs'] = array();
        }
        if (!isset($_REQUEST['fieldsdeps'])){
            $_REQUEST['fieldsdeps'] = array();
        }
        if (!isset($_REQUEST['fields'])){
            $_REQUEST['fields'] = array();
        }
        $getbean = ($_REQUEST['getbean'] == 'true' || $_REQUEST['inlinetd'] == 'true' );
        $nullfields = $this->isNecessaryLoadBean( $_REQUEST['fieldsdeps'], $_REQUEST['inlinetd'] == 'true' , $_REQUEST['event'] );
        if (!empty($nullfields)){
            $getbean = true;
        }
        $fields = $this->getModuleFormulas( $_REQUEST['current_module'], $_REQUEST['fields'], $_REQUEST['panels'], $_REQUEST['tabs'], $_REQUEST['id'], $getbean );
        if ($fields['bean']['isset'] == 1 && isset($fields['bean']['fetchbean'])){
            foreach( $nullfields as $nullfield ){
                $_REQUEST['fieldsdeps'][$nullfield] = $fields['bean']['fetchbean']->$nullfield;
            }
        }
        if ($_REQUEST['inlinetd'] == 'true'){
            if ($_REQUEST['event']['type'] == 'change'){
                $_REQUEST['fieldsdeps'][$_REQUEST['event']['name']] = $_REQUEST['event']['value'];
            }
        }

        $ret = array( "formulas" => array(), "visibility" => array(), "panelvisibility" => array(), "tabvisibility" => array());

        foreach($fields['formula'] as $key => $field){
            switch($field['formula']['type']){
                case 'function':
                    require_once( $field['formula']['function']['include'] );
                    $value = $field['formula']['function']['name']( $fields["bean"], $_REQUEST );
                    $_REQUEST['fieldsdeps'][$key] = $value;
                    $field = array( "name" => $key, "value" => $value );
                    array_push( $ret['formulas'], $field );
                    break;
            }
        }

        foreach($fields['visibility'] as $key => $field){
            switch($field['visformula']['type']){
                case 'function':
                    require_once( $field['visformula']['function']['include'] );
                    $value = $field['visformula']['function']['name']( $fields["bean"], $_REQUEST );
                    $field = array( "name" => $key, "value" => $value, "required" => $field['required'] );
                    array_push( $ret['visibility'], $field );
                    break;
            }
        }

        foreach($fields['panelvisibility'] as $key => $object){
            switch($object['type']){
                case 'function':
                    require_once( $object['function']['include'] );
                    $value = $object['function']['name']( $fields["bean"], $_REQUEST );
                    $field = array( "name" => $key, "value" => $value );
                    array_push( $ret['panelvisibility'], $field );
                    break;
            }
        }

        foreach($fields['tabvisibility'] as $key => $object){
            switch($object['type']){
                case 'function':
                    require_once( $object['function']['include'] );
                    $value = $object['function']['name']( $fields["bean"], $_REQUEST );
                    $focus = '-1';
                    if ($value){
                        if (isset($object['focustabonvisible'])){
                            $focus = $object['focustabonvisible'];
                        }
                    } else {
                        if (isset($object['focustabonhidden'])){
                            $focus = $object['focustabonhidden'];
                        }
                    }
                    $field = array( "name" => $key, "value" => $value, "tab" => $object['tab'], "focustab" => $focus );
                    array_push( $ret['tabvisibility'], $field );
                    break;
            }
        }
        echo json_encode( $ret );
    }

}
