<?php

require_once 'modules/Configurator/Configurator.php';
$configurator = new Configurator();

if(!array_search('stic_Import_Validation', $configurator->config['addAjaxBannedModules']))
    $configurator->config['addAjaxBannedModules'][] = 'stic_Import_Validation';

if(!array_search('stic_Security_Groups_Rules', $configurator->config['addAjaxBannedModules']))
    $configurator->config['addAjaxBannedModules'][] = 'stic_Security_Groups_Rules';

$configurator->saveConfig();

