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
$table_name = 'securitygroups';
$popupMeta = array('moduleMain' => 'SecurityGroup',
						'varName' => $module_name,
						'orderBy' => $table_name.'.name',
						'whereClauses' => 
							array('name' => $table_name . '.name', 
								),
						    'searchInputs'=> array('name'),
							'listview' => 'modules/' . $module_name. '/metadata/listviewdefs.php',
							'search'   => 'modules/' . $module_name . '/metadata/searchdefs.php',
							
						);
?>
 
 
