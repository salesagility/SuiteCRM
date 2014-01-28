<?php
$admin_option_defs = array();
$admin_option_defs['Administration']['colourselector'] = array(
    'themeadmin',
    'LBL_COLOUR_SETTINGS',
    'LBL_COLOUR_DESC',
    './index.php?module=Administration&action=colourAdmin'
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