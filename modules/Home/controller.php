<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 13/03/15
 * Time: 14:44
 */

include_once("include/InlineEditing/InlineEditing.php");

class HomeController extends SugarController{


    public function action_getEditFieldHTML(){

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']){

            echo getEditFieldHTML($_REQUEST['current_module'], $_REQUEST['field'], $_REQUEST['field'] , 'EditView', $_REQUEST['id']);

        }

    }

    public function action_saveHTMLField(){

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module'] && $_REQUEST['value']){

            echo saveField($_REQUEST['field'], $_REQUEST['id'], $_REQUEST['current_module'], $_REQUEST['value']);

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

    public function action_getValidationRules(){
        global $app_strings, $mod_strings;

        if($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module'] ){

            $bean = BeanFactory::getBean($_REQUEST['current_module'],$_REQUEST['id']);

            if(is_object($bean) && $bean->id != ""){

                $fielddef = $bean->field_defs[$_REQUEST['field']];

                if(!$fielddef['required']){
                    $fielddef['required'] = false;
                }

                if($fielddef['name'] == "email1" || $fielddef['email2']){
                    $fielddef['type'] = "email";
                    $fielddef['vname'] = "LBL_EMAIL_ADDRESSES";
                }

                if($app_strings[$fielddef['vname']]){
                    $fielddef['label'] = $app_strings[$fielddef['vname']];
                }else{
                    $fielddef['label'] = $mod_strings[$fielddef['vname']];
                }

                $validate_array = array('type' => $fielddef['type'], 'required' => $fielddef['required'],'label' => $fielddef['label']);

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
        $quicksearch_js = str_replace($fieldlist[$_REQUEST['field']]['id_name'], $_REQUEST['field'], $quicksearch_js);

        echo $quicksearch_js;

    }

}