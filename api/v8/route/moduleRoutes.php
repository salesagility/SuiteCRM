<?php

$app->group('/v8/module', function () use ($app) {

    $app->get('', 'SuiteCRM\api\v8\controller\ModuleController:getModules');
    $app->get('/menu', 'SuiteCRM\api\v8\controller\ModuleController:getModulesMenu');
    $app->get('/viewed', 'SuiteCRM\api\v8\controller\ModuleController:getRecordsViewed');
    $app->get('/favorites', 'SuiteCRM\api\v8\controller\ModuleController:getFavorites');

    $app->group('/{module}', function () use ($app) {

        $app->get('', 'SuiteCRM\api\v8\controller\ModuleController:getModuleRecords');
        $app->post('', 'SuiteCRM\api\v8\controller\ModuleController:createModuleRecord');

        $app->get('/language', 'SuiteCRM\api\v8\controller\ModuleController:getLanguageDefinition');
        $app->get('/fields', 'SuiteCRM\api\v8\controller\ModuleController:getModuleFields');
        $app->get('/links', 'SuiteCRM\api\v8\controller\ModuleController:getModuleLinks');
        $app->get('/menu', 'SuiteCRM\api\v8\controller\ModuleController:getModuleMenu');
        $app->get('/viewed', 'SuiteCRM\api\v8\controller\ModuleController:getModuleRecordsViewed');
        $app->get('/favorites', 'SuiteCRM\api\v8\controller\ModuleController:getModuleFavorites');

        $app->get('/view/{view}', 'SuiteCRM\api\v8\controller\ModuleController:getModuleLayout');

        $app->post('/action/{action}', 'SuiteCRM\api\v8\controller\ModuleController:runAction');

        $app->post('/{id}/action/{action}', 'SuiteCRM\api\v8\controller\ModuleController:runAction');

        $app->get('/{id}/{link}/{related_id}','SuiteCRM\api\v8\controller\ModuleController:getRelationship');
        $app->post('/{id}/{link}/{related_id}','SuiteCRM\api\v8\controller\ModuleController:createRelationship');
        $app->put('{id}/{link}/{related_id}','SuiteCRM\api\v8\controller\ModuleController:updateRelationship');
        $app->delete('/{id}/{link}/{related_id}','SuiteCRM\api\v8\controller\ModuleController:deleteRelationship');

        $app->get('/{id}/{link}','SuiteCRM\api\v8\controller\ModuleController:getModuleRelationships');
        $app->delete('/{id}/{link}','SuiteCRM\api\v8\controller\ModuleController:deleteRelationships');

        $app->get('/{id}', 'SuiteCRM\api\v8\controller\ModuleController:getModuleRecord');
        $app->put('/{id}', 'SuiteCRM\api\v8\controller\ModuleController:updateModuleRecord');
        $app->delete('/{id}', 'SuiteCRM\api\v8\controller\ModuleController:deleteModuleRecord');

    });
});
