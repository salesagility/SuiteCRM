<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


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
