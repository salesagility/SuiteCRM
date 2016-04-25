<?php

$app->group('/V8/module', function () use ($app) {

    $app->get('', 'SuiteCRM\Api\V8\Controller\ModuleController:getModules');
    $app->get('/menu', 'SuiteCRM\Api\V8\Controller\ModuleController:getModulesMenu');
    $app->get('/viewed', 'SuiteCRM\Api\V8\Controller\ModuleController:getRecordsViewed');
    $app->get('/favorites', 'SuiteCRM\Api\V8\Controller\ModuleController:getFavorites');
    
    $app->group('/{module}', function () use ($app) {

        $app->get('', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleRecords');
        $app->post('', 'SuiteCRM\Api\V8\Controller\ModuleController:createModuleRecord');

        $app->get('/language', 'SuiteCRM\Api\V8\Controller\ModuleController:getLanguageDefinition');
        $app->get('/fields', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleFields');
        $app->get('/links', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleLinks');
        $app->get('/menu', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleMenu');
        $app->get('/viewed', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleRecordsViewed');
        $app->get('/favorites', 'SuiteCRM\Api\V8\Controller\ModuleController:getModuleFavorites');

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
        $app->put('/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:updateModuleRecord');
        $app->delete('/{id}', 'SuiteCRM\Api\V8\Controller\ModuleController:deleteModuleRecord');

    });
});