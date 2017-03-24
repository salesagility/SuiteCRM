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


$dashletMeta['jjwg_AreasDashlet'] = array('module' => 'jjwg_Areas',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'jjwg_Areas'),
    'description' => 'A customizable view into jjwg_Areas',
    'icon' => 'icon_jjwg_Areas_32.gif',
    'category' => 'Module Views');