<?php

use Api\V8\Controller\LogoutController;
use Api\V8\Factory\ParamsMiddlewareFactory;
use Api\V8\Param\ModuleParams;
use Api\V8\Param\RelationshipParams;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;

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
        $this->post('/logout', LogoutController::class);

        /**
         * Get module records
         */
        $this
            ->get('/module/{moduleName}', 'Api\V8\Controller\ModuleController:getModuleRecords')
            ->add($paramsMiddlewareFactory->bind(ModuleParams::class));

        /**
         * Get a module record
         */
        $this
            ->get('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:getModuleRecord')
            ->add($paramsMiddlewareFactory->bind(ModuleParams::class));

        /**
         * Create a module record
         */
        $this->post('/module/{moduleName}', 'Api\V8\Controller\ModuleController:createModuleRecord');

        /**
         * Update a module record
         */
        $this->patch('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:updateModuleRecord');

        /**
         * Delete a module record
         */
        $this->delete('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:deleteModuleRecord');

        /**
         * Get a relationship
         */
        $this
            ->get('/relationship/{moduleName}', 'Api\V8\Controller\RelationshipController:getRelationship')
            ->add($paramsMiddlewareFactory->bind(RelationshipParams::class));

    })->add(new ResourceServerMiddleware($app->getContainer()->get(ResourceServer::class)));
});
