<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $sugar_config;
require_once('XTemplate/xtpl.php');
$xtpl=new XTemplate('modules/SecurityGroups/info.html');
$xtpl->assign("sugar_version", $sugar_config['sugar_version']);
$xtpl->parse("main");
$xtpl->out("main");
