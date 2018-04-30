<?php

use Api\V8\Controller;
use Api\V8\Service\LogoutService;
use Api\V8\Service\ModuleService;
use Api\V8\Service\RelationshipService;
use Interop\Container\ContainerInterface as Container;

return [
    Controller\ModuleController::class => function (Container $container) {
        return new Controller\ModuleController(
            $container->get(ModuleService::class)
        );
    },
    Controller\LogoutController::class => function (Container $container) {
        return new Controller\LogoutController(
            $container->get(LogoutService::class),
            $container->get(\League\OAuth2\Server\ResourceServer::class)
        );
    },
    Controller\RelationshipController::class => function (Container $container) {
        return new Controller\RelationshipController(
            $container->get(RelationshipService::class)
        );
    },
];
