<?php

$app->group('/V8',function() use ($app){
    $app->get('/module/{module_name}', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleRecords');
    $app->get('/get_available_modules', 'SuiteCRM\Api\V8\Controller\ModuleController:getAvailableModules');
});