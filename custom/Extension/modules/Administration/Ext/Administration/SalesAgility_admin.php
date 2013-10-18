<?php

$admin_option_defs=array();
$admin_option_defs['Administration']['reschedule']= array('Calls_Reschedule','LBL_RESCHEDULE_ADMIN','LBL_RESCHEDULE_ADMIN_DESC','./index.php?module=Administration&action=Reschedule_admin');

if (isset($admin_group_header['sagility']))  $admin_option_defs['Administration'] = array_merge((array)$admin_option_defs['Administration'], (array)$admin_group_header['sagility'][3]['Administration']);

$admin_group_header['sagility'] = array(
    'LBL_SALESAGILITY_ADMIN',
    '',
    false,
    $admin_option_defs,
    ''
);


?>
