<?php
/**
 * SubPanelSearchForm.php
 * @author SalesAgility <support@salesagility.com>
 * Date: 28/01/14
 */

require_once('include/SearchForm/SearchForm2.php');

class SubPanelSearchForm extends SearchForm  {

    var $subPanel; // the instantiated bean of the subPanel

    function SubPanelSearchForm($seed, $module, $subPanel, $options = array()){
        $this->subPanel = $subPanel;
        parent::SearchForm($seed, $module, 'DetailView', $options);
    }

    function display(){
        $html = '';
        if($this->subPanel->subpanel_defs->isCollection() && isset($this->subPanel->subpanel_defs->base_collection_list)){
            $html .= $this->displayCollectionSelect($this->subPanel->subpanel_defs->base_collection_list);
        }
        echo $html;
    }

    function displayCollectionSelect($collection = array(), $value = array()){
        global $app_list_strings;

        $html = '';

        if(!empty($collection)){

            $select = array();
            foreach($collection as $name => $value_array){
                if(isset($app_list_strings['moduleList'][$value_array['module']])){
                    $select[$name] = $app_list_strings['moduleList'][$value_array['module']];
                }
            }

            $html .= '<select multiple>';
            $html .= get_select_options_with_id($select, $value);
            $html .= '</select>';
        }
        return $html;
    }

    function displaySavedSearchSelect(){
        return null;
    }

} 