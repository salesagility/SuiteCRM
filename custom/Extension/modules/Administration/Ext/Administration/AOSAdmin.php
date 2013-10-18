<?php
$admin_option_defs = array();
$admin_option_defs['Administration']['aos'] = array(
    'edit',
    'AOS Settings',
    'Change settings for Advanced OpenSales',
    './index.php?module=Administration&action=AOSAdmin'
);

if (isset($admin_group_header['sagility']))  $admin_option_defs['Administration'] = array_merge((array)$admin_option_defs['Administration'], (array)$admin_group_header['sagility'][3]['Administration']);

$admin_group_header['sagility'] = array(
    'LBL_SALESAGILITY_ADMIN',
    '',
    false,
    $admin_option_defs,
    ''
);
?>