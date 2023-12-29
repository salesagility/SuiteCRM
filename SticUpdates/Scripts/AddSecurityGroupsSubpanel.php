<?php

/**
 * 
 * This script is in charge of adding, if it's hidden, the subpanel of securitygroup globally to all modules.
 */

global $current_user;
$current_user->getSystemUser();
require_once('include/SubPanel/SubPanelDefinitions.php');
echo 'Removing Security Groups subpanel from the hidden subpanels ----> Start <br>';
$GLOBALS['log']->debug('Removing Security Groups subpanel from the hidden subpanels', SubPanelDefinitions::get_hidden_subpanels());
$hiddenSubpanels = SubPanelDefinitions::get_hidden_subpanels();
if ($hiddenSubpanels['securitygroups']) {
    echo 'SecurityGroups Subpanel hidden, removing... <br>';
    unset($hiddenSubpanels['securitygroups']);
    SubPanelDefinitions::set_hidden_subpanels($hiddenSubpanels);
    echo 'SecurityGroups Subpanel removed from the hidden subpanels <br>';
}
echo 'Removing Security Groups subpanel from the hidden subpanels -----> Done <br>';