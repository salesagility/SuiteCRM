<?php

use SuiteCRM\api\v8\controller;
use Firebase\JWT\JWT;

return [
    controller\UtilityController::class => function ($container) {
        /** @var \Interop\Container\ContainerInterface $container */
        return new Controller\UtilityController(
            $container->get('sugar_config'),
            $container->get('cookie'),
            $container->get('current_user'),
            $container->get(AuthenticationController::class),
            $container->get(JWT::class)
        );
    },
    JWT::class => function ($container) {
        return new JWT();
    },
    AuthenticationController::class => function ($container) {
        require_once 'modules/Users/authentication/AuthenticationController.php';
        return new AuthenticationController();
    },
    'translations-config' => function ($container) {
        global $app_list_strings;
        return $app_list_strings;
    },
    'current_user' => function ($container) {
        global $current_user;
        return $current_user;
    },
    'sugar_config' => function ($container) {
        global $sugar_config;
        return $sugar_config;
    },
    'jwt' => function ($container) {
        return new stdClass();
    },
    'cookie' => function ($container) {
        $request = $container->get('request');
        return new \Slim\Http\Cookies($request->getCookieParams());
    },
];
