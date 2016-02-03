<?php

$app->get('/language_definition', 'SuiteCRM\Controller\ModuleController:getLanguageDefinition');
$app->get('/available_modules', 'SuiteCRM\Controller\ModuleController:getAvailableModules');
$app->get('/last_viewed', 'SuiteCRM\Controller\ModuleController:getLastViewed');
$app->get('/module_fields/{module}', 'SuiteCRM\Controller\ModuleController:getModuleFieldList');
$app->get('/module_links/{module}', 'SuiteCRM\Controller\ModuleController:getModuleLinks');
$app->get('/module_layout', 'SuiteCRM\Controller\ModuleController:getModuleLayout');
$app->get('/{module}/{id}', 'SuiteCRM\Controller\ModuleController:getModuleById');

$app->delete('/{module}/{id}', 'SuiteCRM\Controller\ModuleController:deleteModule');
$app->put('/{module}/{id}', 'SuiteCRM\Controller\ModuleController:updateModule');
$app->post('/{module}', 'SuiteCRM\Controller\ModuleController:createModule');





