<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelManageDelegatesButton extends SugarWidgetSubPanelTopButton
{
    
    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings;
        
        $button  = "<form id='ManageDelegatesForm' name='ManageDelegatesForm' method='post' action=''>";
       // $button .= "<input id='custom_hidden_5' type='hidden' name='custom_hidden_5' value=''/>";
        $button .= "<input id='Manage_Delegates' class='button' type='button' name='Manage_Delegates' onclick='manage_delegates()' value='".$mod_strings['LBL_MANAGE_DELEGATES']."'/>\n</form>";
        return $button;
    }
}