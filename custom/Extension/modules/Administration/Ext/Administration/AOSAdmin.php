<?php
$admin_option_defs = array();
$admin_option_defs['Administration']['aos_settings_link1'] = array(
    'edit',
    'AOS Settings',
    'Change settings for Advanced OpenSales',
    './index.php?module=Administration&action=AOSAdmin'
);
$admin_group_header[] = array(
    'Advanced OpenSales',
    '',
    false,
    $admin_option_defs,
    'Change settings for Advanced OpenSales'
);
?>