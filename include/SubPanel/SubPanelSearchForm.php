<?php
/**
 * SubPanelSearchForm.php
 * @author SalesAgility <info@salesagility.com>
 * Date: 28/01/14
 */

require_once('include/SearchForm/SearchForm2.php');

class SubPanelSearchForm extends SearchForm  {

    var $subPanel; // the instantiated bean of the subPanel

    function SubPanelSearchForm($seed, $module, $subPanel, $options = array()){
        $this->subPanel = $subPanel;
        parent::SearchForm($seed, $module, 'DetailView', $options);
    }

    function display($header = false){
        /*//global $app_list_strings;
        if($this->subPanel->subpanel_defs->isCollection() && isset($this->subPanel->subpanel_defs->base_collection_list)){
            $GLOBALS['app_list_strings']['collection_temp_list'] = $this->getCollectionList($this->subPanel->subpanel_defs->base_collection_list);
        }*/
        $this->th->ss->assign('subpanel', $this->subPanel->subpanel_id);
        $this->parsedView = 'sps';
        return parent::display($header);
    }

    function getCollectionList($collection = array()){
        global $app_list_strings;

        $select = array();

        if(!empty($collection)){

            $select = array();
            foreach($collection as $name => $value_array){
                if(isset($app_list_strings['moduleList'][$value_array['module']])){
                    $select[$name] = $app_list_strings['moduleList'][$value_array['module']];
                }
            }
        }
        return $select;
    }

    function displaySavedSearchSelect(){
        return null;
    }

} 