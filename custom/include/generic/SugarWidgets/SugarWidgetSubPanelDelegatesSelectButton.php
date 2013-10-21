<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelDelegatesSelectButton extends SugarWidgetSubPanelTopButton
{
    
    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings;
        $button = "<script src='custom/include/javascript/checkbox.js' type='text/javascript'></script>";
        $button  .= "<form id='CustSelectForm' name='CustSelectForm' method='post' action=''>";

       // $button .= "<input id='custom_hidden_5' type='hidden' name='custom_hidden_5' value=''/>";
        $button .= "<input id='Custom_Select' class='button' type='button' name='Custom_Select' onclick='select_targets()' value='".$mod_strings['LBL_SELECT_DELEGATES']."'/>\n</form>";	

        return $button;
    }
}
