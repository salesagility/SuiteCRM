<?php

use Api\V8\Controller;
use Interop\Container\ContainerInterface as Container;

return [
    Controller\UtilityController::class => function (Container $container) {
        return new Controller\UtilityController(
            $container->get(\League\OAuth2\Server\AuthorizationServer::class)
        );
    },
    AuthenticationController::class => function () {
        require_once SUGAR_PATH . '/modules/Users/authentication/AuthenticationController.php';
        return new AuthenticationController();
    },
];
