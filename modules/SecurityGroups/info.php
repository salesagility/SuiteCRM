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


global $sugar_config;
require_once('XTemplate/xtpl.php');
$xtpl=new XTemplate ('modules/SecurityGroups/info.html');				
$xtpl->assign("sugar_version", $sugar_config['sugar_version']);
$xtpl->parse("main");
$xtpl->out("main");

