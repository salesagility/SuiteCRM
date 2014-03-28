<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/SubPanel/SubPanel.php');

class CustomSubPanel extends SubPanel
{
    var $search_query='';
    var $collections = array();

	function CustomSubPanel($module, $record_id, $subpanel_id, $subpanelDef, $layout_def_key='', $collections = array() )
	{
        global $beanList, $beanFiles, $focus, $app_strings;

        $this->subpanel_defs=$subpanelDef;
        $this->subpanel_id = $subpanel_id;
        $this->parent_record_id = $record_id;
        $this->parent_module = $module;
        $this->layout_def_key = $layout_def_key;
        $this->collections = $collections;

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
        $this->buildSearchQuery();
        if (empty($subpanelDef)) {
            //load the subpanel by name.
            if (!class_exists('MyClass')) {
                require_once 'custom/include/SubPanel/SubPanelDefinitions.php' ;
            }
            $panelsdef=new CustomSubPanelDefinitions($result,$layout_def_key);
            $subpanelDef=$panelsdef->load_subpanel($subpanel_id, false, false, $this->search_query,$collections);
            $this->subpanel_defs=$subpanelDef;

        }
	}

    function get_searchdefs($module)
    {
        $thisPanel =& $this->subpanel_defs;
        $subpanel_defs = $thisPanel->_instance_properties;

        if(isset($subpanel_defs['searchdefs'])){
            $searchdefs[$module]['layout']['basic_search'] = $subpanel_defs['searchdefs'];
            $searchdefs[$module]['templateMeta'] = Array ('maxColumns' => 3, 'maxColumnsBasic' => 4, 'widths' => Array ( 'label' => 10, 'field' => 30 )) ;
            return $searchdefs;
        }

        return false;
    }

    function getSearchForm()
    {
        require_once('custom/include/SubPanel/SubPanelSearchForm.php');

        $module = 'Meetings';

        $seed = new Meeting();

        $searchForm = new SubPanelSearchForm($seed, $module, $this);

        $searchMetaData = $searchForm->retrieveSearchDefs($module);

        if ($subpanel_searchMetaData = $this->get_searchdefs($module)){

            $searchForm->setup($subpanel_searchMetaData, $searchMetaData['searchFields'], 'SubpanelSearchFormGeneric.tpl', 'basic_search');

            if(!empty($this->collections))
                $searchForm->searchFields['collection'] = array();

            $searchForm->populateFromRequest();

            return $searchForm->display();
        }

        return '';
    }

    function buildSearchQuery()
    {
        require_once('custom/include/SubPanel/SubPanelSearchForm.php');

        $module = 'Meetings';

        $seed = new Meeting();

        $_REQUEST['searchFormTab'] = 'basic_search';
        $searchForm = new SubPanelSearchForm($seed, $module, $this);

        $searchMetaData = $searchForm->retrieveSearchDefs($module);
        $searchForm->setup($searchMetaData['searchdefs'], $searchMetaData['searchFields'], 'SubpanelSearchFormGeneric.tpl', 'basic_search');

        $searchForm->populateFromRequest();

        $where_clauses = $searchForm->generateSearchWhere(true, $seed->module_dir);

        if (count($where_clauses) > 0 )$this->search_query = '('. implode(' ) AND ( ', $where_clauses) . ')';
        $GLOBALS['log']->info("Subpanel Where Clause: $this->search_query");

        return print_r($where_clauses,true);
    }

    function ProcessSubPanelListView($xTemplatePath, &$mod_strings)
    {
        global $app_strings;
        global $current_user;
        global $sugar_config;

        if(isset($this->listview)){
            $ListView =& $this->listview;
        }else{
            $ListView = new ListView();
        }
        $ListView->initNewXTemplate($xTemplatePath,$this->subpanel_defs->mod_strings);
        $ListView->xTemplateAssign("RETURN_URL", "&return_module=".$this->parent_module."&return_action=DetailView&return_id=".$this->parent_bean->id);
        $ListView->xTemplateAssign("RELATED_MODULE", $this->parent_module);  // TODO: what about unions?
        $ListView->xTemplateAssign("RECORD_ID", $this->parent_bean->id);
        $ListView->xTemplateAssign("EDIT_INLINE_PNG", SugarThemeRegistry::current()->getImage('edit_inline','align="absmiddle"  border="0"',null,null,'.gif',$app_strings['LNK_EDIT']));
        $ListView->xTemplateAssign("DELETE_INLINE_PNG", SugarThemeRegistry::current()->getImage('delete_inline','align="absmiddle" border="0"',null,null,'.gif',$app_strings['LBL_DELETE_INLINE']));
        $ListView->xTemplateAssign("REMOVE_INLINE_PNG", SugarThemeRegistry::current()->getImage('delete_inline','align="absmiddle" border="0"',null,null,'.gif',$app_strings['LBL_ID_FF_REMOVE']));
        $header_text= '';

        $ListView->xTemplateAssign("SUBPANEL_ID", $this->subpanel_id);
        $ListView->xTemplateAssign("SUBPANEL_SEARCH", $this->getSearchForm());
        $display_sps = '';
        if($this->search_query == '' && empty($this->collections)) $display_sps = 'display:none';
        $ListView->xTemplateAssign("DISPLAY_SPS",$display_sps);

        if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace']))
        {
            $exploded = explode('/', $xTemplatePath);
            $file_name = $exploded[sizeof($exploded) - 1];
            $mod_name =  $exploded[sizeof($exploded) - 2];
            $header_text= "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=$file_name&from_module=$mod_name&mod_lang="
                .$_REQUEST['module']."'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif','Edit Layout')."</a>";
        }
        $ListView->setHeaderTitle('');
        $ListView->setHeaderText('');

        ob_start();

        $ListView->is_dynamic = true;
        $ListView->records_per_page = $sugar_config['list_max_entries_per_subpanel'] + 0;
        if (isset($this->subpanel_defs->_instance_properties['records_per_page'])) {
            $ListView->records_per_page = $this->subpanel_defs->_instance_properties['records_per_page'] + 0;
        }
        $ListView->start_link_wrapper = "javascript:showSubPanel('".$this->subpanel_id."','";
        $ListView->subpanel_id = $this->subpanel_id;
        $ListView->end_link_wrapper = "',true);";
        if ( !empty($this->layout_def_key) ) {
            $ListView->end_link_wrapper = '&layout_def_key='.$this->layout_def_key.$ListView->end_link_wrapper;
        }

        $where = '';
        $ListView->setQuery($where, '', '', '');
        $ListView->show_export_button = false;

        //function returns the query that was used to populate sub-panel data.

        $query=$ListView->process_dynamic_listview($this->parent_module, $this->parent_bean,$this->subpanel_defs);
        $this->subpanel_query=$query;
        $ob_contents = ob_get_contents();
        ob_end_clean();
        return $ob_contents;
    }

    function display()
    {
        $result_array = array();

        $return_string = $this->ProcessSubPanelListView($this->template_file,$result_array);

        print $return_string;
    }

}

?>