<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $sugar_config;
$xtpl=new \SuiteCRM\XTemplate ('modules/SecurityGroups/info.html');
$xtpl->assign("sugar_version", $sugar_config['sugar_version']);
$xtpl->parse("main");
$xtpl->out("main");

