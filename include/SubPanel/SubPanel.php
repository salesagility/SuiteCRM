<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

require_once('include/SubPanel/registered_layout_defs.php');
/**
 * Subpanel
 * @api
 */
class SubPanel
{
	var $hideNewButton = false;
	var $subpanel_id;
	var $parent_record_id;
	var $parent_module;  // the name of the parent module
	var $parent_bean;  // the instantiated bean of the parent
	var $template_file;
	var $linked_fields;
	var $action = 'DetailView';
	var $show_select_button = true;
	var $subpanel_define = null;  // contains the layout_def.php
	var $subpanel_defs;
	var $subpanel_query=null;
    var $layout_def_key='';
	function SubPanel($module, $record_id, $subpanel_id, $subpanelDef, $layout_def_key='')
	{
		global $theme, $beanList, $beanFiles, $focus, $app_strings;

		$this->subpanel_defs=$subpanelDef;
		$this->subpanel_id = $subpanel_id;
		$this->parent_record_id = $record_id;
		$this->parent_module = $module;
        $this->layout_def_key = $layout_def_key;

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
				require_once 'include/SubPanel/SubPanelDefinitions.php' ;
			}
			$panelsdef=new SubPanelDefinitions($result,$layout_def_key);
			$subpanelDef=$panelsdef->load_subpanel($subpanel_id);
			$this->subpanel_defs=$subpanelDef;

		}

	}

	function setTemplateFile($template_file)
	{
		$this->template_file = $template_file;
	}

	function setBeanList(&$value){
		$this->bean_list =$value;
	}

	function setHideNewButton($value){
		$this->hideNewButton = $value;
	}


	function getHeaderText( $currentModule){
	}

	function get_buttons( $panel_query=null)
	{

		$thisPanel =& $this->subpanel_defs;
		$subpanel_def = $thisPanel->get_buttons();

		if(!isset($this->listview)){
			$this->listview = new ListView();
		}
		$layout_manager = $this->listview->getLayoutManager();
		$widget_contents = '<div><table cellpadding="0" cellspacing="0"><tr>';
		foreach($subpanel_def as $widget_data)
		{
			$widget_data['action'] = $_REQUEST['action'];
			$widget_data['module'] =  $thisPanel->get_inst_prop_value('module');
			$widget_data['focus'] = $this->parent_bean;
			$widget_data['subpanel_definition'] = $thisPanel;
			$widget_contents .= '<td style="padding-right: 2px; padding-bottom: 2px;">' . "\n";

			if(empty($widget_data['widget_class']))
			{
				$widget_contents .= "widget_class not defined for top subpanel buttons";
			}
			else
			{
				$widget_contents .= $layout_manager->widgetDisplay($widget_data);
			}

			$widget_contents .= '</td>';
		}

		$widget_contents .= '</tr></table></div>';
		return $widget_contents;
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
		global $timedate;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		global $beanList;
		global $beanFiles;
		global $current_language;

		$result_array = array();

		$return_string = $this->ProcessSubPanelListView($this->template_file,$result_array);

		print $return_string;
	}

	function getModulesWithSubpanels()
	{
		global $beanList;
		$dir = dir('modules');
		$modules = array();
		while($entry = $dir->read())
		{
			if(file_exists('modules/' . $entry . '/layout_defs.php'))
			{
				$modules[$entry] = $entry;
			}
		}
		return $modules;
	}

  function getModuleSubpanels($module){
  	require_once('include/SubPanel/SubPanelDefinitions.php');
  		global $beanList, $beanFiles;
  		if(!isset($beanList[$module])){
  			return array();
  		}

  		$class = $beanList[$module];
  		require_once($beanFiles[$class]);
  		$mod = new $class();
  		$spd = new SubPanelDefinitions($mod);
  		$tabs = $spd->get_available_tabs(true);
  		$ret_tabs = array();
  		$reject_tabs = array('history'=>1, 'activities'=>1);
  		foreach($tabs as $key=>$tab){
  		    foreach($tab as $k=>$v){
                if (! isset ( $reject_tabs [$k] )) {
                    $ret_tabs [$k] = $v;
                }
            }
  		}

  		return $ret_tabs;


  }

  //saves overrides for defs
  function saveSubPanelDefOverride( $panel, $subsection, $override){
  		global $layout_defs, $beanList;

  		//save the new subpanel
  		$name = "subpanel_layout['list_fields']";

  		//bugfix: load looks for moduleName/metadata/subpanels, not moduleName/subpanels
  		$path = 'custom/modules/'. $panel->_instance_properties['module'] . '/metadata/subpanels';

  		//bug# 40171: "Custom subpanels not working as expected"
  		//each custom subpanel needs to have a unique custom def file
  		$filename = $panel->parent_bean->object_name . "_subpanel_" . $panel->name; //bug 42262 (filename with $panel->_instance_properties['get_subpanel_data'] can create problem if had word "function" in it)
  		$oldName1 = '_override' . $panel->parent_bean->object_name .$panel->_instance_properties['module'] . $panel->_instance_properties['subpanel_name'] ;
  		$oldName2 = '_override' . $panel->parent_bean->object_name .$panel->_instance_properties['get_subpanel_data'] ;
  		if (file_exists('custom/Extension/modules/'. $panel->parent_bean->module_dir . "/Ext/Layoutdefs/$oldName1.php")){
  		  unlink('custom/Extension/modules/'. $panel->parent_bean->module_dir . "/Ext/Layoutdefs/$oldName1.php");
  		}
  		if (file_exists('custom/Extension/modules/'. $panel->parent_bean->module_dir . "/Ext/Layoutdefs/$oldName2.php")){
         unlink('custom/Extension/modules/'. $panel->parent_bean->module_dir . "/Ext/Layoutdefs/$oldName2.php");
  		}
  		$extname = '_override'.$filename;
  		//end of bug# 40171

  		mkdir_recursive($path, true);
  		write_array_to_file( $name, $override,$path.'/' . $filename .'.php');

  		//save the override for the layoutdef
        //tyoung 10.12.07 pushed panel->name to lowercase to match case in subpaneldefs.php files -
        //gave error on bad index 'module' as this override key didn't match the key in the subpaneldefs
  		$name = "layout_defs['".  $panel->parent_bean->module_dir. "']['subpanel_setup']['" .strtolower($panel->name). "']";
//  	$GLOBALS['log']->debug('SubPanel.php->saveSubPanelDefOverride(): '.$name);
  		$newValue = override_value_to_string($name, 'override_subpanel_name', $filename);
  		mkdir_recursive('custom/Extension/modules/'. $panel->parent_bean->module_dir . '/Ext/Layoutdefs', true);
  		$fp = sugar_fopen('custom/Extension/modules/'. $panel->parent_bean->module_dir . "/Ext/Layoutdefs/$extname.php", 'w');
  		fwrite($fp, "<?php\n//auto-generated file DO NOT EDIT\n$newValue\n?>");
  		fclose($fp);
  		require_once('ModuleInstall/ModuleInstaller.php');
  		$moduleInstaller = new ModuleInstaller();
  		$moduleInstaller->silent = true; // make sure that the ModuleInstaller->log() function doesn't echo while rebuilding the layoutdefs
  		$moduleInstaller->rebuild_layoutdefs();
  		if (file_exists('modules/'.  $panel->parent_bean->module_dir . '/layout_defs.php'))
  			include('modules/'.  $panel->parent_bean->module_dir . '/layout_defs.php');
  		if (file_exists('custom/modules/'.  $panel->parent_bean->module_dir . '/Ext/Layoutdefs/layoutdefs.ext.php'))
  			include('custom/modules/'.  $panel->parent_bean->module_dir . '/Ext/Layoutdefs/layoutdefs.ext.php');
  }

	function get_subpanel_setup($module)
	{
		$subpanel_setup = '';
		$layout_defs = get_layout_defs();

		if(!empty($layout_defs) && !empty($layout_defs[$module]['subpanel_setup']))
      {
      	$subpanel_setup = $layout_defs[$module]['subpanel_setup'];
      }

      return $subpanel_setup;
	}

	/**
	 * Retrieve the subpanel definition from the registered layout_defs arrays.
	 */
	function getSubPanelDefine($module, $subpanel_id)
	{
		$default_subpanel_define = SubPanel::_get_default_subpanel_define($module, $subpanel_id);
		$custom_subpanel_define = SubPanel::_get_custom_subpanel_define($module, $subpanel_id);

		$subpanel_define = array_merge($default_subpanel_define, $custom_subpanel_define);

		if(empty($subpanel_define))
		{
			print('Could not load subpanel definition for: ' . $subpanel_id);
		}

		return $subpanel_define;
	}

	function _get_custom_subpanel_define($module, $subpanel_id)
	{
		$ret_val = array();

		if($subpanel_id != '')
		{
			$layout_defs = get_layout_defs();

			if(!empty($layout_defs[$module]['custom_subpanel_defines'][$subpanel_id]))
			{
				$ret_val = $layout_defs[$module]['custom_subpanel_defines'][$subpanel_id];
			}
		}

		return $ret_val;
	}

	function _get_default_subpanel_define($module, $subpanel_id)
	{
		$ret_val = array();

		if($subpanel_id != '')
		{
	  		$layout_defs = get_layout_defs();

			if(!empty($layout_defs[$subpanel_id]['default_subpanel_define']))
			{
				$ret_val = $layout_defs[$subpanel_id]['default_subpanel_define'];
			}
		}

		return $ret_val;
	}
}
?>
