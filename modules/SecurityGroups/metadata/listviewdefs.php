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



$module_name = 'SecurityGroups';
$listViewDefs[$module_name] = array(
	'NAME' => array(
		'width' => '32', 
		'label' => 'LBL_NAME', 
		'default' => true,
        'link' => true),         






	'ASSIGNED_USER_NAME' => array(
		'width' => '9', 
		'label' => 'LBL_ASSIGNED_TO_NAME',
        'default' => true),
        
	'NONINHERITABLE' => array(
		'width' => '9', 
		'label' => 'LBL_NONINHERITABLE',
        'default' => true),
	
);
?>
