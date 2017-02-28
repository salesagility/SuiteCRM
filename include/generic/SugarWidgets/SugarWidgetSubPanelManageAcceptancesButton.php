<?php

if (!defined('sugarEntry') || !sugarEntry || !defined('SUGAR_ENTRY') || !SUGAR_ENTRY) {
    die('Not A Valid Entry Point');
}
if (defined('sugarEntry')) {
    $deprecatedMessage = 'sugarEntry is deprecated use SUGAR_ENTRY instead';
    if (isset($GLOBALS['log'])) {
        $GLOBALS['log']->deprecated($deprecatedMessage);
    } else {
        trigger_error($deprecatedMessage, E_USER_DEPRECATED);
    }
}


require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelManageAcceptancesButton extends SugarWidgetSubPanelTopButton
{
    
    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings;
        
        $button  = "<form id='ManageAcceptancesForm' name='ManageAcceptancesForm' method='post' action=''>";
       // $button .= "<input id='custom_hidden_5' type='hidden' name='custom_hidden_5' value=''/>";
        $button .= "<input id='Manage_Acceptances' class='button' type='button' name='Manage_Acceptances' onclick='manage_acceptances();' value='".$mod_strings['LBL_MANAGE_ACCEPTANCES']."'/>\n</form>";
        return $button;
    }
}