<?php

$admin_option_defs = array();
$admin_option_defs['Administration']['sharedrules_settings'] = array(
    'icon_SugarFeed',
    'LBL_SHAREDRULES_SETTINGS',
    'LBL_SHAREDRULES_SETTINGS_DESC',
    './index.php?module=SharedSecurityRules&action=index'
);
if (isset($admin_group_header[0])) {
    $admin_option_defs =
        array_merge(
            (array)$admin_option_defs['Administration'],
            (array)$admin_group_header[0][3]['Administration']
        );
}

$admin_group_header[0][3]['Administration'] = $admin_option_defs;


?>