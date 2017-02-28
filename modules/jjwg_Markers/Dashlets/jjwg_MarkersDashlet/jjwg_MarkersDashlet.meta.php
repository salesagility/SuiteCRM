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

 
$dashletMeta['jjwg_MarkersDashlet'] = array('module' => 'jjwg_Markers',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'jjwg_Markers'),
    'description' => 'A customizable view into jjwg_Markers',
    'icon' => 'icon_jjwg_Markers_32.gif',
    'category' => 'Module Views');
