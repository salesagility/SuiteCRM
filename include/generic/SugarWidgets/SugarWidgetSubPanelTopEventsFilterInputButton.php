<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelTopEventsFilterInputButton extends SugarWidgetSubPanelTopButton
{
//
//    function display5(&$widget_data) {
//
//        global $app_strings;
//        $subpanel_definition = $widget_data['subpanel_definition'];
//        $subpanel_name = $subpanel_definition->get_name();
//        $module_name = ($_REQUEST['module']?$_REQUEST['module']:'');
//        $id = ($_REQUEST['record']?$_REQUEST['record']:'');
//        $prior_search_params[$subpanel_name] = trim(isset($_REQUEST['search_params'])?$_REQUEST['search_params']:'');
//        $onclick = "current_child_field = '{$subpanel_name}';
//		url='index.php?sugar_body_only=1&module={$module_name}&subpanel={$subpanel_name}&entryPoint=filter_subpanel&inline=1&record={$id}&layout_def_key={$module_name}&search_params=' + escape(document.getElementById('filter_param_' + current_child_field).value) ;
//		showSubPanel('{$subpanel_name}',url,true,'{$module_name}');
//		document.getElementById('show_link_{$subpanel_name}').style.display='none';
//		document.getElementById('hide_link_{$subpanel_name}').style.display='';
//		return false;";
//        $button = <<<EOHTML
//	<form>
//		<input type='text' id='filter_param_{$subpanel_name}' name='search_params' value='{$prior_search_params[$subpanel_name]}'>
//		<input type='submit' onclick="{$onclick}" href='javascript:void(0)' value='{$app_strings['LBL_SEARCH_BUTTON_LABEL']}'>
//		<input type='submit' onclick="document.getElementById('filter_param_' + current_child_field).value = '';{$onclick}" href='javascript:void(0)' value='{$app_strings['LBL_LISTVIEW_ALL']}'>
//	</form>
//EOHTML;
//        return $button;
//
//    }


    function display($defines, $additionalFormFields = NULL, $nonbutton = false)
    {
        global $app_strings;

        $button = "<script src='include/SubPanel/DelegatesSubPanel.js'></script>";
        $id = ($_REQUEST['record']?$_REQUEST['record']:'');
        $button .= "<input class='button' type='button'  value='".$app_strings['LBL_SUBPANEL_FILTER_LABEL']."'  id='". $this->getWidgetId() ."'  name='".$app_strings['LBL_SUBPANEL_FILTER_LABEL']."'  title='".$app_strings['LBL_SUBPANEL_FILTER_LABEL']."' onclick=\"showSearchPanel('delegates', '" . $id . "');return false;\" />";

        return $button;
    }
}