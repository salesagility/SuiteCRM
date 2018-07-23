<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
/**
 * Duplicate Check System
 * @package Duplicate Check System for SuiteCRM
 * @copyright Antoni Pàmies
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
 * @author Antoni Pàmies <toni@arboli.net>
 */


if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/utils.php';

class CheckDuplicateRule
{
    protected $bean;
    protected $nameRule;
    protected $fields;
    protected $errmsg;
    protected $ischecked;
    protected $retchecked;
    protected $module;
    protected $defs;
    protected $values;

    public function __construct($name,$fields,$errmsg,$defs)
    {
        $this->nameRule = $name;
        $this->errmsg = $errmsg;
        $this->ischecked = false;
        $this->isunique = false;
        $this->defs = $defs;
        foreach($fields as $field){
            if(isset($defs[$field]["id_name"])){
                $id_name = $defs[$field]["id_name"];
            } else {
                $id_name = "";
            }
            $this->fields[$field] = 
            array( 
                $defs[$field]["type"], 
                $id_name,
            );
        }
    }

    public function isFieldOfDuplicateCheckRule( $field )
    {
        if (isset($this->fields[$field])){
            return true;
        } else {
            return false;        
        }
    }
    
    public function checkForDuplicateCheckRule( $rule, $bean, $module )
    {
        $this->module = $module;
        if (!$this->ischecked){
            $this->ischecked = true;
            $i = 0;
            $retrievearray = array();
            foreach($rule->fields as $field){
                if ($bean->field_defs[$field]['type'] == 'relate'){
                    $realfield = $field;
                    $field=$bean->field_defs[$field]['id_name'];
                    if (!$rule->found[$i] && $bean->id){
                        $rule->values[$i] = 
                        array(
                            $bean->$realfield,
                            $bean->$field,
                        );
                    } else {
                        if (!$rule->found[$i] && !$bean->id){
                            $this->retchecked = "missingfields";
                            return array("return" => $this->retchecked);
                        }
                    }
                    $retrievearray[$field] = $rule->values[$i][1];
                } else { 
                    if (!$rule->found[$i] && $bean->id){
                        $rule->values[$i] = $bean->$field;
                    } else {
                        if (!$rule->found[$i] && !$bean->id){
                            $this->retchecked = "missingfields";
                            return array("return" => $this->retchecked);
                        }
                    }
                    $retrievearray[$field] = $rule->values[$i];
                }
                $i++;
            }
            $this->values = $rule->values;
            $beant = BeanFactory::getBean($module);
            $beant->retrieve_by_string_fields($retrievearray);
            if(!isset($beant->id) || ($bean->id == $beant->id)){
                $this->retchecked = "notduplicated";
                return array("return" => $this->retchecked);
            } else {
                $this->retchecked = "duplicated";
                return array("return" => $this->retchecked, "msgError" => $this->parseErrorMessage($this->errmsg[0]));
            }
        } else {
            if ($this->retchecked == "duplicated"){
                return array("return" => $this->retchecked, "msgError" => $this->parseErrorMessage($this->errmsg[0]));
            } else {
                return $this->retchecked;
            }
        }
    } 

    public function getValidateFunction( $form, $field )
    {
        return "addToCheckUnique('{$form}','{$this->nameRule}','{$field}'," . json_encode($this->fields) . ",". json_encode($this->errmsg) . ");";
    }

    public function getRuleInformation()
    {
        return array( "nameRule" => $this->nameRule, "fields" => json_encode($this->fields), "errorMessages" => json_encode($this->errmsg) );
    }

    protected function parseErrorMessage( $string )
    {
        global $app_list_strings, $app_strings;

        $i=0;
        $fieldsname = "";
        $fieldslabel = "";
        $fieldsvalue = "";
        $afieldslabel = array();
        $afieldsname = array();
        $afieldsvalue = array();
        $areplace = array();
        $atext = array();
        $string = translate($string,$this->module);
        foreach($this->fields as $field => $value){
            if($i>0){
                $fieldsname .= ", ";
                $fieldslabel .= ", ";
                $fieldsvalue .= ", ";
            }
            $afieldslabel[$i] = translate($this->defs[$field]["vname"],$this->module);
            switch($value[0]){
                case "relate":
                    $afieldsvalue[$i] = $this->values[$i][0];
                    array_push($areplace, "{%field.".$field.".id%}");
                    array_push($atext, $this->values[$i][1]);
                    break;
                case "enum":
                    $afieldsvalue[$i] = $app_list_strings[$this->defs[$field]["options"]][$this->values[$i]];
                    array_push($areplace, "{%field.".$field.".key%}");
                    array_push($atext, $this->values[$i]);
                    break;
                default:
                    $afieldsvalue[$i] = $this->values[$i];
                    break;
            }
            $fieldsname .= $field;
            $afieldsname[$i] = $field;
            $fieldslabel .= $afieldslabel[$i];
            $fieldsvalue .= $afieldsvalue[$i];
            array_push($areplace, "{%field.".$field.".label%}");
            array_push($atext, $afieldslabel[$i]);
            array_push($areplace, "{%field.".$field.".value%}");
            array_push($atext, $afieldsvalue[$i]);
            $i++;
        }
        array_push($areplace, "{%module%}");
        array_push($areplace, "{%fields.name%}");
        array_push($areplace, "{%fields.label%}");
        array_push($areplace, "{%fields.value%}");
        array_push($atext, $app_list_strings['moduleList'][$this->module]);
        array_push($atext, $fieldsname);
        array_push($atext, $fieldslabel);
        array_push($atext, $fieldsvalue);
        for( $j=0; $j<$i; $j++ ){
            array_push($areplace, "{%field.".$j.".label%}");
            array_push($areplace, "{%field.".$j.".name%}");
            array_push($areplace, "{%field.".$j.".value%}");
            array_push($atext, $afieldslabel[$j]);
            array_push($atext, $afieldsname[$j]);
            array_push($atext, $afieldsvalue[$j]);
        }
        return str_ireplace($areplace, $atext, $string);
    }
}

class BeanDuplicateCheckRules
{
    protected $rules = array();
    protected $field_defs;

    public function __construct($metadata,$defs)
    {
        $this->field_defs = $defs;
        $this->loadMetadata($metadata);
    }

    protected function loadMetadata($metadata)
    {
        if (!empty($metadata)) {
            foreach( $metadata as $key => $rule){
                if (!isset( $rule['errormessages'] )){
                    $rule['errormessages'] = array("A {%module%} already exists for this key: <b></i>{%fields.value%}</b></i>");
                }
                if (!class_exists($rule['name'])){
                    $ruleObj = new CheckDuplicateRule($rule['name'], $rule['fields'], $rule['errormessages'], $this->field_defs);
                } else {
                    $ruleObj = new $rule['name']($rule['name'], $rule['fields'], $rule['errormessages'], $this->field_defs);
                    if(!$ruleObj instanceof CheckDuplicateRule){
                        $GLOBALS['log']->fatal("Error {$rule['name']} is not an instance of CheckDuplicateRule. This rule was disabled.");
                        return false;
                    }
                }
                $this->rules[$rule['name']] = $ruleObj;
            }
        }
    }
   
    public function checkForDuplicateCheckRule( $rule, $bean, $module )
    {
        if (isset($this->rules[$rule->rulename])){
            return $this->rules[$rule->rulename]->checkForDuplicateCheckRule( $rule, $bean, $module );
        }
        return array("return" => "rulenotfound");
    }

    public function isFieldOfDuplicateCheckRule( $field )
    {
        $retRules = array();

        if (empty($this->rules)){
           return $retRules; 
        }
        foreach( $this->rules as $rule ){
            if ($rule->isFieldOfDuplicateCheckRule( $field )){
                array_push( $retRules, $rule );
            }
        }
        return $retRules;
    }
}
