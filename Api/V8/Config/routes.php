<?php

use Api\V8\Controller\LogoutController;
use Api\V8\Factory\ParamsMiddlewareFactory;
use Api\V8\Param\CreateModuleParams;
use Api\V8\Param\CreateRelationshipParams;
use Api\V8\Param\DeleteModuleParams;
use Api\V8\Param\GetModuleParams;
use Api\V8\Param\GetModulesParams;
use Api\V8\Param\GetRelationshipParams;
use Api\V8\Param\ListViewColumnsParams;
use Api\V8\Param\ListViewSearchParams;
use Api\V8\Param\UpdateModuleParams;
use Api\V8\Param\GetUserPreferencesParams;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;
use Api\Core\Loader\CustomLoader;

$app->group('', function () use ($app) {
    /**
     * OAuth2 access token
     */
    $app->post('/access_token', function () {
    })->add(new AuthorizationServerMiddleware($app->getContainer()->get(AuthorizationServer::class)));

    $app->group('/V8', function () use ($app) {
        /** @var ParamsMiddlewareFactory $paramsMiddlewareFactory */
        $paramsMiddlewareFactory = $app->getContainer()->get(ParamsMiddlewareFactory::class);

        /**
         * Logout
         */
        $app->post('/logout', LogoutController::class);
        
        $app
            ->get('/search-defs/module/{moduleName}', 'Api\V8\Controller\ListViewSearchController:getModuleSearchDefs')
            ->add($paramsMiddlewareFactory->bind(ListViewSearchParams::class));
        
        $app
            ->get('/listview/columns/{moduleName}', 'Api\V8\Controller\ListViewController:getListViewColumns')
            ->add($paramsMiddlewareFactory->bind(ListViewColumnsParams::class));
        
        $app->get('/current-user', 'Api\V8\Controller\UserController:getCurrentUser');
        
        $app
            ->get('/user-preferences/{id}', 'Api\V8\Controller\UserPreferencesController:getUserPreferences')
            ->add($paramsMiddlewareFactory->bind(GetUserPreferencesParams::class));

        /**
         * Get module records
         */
        $app
            ->get('/module/{moduleName}', 'Api\V8\Controller\ModuleController:getModuleRecords')
            ->add($paramsMiddlewareFactory->bind(GetModulesParams::class));

        /**
         * Get a module record
         */
        $app
            ->get('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:getModuleRecord')
            ->add($paramsMiddlewareFactory->bind(GetModuleParams::class));

        /**
         * Create a module record
         */
        $app
            ->post('/module', 'Api\V8\Controller\ModuleController:createModuleRecord')
            ->add($paramsMiddlewareFactory->bind(CreateModuleParams::class));

        /**
         * Update a module record
         */
        $app
            ->patch('/module', 'Api\V8\Controller\ModuleController:updateModuleRecord')
            ->add($paramsMiddlewareFactory->bind(UpdateModuleParams::class));

        /**
         * Delete a module record
         */
        $app
            ->delete('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:deleteModuleRecord')
            ->add($paramsMiddlewareFactory->bind(DeleteModuleParams::class));

        /**
         * Get relationships
         */
        $app
            ->get(
                '/module/{moduleName}/{id}/relationships/{linkFieldName}',
                'Api\V8\Controller\RelationshipController:getRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(GetRelationshipParams::class));

        /**
         * Create relationship
         */
        $app
            ->post(
                '/module/{moduleName}/{id}/relationships',
                'Api\V8\Controller\RelationshipController:createRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(CreateRelationshipParams::class));

        /**
         * Delete relationship
         */
        $app
            ->delete(
                '/module/{moduleName}/{id}/relationships/{linkFieldName}/{relatedBeanId}',
                'Api\V8\Controller\RelationshipController:deleteRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(DeleteRelationShipParams::class));
        
        // add custom routes        
        $app->group('/custom', function () use ($app) {
            $app = CustomLoader::loadCustomRoutes($app);
        });
        
    })->add(new ResourceServerMiddleware($app->getContainer()->get(ResourceServer::class)));
});

