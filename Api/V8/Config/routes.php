<?php

use Api\V8\Controller\LogoutController;
use Api\V8\Controller\ModuleController;
use Api\V8\Controller\RelationshipController;
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

        $this->post('/logout', LogoutController::LOGOUT);

        $this
            ->get('/module/{moduleName}', ModuleController::GET_MODULE_RECORDS)
            ->add($paramsMiddlewareFactory->bind(ModuleParams::class));

        $this
            ->get('/module/{moduleName}/{id}', ModuleController::GET_MODULE_RECORD)
            ->add($paramsMiddlewareFactory->bind(ModuleParams::class));

        $this
            ->post('/module/{moduleName}', ModuleController::CREATE_MODULE_RECORD)
            ->add($paramsMiddlewareFactory->bind(ModuleParams::class));

        $this
            ->get('/relationship/{moduleName}', RelationshipController::GET_RELATIONSHIP)
            ->add($paramsMiddlewareFactory->bind(RelationshipParams::class));

    })->add(new ResourceServerMiddleware($app->getContainer()->get(ResourceServer::class)));
});
