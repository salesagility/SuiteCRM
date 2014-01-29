<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/SubPanel/SubPanel.php');

class CustomSubPanel extends SubPanel
{
    var $search_query='';

	function CustomSubPanel($module, $record_id, $subpanel_id, $subpanelDef, $layout_def_key='', $search_query = '', $collections = array() )
	{
        global $beanList, $beanFiles, $focus, $app_strings;

        $this->subpanel_defs=$subpanelDef;
        $this->subpanel_id = $subpanel_id;
        $this->parent_record_id = $record_id;
        $this->parent_module = $module;
        $this->layout_def_key = $layout_def_key;

        $this->serach_query = $search_query;

        $this->parent_bean = $focus;
        $result = $focus;

        if(empty($result))
        {
            $parent_bean_name = $beanList[$module];
            $parent_bean_file = $beanFiles[$parent_bean_name];
            require_once($parent_bean_file);
            $this->parent_bean = new $parent_bean_name();
            $this->parent_bean->retrieve($this->parent_record_id);
            $result = $this->parent_bean;
        }

        if($record_id!='fab4' && $result == null)
        {
            sugar_die($app_strings['ERROR_NO_RECORD']);
        }

        if (empty($subpanelDef)) {
            //load the subpanel by name.
            if (!class_exists('MyClass')) {
                require_once 'custom/include/SubPanel/SubPanelDefinitions.php' ;
            }
            $panelsdef=new CustomSubPanelDefinitions($result,$layout_def_key);
            $subpanelDef=$panelsdef->load_subpanel($subpanel_id, false, false, $search_query,$collections);
            $this->subpanel_defs=$subpanelDef;

        }

	}

    function getSearchForm()
    {
        require_once('custom/include/SubPanel/SubPanelSearchForm.php');

        $module = 'Meetings';

        $seed = new Meeting();

        $searchForm = new SubPanelSearchForm($seed, $module, $this);

        $searchMetaData = $searchForm->retrieveSearchDefs($module);

        $searchForm->setup($searchMetaData['searchdefs'], $searchMetaData['searchFields'], 'SearchFormGeneric.tpl', 'basic_search');

        $searchForm->display(false);


    }

}

?>