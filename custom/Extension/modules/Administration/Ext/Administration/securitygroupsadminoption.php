<?php

$admin_option_defs=array();
$admin_option_defs['Administration']['securitygroup_management']= array('SecurityGroups','LBL_MANAGE_SECURITYGROUPS_TITLE','LBL_MANAGE_SECURITYGROUPS','./index.php?module=SecurityGroups&action=index');
$admin_option_defs['Administration']['securitygroup_config']= array('SecurityGroups','LBL_CONFIG_SECURITYGROUPS_TITLE','LBL_CONFIG_SECURITYGROUPS','./index.php?module=SecurityGroups&action=config');

$admin_option_defs['Administration'] = array_merge((array)$admin_group_header[0][3]['Administration'], (array)$admin_option_defs['Administration']);


$admin_group_header[0]= array('LBL_USERS_TITLE','',false,array_merge((array)$admin_group_header[0][3], (array)$admin_option_defs), 'LBL_USERS_DESC');

?>