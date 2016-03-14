<?php

$app->group('/V8', function () use ($app) {

    $app->group('/module/{module}', function () use ($app) {

        $app->get('', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleRecords');
        $app->post('', 'SuiteCRM\Api\V8\Controller\ModuleController:createModuleItem');

        $app->get('/language', 'SuiteCRM\Api\V8\Controller\ModuleController:getLanguageDefinition');
        $app->get('/fields', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleFields');
        $app->get('/links', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleLinks');

        $app->get('/view/{view}', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleLayout');

        $app->post('/action/{action}', 'SuiteCRM\Api\V8\Controller\ModuleController:runAction');

        $app->post('/{id}/action/{action}', 'SuiteCRM\Api\V8\Controller\ModuleController:runAction');

        $app->get('/{id}/{link}/{related_id}','SuiteCRM\Api\V8\Controller\ModuleController:getRelationship');
        $app->post('/{id}/{link}/{related_id}','SuiteCRM\Api\V8\Controller\ModuleController:createRelationship');
        $app->put('{id}/{link}/{related_id}','SuiteCRM\Api\V8\Controller\ModuleController:updateRelationship');
        $app->delete('/{id}/{link}/{related_id}','SuiteCRM\Api\V8\Controller\ModuleController:deleteRelationship');

        $app->get('/{id}/{link}','SuiteCRM\Api\V8\Controller\ModuleController:getModuleRelationships');
        $app->delete('/{id}/{link}','SuiteCRM\Api\V8\Controller\ModuleController:deleteRelationships');

        $app->get('/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleRecord');
        $app->put('/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:updateModuleItem');
        $app->delete('/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:deleteModuleItem');

    });

    $app->get('/available_modules', 'SuiteCRM\Api\V8\Controller\ModuleController:getAvailableModules');
    $app->get('/last_viewed', 'SuiteCRM\Api\V8\Controller\ModuleController:getLastViewed');
    $app->get('/note_attachment/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:getNoteAttachment');

    $app->post('/convert_lead/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:convertLead');
});