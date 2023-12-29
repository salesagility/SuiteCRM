<?php

$focus = BeanFactory::newBean('Administration');

$focus->retrieveSettings();

$settings = $focus->settings;

if (strtolower(trim($settings['system_name'])) == 'sugarcrm') {
    $focus->saveSetting('system', 'name', 'SinergiaCRM');
}

