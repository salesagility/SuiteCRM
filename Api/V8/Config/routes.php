<?php

use Api\V8\Controller\LogoutController;
use Api\V8\Factory\ParamsMiddlewareFactory;
use Api\V8\Param\CreateModuleParams;
use Api\V8\Param\CreateRelationshipParams;
use Api\V8\Param\DeleteModuleParams;
use Api\V8\Param\DeleteRelationshipParams;
use Api\V8\Param\GetModuleParams;
use Api\V8\Param\GetModulesParams;
use Api\V8\Param\GetRelationshipParams;
use Api\V8\Param\UpdateModuleParams;
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
            ->add($paramsMiddlewareFactory->bind(GetModulesParams::class));

        /**
         * Get a module record
         */
        $this
            ->get('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:getModuleRecord')
            ->add($paramsMiddlewareFactory->bind(GetModuleParams::class));

        /**
         * Create a module record
         */
        $this
            ->post('/module', 'Api\V8\Controller\ModuleController:createModuleRecord')
            ->add($paramsMiddlewareFactory->bind(CreateModuleParams::class));

        /**
         * Update a module record
         */
        $this
            ->patch('/module', 'Api\V8\Controller\ModuleController:updateModuleRecord')
            ->add($paramsMiddlewareFactory->bind(UpdateModuleParams::class));

        /**
         * Delete a module record
         */
        $this
            ->delete('/module/{moduleName}/{id}', 'Api\V8\Controller\ModuleController:deleteModuleRecord')
            ->add($paramsMiddlewareFactory->bind(DeleteModuleParams::class));

        /**
         * Get relationships
         */
        $this
            ->get(
                '/module/{moduleName}/{id}/relationships/{relationshipName}',
                'Api\V8\Controller\RelationshipController:getRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(GetRelationshipParams::class));

        /**
         * Create relationship
         */
        $this
            ->post(
                '/module/{moduleName}/{id}/relationships',
                'Api\V8\Controller\RelationshipController:createRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(CreateRelationshipParams::class));

        /**
         * Delete relationship
         */
        $this
            ->delete(
                '/module/{moduleName}/{id}/relationships',
                'Api\V8\Controller\RelationshipController:deleteRelationship'
            )
            ->add($paramsMiddlewareFactory->bind(DeleteRelationShipParams::class));

    })->add(new ResourceServerMiddleware($app->getContainer()->get(ResourceServer::class)));
});
