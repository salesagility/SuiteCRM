<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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
