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
        $this->tpl = 'SubpanelSearchFormGeneric.tpl';
        echo parent::display(false);
        /*$html = '';

        $html .= "<tr>";
        $html .= "<td aligh='left'>";

        if($this->subPanel->subpanel_defs->isCollection() && isset($this->subPanel->subpanel_defs->base_collection_list)){
            $html .= $this->displayCollectionSelect($this->subPanel->subpanel_defs->base_collection_list);
        }
        $html .= "</td>";
        $html .= "<td aligh='right'><input id='search_form_submit' class='button' type='submit' value='Search' name='button' onclick='javascript:showSubPanel(\"history\",\"/SuiteCRM/index.php?module=Accounts&action=DetailView&record=108e60ee-816e-f861-4772-5271284d598d&ajax_load=1&loadLanguageJS=1&Accounts_history_CELL_ORDER_BY=&sort_order=desc&to_pdf=true&action=SubPanelViewer&subpanel=history&layout_def_key=Accounts\",true);return false;' title='Search' tabindex='2'></td></tr>";

        echo $html;*/
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