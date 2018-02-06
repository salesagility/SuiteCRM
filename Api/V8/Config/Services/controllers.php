<?php

use Api\V8\Controller;
use Api\V8\Service\ModuleService;
use Interop\Container\ContainerInterface as Container;

return [
    Controller\UtilityController::class => function () {
        return new Controller\UtilityController();
    },
    Controller\LoginController::class => function (Container $container) {
        return new Controller\LoginController(
            $container->get(AuthenticationController::class),
            $container->get(\Firebase\JWT\JWT::class),
            $container->get('cookie'),
            $container->get('currentUser'),
            $container->get('suiteConfig')
        );
    },
    Controller\ModuleController::class => function (Container $container) {
        return new Controller\ModuleController(
            $container->get(ModuleService::class)
        );
    },
    AuthenticationController::class => function () {
        require_once SUGAR_PATH . '/modules/Users/authentication/AuthenticationController.php';
        return new AuthenticationController();
    },
];
