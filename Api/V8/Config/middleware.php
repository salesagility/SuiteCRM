<?php

use Api\V8\Middleware\AuthMiddleware;
use League\OAuth2\Server\ResourceServer;
use Slim\App;

return [
    'AuthMiddleware' => function (App $app) {
        return new AuthMiddleware(
            $app->getContainer()->get(ResourceServer::class)
        );
    },
];
