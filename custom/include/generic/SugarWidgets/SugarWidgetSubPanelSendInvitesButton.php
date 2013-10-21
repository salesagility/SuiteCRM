<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelTopButton.php');

class SugarWidgetSubPanelSendInvitesButton extends SugarWidgetSubPanelTopButton
{
    function display($defines, $additionalFormFields = null)
    {
        global $mod_strings;
        
        $button  = "<form id='ManageAcceptancesForm' name='ManageAcceptancesForm' method='post' action=''>";
       
        $button .= '<input class="button" onclick="document.location=\'index.php?module=FP_events&action=sendinvitemails&record='.$defines['focus']->id.'\'" name="sendinvites" value="'.$mod_strings['LBL_INVITE_PDF'].'" type="button">';
        return $button; 
    }
}