<?php

use Api\V8\Controller\LogoutController;
use Api\V8\Factory\ParamsMiddlewareFactory;
use Api\V8\Param;
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
            ->add($paramsMiddlewareFactory->bind(Param\ListViewSearchParams::class));

        $app
            ->get('/listview/columns/{moduleName}', 'Api\V8\Controller\ListViewController:getListViewColumns')
            ->add($paramsMiddlewareFactory->bind(Param\ListViewColumnsParams::class));

        $app->get('/current-user', 'Api\V8\Controller\UserController:getCurrentUser');

        $app->get('/meta/modules', 'Api\V8\Controller\MetaController:getModuleList');

        $app->get('/meta/fields/{moduleName}', 'Api\V8\Controller\MetaController:getFieldList')
            ->add($paramsMiddlewareFactory->bind(Param\GetFieldListParams::class));

        $app
            ->get('/user-preferences/{id}', 'Api\V8\Controller\UserPreferencesController:getUserPreferences')
            ->add($paramsMiddlewareFactory->bind(Param\GetUserPreferencesParams::class));

        /**
         * Get swagger schema
         */
        $app->get('/meta/swagger.json', 'Api\V8\Controller\MetaController:getSwaggerSchema');

        /**
         * Get module records
         */
        $app
            ->get('/module/{moduleName}', 'Api\V8\Controller\ModuleController:getModuleRecords')
            ->add($paramsMiddlewareFactory->bind(Param\GetModulesParams::class));

        /**
         * Get a module record
         */
        $app
            ->get('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:getModuleRecord')
            ->add($paramsMiddlewareFactory->bind(Param\GetModuleParams::class));

        /**
         * Create a module record
         */
        $app
            ->post('/module', 'Api\V8\Controller\ModuleController:createModuleRecord')
            ->add($paramsMiddlewareFactory->bind(Param\CreateModuleParams::class));

        /**
         * Update a module record
         */
        $app
            ->patch('/module', 'Api\V8\Controller\ModuleController:updateModuleRecord')
            ->add($paramsMiddlewareFactory->bind(Param\UpdateModuleParams::class));

        /**
         * Delete a module record
         */
        $app
            ->delete('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:deleteModuleRecord')
            ->add($paramsMiddlewareFactory->bind(Param\DeleteModuleParams::class));

        /**
         * Get relationships
         */
        $app
            ->get(
                '/module/{moduleName}/{id}/relationships/{linkFieldName}',
                'Api\V8\Controller\RelationshipController:getRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(Param\GetRelationshipParams::class));

        /**
         * Create relationship
         */
        $app
            ->post(
                '/module/{moduleName}/{id}/relationships',
                'Api\V8\Controller\RelationshipController:createRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(Param\CreateRelationshipParams::class));

        /**
         * Create relationship by link
         */
        $app
            ->post(
                '/module/{moduleName}/{id}/relationships/{linkFieldName}',
                'Api\V8\Controller\RelationshipController:createRelationshipByLink'
            )
            ->add($paramsMiddlewareFactory->bind(Param\CreateRelationshipByLinkParams::class));

        /**
         * Delete relationship
         */
        $app
            ->delete(
                '/module/{moduleName}/{id}/relationships/{linkFieldName}/{relatedBeanId}',
                'Api\V8\Controller\RelationshipController:deleteRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(Param\DeleteRelationshipParams::class));

        // add custom routes
        $app->group('/custom', function () use ($app) {
            $app = CustomLoader::loadCustomRoutes($app);
        });
    })->add(new ResourceServerMiddleware($app->getContainer()->get(ResourceServer::class)));
});
