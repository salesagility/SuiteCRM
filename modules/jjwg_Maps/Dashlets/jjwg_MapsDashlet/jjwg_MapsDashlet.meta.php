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


$dashletMeta['jjwg_MapsDashlet'] = array('module' => 'jjwg_Maps',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'jjwg_Maps'),
    'description' => 'A customizable view into jjwg_Maps',
    'icon' => 'icon_jjwg_Maps_32.gif',
    'category' => 'Module Views');