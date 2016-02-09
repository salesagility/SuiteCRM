<?php

$app->group('/V8',function() use ($app){
    $app->get('/module/{module_name}', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleRecords');
    $app->get('/available_modules', 'SuiteCRM\Api\V8\Controller\ModuleController:getAvailableModules');
    $app->get('/module_layout', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleLayout');
    $app->get('/module_links', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleLinks');
    $app->get('/module_fields/{module}', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleFields');
});