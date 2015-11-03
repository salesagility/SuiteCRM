<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * SugarWidgetSubPanelTopFilterButton.php
 * @author SalesAgility <support@salesagility.com>
 * Date: 27/01/14
 */

class SugarWidgetSubPanelTopFilterButton  extends SugarWidgetSubPanelTopButton{

    function display($defines)
    {
        global $app_strings;

        $button = "<script src='custom/include/SubPanel/SubPanel.js'></script>";

        $button .= "<input class='button' type='button'  value='".$app_strings['LBL_SUBPANEL_FILTER_LABEL']."'  id='". $this->getWidgetId() ."'  name='".$app_strings['LBL_SUBPANEL_FILTER_LABEL']."'  title='".$app_strings['LBL_SUBPANEL_FILTER_LABEL']."' onclick=\"showSearchPanel('history');return false;\" />";

        return $button;
    }

}